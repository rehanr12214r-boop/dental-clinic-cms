<?php

namespace App\Http\Controllers\Admin;

use App\Enums\WhatsAppTemplate;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show the clinic configuration page: clinic details, Google review
     * link and the customisable WhatsApp message templates.
     */
    public function index(): View
    {
        return view('admin.settings', [
            'settings' => array_merge(Setting::defaults(), Setting::allKeyed()),
            'templates' => WhatsAppTemplate::cases(),
            'placeholders' => WhatsAppTemplate::placeholders(),
        ]);
    }

    /**
     * Persist the clinic details and WhatsApp templates.
     */
    public function update(Request $request): RedirectResponse
    {
        $rules = [
            Setting::ClinicName => ['required', 'string', 'max:120'],
            Setting::ClinicAddress => ['required', 'string', 'max:255'],
            Setting::ClinicPhone => ['required', 'string', 'max:32'],
            Setting::ClinicEmail => ['nullable', 'string', 'email', 'max:255'],
            Setting::DoctorName => ['required', 'string', 'max:120'],
            Setting::ReviewLink => ['nullable', 'url', 'max:500'],
            Setting::StatHappyPatients => ['nullable', 'string', 'max:20'],
            Setting::StatYearsExperience => ['nullable', 'string', 'max:20'],
            Setting::HeroTitle => ['nullable', 'string', 'max:255'],
            Setting::HeroSubtitle => ['nullable', 'string', 'max:1000'],
        ];

        foreach (WhatsAppTemplate::cases() as $template) {
            $rules[$template->settingKey()] = ['required', 'string', 'max:1000'];
        }

        $validated = $request->validate($rules);

        foreach ($validated as $key => $value) {
            Setting::put($key, $value);
        }

        return back()->with('status', 'Clinic settings saved — new WhatsApp messages use them immediately.');
    }
}
