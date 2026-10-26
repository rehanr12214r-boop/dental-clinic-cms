<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Models\Setting;
use App\Services\ClinicContentService;
use App\Services\SlotAvailabilityService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly ClinicContentService $content,
        private readonly SlotAvailabilityService $slotAvailability,
    ) {}

    /**
     * The clinic story, values and care team.
     */
    public function about(): View
    {
        $team = array_values(array_filter(
            $this->content->dentists(),
            fn (array $dentist): bool => $dentist['slug'] !== 'lena-torres',
        ));

        return view('about', [
            'team' => $team,
            'workingHours' => $this->slotAvailability->workingHoursSummary(),
        ]);
    }

    /**
     * The public contact and appointment enquiry page.
     */
    public function contact(): View
    {
        return view('contact', [
            'clinicEmail' => Setting::get(Setting::ClinicEmail),
        ]);
    }

    /**
     * Send a contact form submission to the clinic inbox.
     */
    public function sendContact(ContactMessageRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $body = implode("\n", [
            'New website enquiry',
            '',
            'Name: '.$validated['name'],
            'Email: '.$validated['email'],
            'Phone: '.$validated['phone'],
            'Subject: '.$validated['subject'],
            '',
            $validated['message'],
        ]);

        Mail::raw($body, function (Message $message) use ($validated): void {
            $message
                ->to((string) Setting::get(Setting::ClinicEmail))
                ->replyTo($validated['email'], $validated['name'])
                ->subject('Website enquiry: '.$validated['subject']);
        });

        return redirect()
            ->route('contact')
            ->with('status', 'Thank you — your message is on its way. We will be in touch within 24 hours.');
    }
}
