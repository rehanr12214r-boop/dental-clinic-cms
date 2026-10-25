<?php

use App\Enums\WhatsAppTemplate;
use App\Models\Appointment;
use App\Models\Setting;
use App\Models\Treatment;
use App\Services\WhatsAppMessageService;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    signInAdmin();
});

function settingsPayload(array $overrides = []): array
{
    return array_merge([
        'clinic_name' => 'Smile Experts Clinic',
        'clinic_address' => '45 River Road, Green District',
        'clinic_phone' => '+964 780 000 0000',
        'doctor_name' => 'Dr. Lina Haddad',
        'google_review_link' => 'https://g.page/r/smile-experts/review',
        'whatsapp_template_confirmation' => 'Hi {patient_name}, confirmed for {date} at {time}.',
        'whatsapp_template_reminder' => 'Reminder for {patient_name} on {date} at {time}.',
        'whatsapp_template_review' => 'Thanks {patient_name}! Review us: {review_link}',
    ], $overrides);
}

it('shows the settings page pre-filled with defaults', function () {
    $this->get(route('admin.settings.index'))
        ->assertOk()
        ->assertSee('Clinic settings')
        ->assertSee('BrightSmile Dental Clinic')
        ->assertSee('Dr. Sara Mahmoud')
        ->assertSee('Booking Confirmation')
        ->assertSee('{patient_name}') // placeholder reference
        ->assertSee('{review_link}');
});

it('shows previously saved values on reload', function () {
    Setting::put(Setting::ClinicName, 'Downtown Dental');

    $this->get(route('admin.settings.index'))
        ->assertOk()
        ->assertSee('Downtown Dental');
});

it('saves clinic details, review link and templates', function () {
    $this->put(route('admin.settings.update'), settingsPayload())
        ->assertRedirect()
        ->assertSessionHas('status');

    expect(Setting::get(Setting::ClinicName))->toBe('Smile Experts Clinic')
        ->and(Setting::get(Setting::DoctorName))->toBe('Dr. Lina Haddad')
        ->and(Setting::get(Setting::ReviewLink))->toBe('https://g.page/r/smile-experts/review')
        ->and(Setting::get(WhatsAppTemplate::Reminder->settingKey()))->toBe('Reminder for {patient_name} on {date} at {time}.');
});

it('validates required fields, urls and templates', function () {
    $this->from(route('admin.settings.index'))
        ->put(route('admin.settings.update'), [
            'clinic_name' => '',
            'clinic_address' => '',
            'clinic_phone' => '',
            'doctor_name' => '',
            'google_review_link' => 'not-a-url',
            'whatsapp_template_confirmation' => '',
            'whatsapp_template_reminder' => '',
        ])
        ->assertSessionHasErrors([
            'clinic_name',
            'clinic_address',
            'clinic_phone',
            'doctor_name',
            'google_review_link',
            'whatsapp_template_confirmation',
            'whatsapp_template_reminder',
            'whatsapp_template_review',
        ]);
});

it('feeds saved settings into new whatsapp messages', function () {
    $this->put(route('admin.settings.update'), settingsPayload())->assertRedirect();

    $appointment = Appointment::factory()->create([
        'patient_name' => 'Mona Saleh',
        'patient_phone' => '+964 770 123 4567',
        'appointment_date' => '2026-10-19',
        'appointment_time' => '17:30',
        'treatment_id' => Treatment::query()->where('name', 'Teeth Cleaning')->firstOrFail()->id,
    ]);

    $message = (new WhatsAppMessageService)->message($appointment, WhatsAppTemplate::Confirmation);

    expect($message)->toBe('Hi Mona Saleh, confirmed for Monday, October 19, 2026 at 5:30 PM.');
});
