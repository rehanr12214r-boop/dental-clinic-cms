<?php

namespace App\Services;

use App\Enums\WhatsAppTemplate;
use App\Models\Appointment;
use App\Models\Setting;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class WhatsAppMessageService
{
    /**
     * Clinic settings merged over the built-in defaults. Loaded once in
     * the constructor so building many messages stays cheap (no per-row queries).
     *
     * @var array<string, string|null>
     */
    protected array $settings;

    /**
     * The last API error, exposed to the admin dashboard for the failure toast.
     */
    protected ?string $lastError = null;

    public function __construct()
    {
        $this->settings = array_merge(Setting::defaults(), Setting::allKeyed());
    }

    /**
     * Build the ready-to-send message for an appointment: the configured
     * template (or the default one) with all placeholders filled in.
     */
    public function message(Appointment $appointment, WhatsAppTemplate $template): string
    {
        $text = $this->settings[$template->settingKey()] ?? '';

        if (trim((string) $text) === '') {
            $text = $template->defaultTemplate();
        }

        return strtr($text, $this->replacements($appointment));
    }

    /**
     * Send the formatted message directly through Whapi.cloud.
     */
    public function send(Appointment $appointment, WhatsAppTemplate $template): bool
    {
        $this->lastError = null;

        $driver = strtolower(trim((string) config('services.whatsapp.driver', 'whapi')));

        if ($driver !== 'whapi') {
            return $this->fail($appointment, $template, "Unsupported WhatsApp driver [{$driver}].");
        }

        $phone = (string) preg_replace('/\D+/', '', (string) $appointment->patient_phone);

        if ($phone === '') {
            return $this->fail($appointment, $template, 'The appointment does not have a valid patient phone number.');
        }

        $apiUrl = trim((string) config('services.whatsapp.api_url'));
        $token = trim((string) config('services.whatsapp.token'));

        if ($apiUrl === '' || $token === '') {
            return $this->fail($appointment, $template, 'Whapi is not configured. Please set the API URL and token.');
        }

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->asJson()
                ->timeout(15)
                ->post($this->endpoint($apiUrl), [
                    'to' => $phone.'@s.whatsapp.net',
                    'body' => $this->message($appointment, $template),
                ]);
        } catch (Throwable $exception) {
            return $this->fail($appointment, $template, 'Could not reach Whapi.cloud. Please try again.', [
                'exception' => $exception->getMessage(),
            ]);
        }

        if (! $response->successful()) {
            return $this->fail($appointment, $template, $this->errorMessage($response), [
                'status' => $response->status(),
                'response' => $response->json() ?? Str::limit($response->body(), 500),
            ]);
        }

        return true;
    }

    /**
     * The API error from the most recent send attempt, if it failed.
     */
    public function lastError(): ?string
    {
        return $this->lastError;
    }

    /**
     * Click-to-WhatsApp link with the formatted, URL-encoded message.
     */
    public function url(Appointment $appointment, WhatsAppTemplate $template): string
    {
        return $appointment->whatsappUrl($this->message($appointment, $template));
    }

    /**
     * Whapi's text endpoint is /messages/text; WHATSAPP_API_URL is the gateway
     * base URL. A full endpoint supplied in configuration is left untouched.
     */
    protected function endpoint(string $apiUrl): string
    {
        $url = rtrim($apiUrl, '/');

        return str_ends_with($url, '/messages/text') ? $url : $url.'/messages/text';
    }

    /**
     * Extract a useful error message from a failed Whapi response.
     */
    protected function errorMessage(Response $response): string
    {
        $payload = $response->json();
        $error = data_get($payload, 'error.message')
            ?? data_get($payload, 'error')
            ?? data_get($payload, 'message');

        if (is_array($error)) {
            $error = $error['message'] ?? null;
        }

        if (is_string($error) && trim($error) !== '') {
            return trim($error);
        }

        return "Whapi rejected the message (HTTP {$response->status()}).";
    }

    /**
     * Record and log a failed send attempt without leaking the API token.
     *
     * @param  array<string, mixed>  $context
     */
    protected function fail(
        Appointment $appointment,
        WhatsAppTemplate $template,
        string $message,
        array $context = [],
    ): bool {
        $this->lastError = $message;

        Log::error('WhatsApp message could not be sent via Whapi.', [
            'appointment_id' => $appointment->getKey(),
            'template' => $template->value,
            'error' => $message,
            ...$context,
        ]);

        return false;
    }

    /**
     * Placeholder values for the given appointment.
     *
     * @return array<string, string>
     */
    protected function replacements(Appointment $appointment): array
    {
        return [
            '{patient_name}' => $appointment->patient_name,
            '{treatment_name}' => $appointment->treatment?->name ?? 'your dental treatment',
            '{date}' => $appointment->dateLabel('l, F j, Y'),
            '{time}' => $appointment->timeLabel(),
            '{doctor_name}' => (string) ($this->settings[Setting::DoctorName] ?? ''),
            '{clinic_name}' => (string) ($this->settings[Setting::ClinicName] ?? ''),
            '{clinic_address}' => (string) ($this->settings[Setting::ClinicAddress] ?? ''),
            '{clinic_phone}' => (string) ($this->settings[Setting::ClinicPhone] ?? ''),
            '{review_link}' => (string) ($this->settings[Setting::ReviewLink] ?? ''),
        ];
    }
}
