<?php

use App\Enums\WhatsAppTemplate;
use App\Models\Appointment;
use App\Models\Setting;
use App\Models\Treatment;
use App\Services\WhatsAppMessageService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);

    config([
        'services.whatsapp.driver' => 'whapi',
        'services.whatsapp.api_url' => 'https://gate.whapi.cloud/',
        'services.whatsapp.token' => 'test-whapi-token',
    ]);
});

/**
 * A deterministic appointment: Monday, Oct 19 2026 at 5:30 PM,
 * property of {patient_name} Mona Saleh.
 */
function whatsappTestAppointment(array $attributes = []): Appointment
{
    return Appointment::factory()->create([
        'patient_name' => 'Mona Saleh',
        'patient_phone' => '+964 770 123 4567',
        'appointment_date' => '2026-10-19',
        'appointment_time' => '17:30',
        'treatment_id' => Treatment::query()->where('name', 'Teeth Cleaning')->firstOrFail()->id,
        ...$attributes,
    ]);
}

it('fills the booking confirmation template with appointment and clinic details', function () {
    $appointment = whatsappTestAppointment();

    $message = (new WhatsAppMessageService)->message($appointment, WhatsAppTemplate::Confirmation);

    expect($message)->toBe(
        'Hello Mona Saleh, your appointment for Teeth Cleaning is confirmed for Monday, October 19, 2026 at 5:30 PM with Dr. Sara Mahmoud. Clinic Location: 123 Main Street, City Center.'
    );
});

it('fills the reminder and review default templates', function () {
    $appointment = whatsappTestAppointment();
    $service = new WhatsAppMessageService;

    expect($service->message($appointment, WhatsAppTemplate::Reminder))->toBe(
        'Reminder: Your appointment for Teeth Cleaning is scheduled for Monday, October 19, 2026 at 5:30 PM. Please reply YES to confirm or CALL us to reschedule.'
    );

    expect($service->message($appointment, WhatsAppTemplate::Review))->toBe(
        'Thank you for visiting us today, Mona Saleh! Please take 30 seconds to leave us a review: https://g.page/r/your-clinic/review.'
    );
});

it('builds a wa.me url with a digits-only phone and the encoded message', function () {
    $appointment = whatsappTestAppointment();
    $service = new WhatsAppMessageService;

    $url = $service->url($appointment, WhatsAppTemplate::Confirmation);

    expect($url)->toStartWith('https://wa.me/9647701234567?text=');

    parse_str((string) parse_url($url, PHP_URL_QUERY), $query);

    expect($query['text'])->toBe($service->message($appointment, WhatsAppTemplate::Confirmation));
});

it('uses custom templates and clinic settings saved in the database', function () {
    $appointment = whatsappTestAppointment();

    Setting::put(Setting::DoctorName, 'Dr. Hana Yousif');
    Setting::put(Setting::ClinicName, 'Smile Experts Clinic');
    Setting::put(
        WhatsAppTemplate::Confirmation->settingKey(),
        'Custom hello {patient_name} from {doctor_name} at {clinic_name}',
    );

    $service = new WhatsAppMessageService; // reads settings on construction

    expect($service->message($appointment, WhatsAppTemplate::Confirmation))
        ->toBe('Custom hello Mona Saleh from Dr. Hana Yousif at Smile Experts Clinic');
});

it('uses the saved google review link in review requests', function () {
    $appointment = whatsappTestAppointment();

    Setting::put(Setting::ReviewLink, 'https://g.page/r/test-clinic/review');

    $message = (new WhatsAppMessageService)->message($appointment, WhatsAppTemplate::Review);

    expect($message)
        ->toContain('https://g.page/r/test-clinic/review')
        ->toContain('Mona Saleh');
});

it('falls back to the default template when the stored one is blank', function () {
    $appointment = whatsappTestAppointment();

    Setting::put(WhatsAppTemplate::Reminder->settingKey(), '');

    $message = (new WhatsAppMessageService)->message($appointment, WhatsAppTemplate::Reminder);

    expect($message)->toBe(
        'Reminder: Your appointment for Teeth Cleaning is scheduled for Monday, October 19, 2026 at 5:30 PM. Please reply YES to confirm or CALL us to reschedule.'
    );
});

it('exposes every placeholder for the settings page', function () {
    $placeholders = WhatsAppTemplate::placeholders();

    expect($placeholders)->toHaveKeys([
        '{patient_name}',
        '{treatment_name}',
        '{date}',
        '{time}',
        '{doctor_name}',
        '{clinic_name}',
        '{clinic_address}',
        '{clinic_phone}',
        '{review_link}',
    ]);
});

it('sends a formatted message through whapi with a cleaned phone and bearer token', function () {
    Http::fake([
        'gate.whapi.cloud/*' => Http::response(['message' => ['id' => 'wamid.test']], 200),
    ]);

    $appointment = whatsappTestAppointment();
    $service = new WhatsAppMessageService;

    $sent = $service->send($appointment, WhatsAppTemplate::Confirmation);

    expect($sent)->toBeTrue()
        ->and($service->lastError())->toBeNull();

    Http::assertSent(function (Request $request) use ($appointment, $service): bool {
        return $request->method() === 'POST'
            && $request->url() === 'https://gate.whapi.cloud/messages/text'
            && $request->hasHeader('Authorization', 'Bearer test-whapi-token')
            && $request['to'] === '9647701234567@s.whatsapp.net'
            && $request['body'] === $service->message($appointment, WhatsAppTemplate::Confirmation);
    });
});

it('returns false and logs when whapi rejects a message', function () {
    Log::spy();

    Http::fake([
        'gate.whapi.cloud/*' => Http::response(['error' => ['message' => 'Invalid or expired token']], 401),
    ]);

    $service = new WhatsAppMessageService;
    $sent = $service->send(whatsappTestAppointment(), WhatsAppTemplate::Reminder);

    expect($sent)->toBeFalse()
        ->and($service->lastError())->toBe('Invalid or expired token');

    Log::shouldHaveReceived('error')->once();
});

it('returns false and logs when whapi cannot be reached', function () {
    Log::spy();

    Http::fake([
        'gate.whapi.cloud/*' => Http::failedConnection(),
    ]);

    $service = new WhatsAppMessageService;
    $sent = $service->send(whatsappTestAppointment(), WhatsAppTemplate::Review);

    expect($sent)->toBeFalse()
        ->and($service->lastError())->toBe('Could not reach Whapi.cloud. Please try again.');

    Log::shouldHaveReceived('error')->once();
});
