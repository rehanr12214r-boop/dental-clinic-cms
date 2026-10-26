<?php

use App\Models\Treatment;
use Carbon\CarbonImmutable;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);

    $this->monday = CarbonImmutable::today()->next('monday');
    $this->sunday = CarbonImmutable::today()->next('sunday');
});

it('renders the landing page with hero, stats, featured treatments and CTAs', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Healthy teeth.')
        ->assertSee('Book appointment')
        ->assertSee('View treatments')
        ->assertSee('1200+') // happy patients stat (setting default)
        ->assertSee('12+')   // years of experience stat (setting default)
        ->assertSee('Teeth Cleaning')
        ->assertSee('Root Canal')
        ->assertSee('Tooth Extraction')
        ->assertSee('Braces Consultation')
        ->assertDontSee('General Checkup') // not marked as featured
        ->assertSee('Dr. Sara Mahmoud')
        ->assertSee('123 Main Street, City Center');
});

it('shows "Open now" during working hours', function () {
    CarbonImmutable::setTestNow($this->monday->setTime(18, 0));

    try {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Open now');
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('shows "Closed today" on a day off', function () {
    CarbonImmutable::setTestNow($this->sunday->setTime(12, 0));

    try {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Closed today')
            ->assertDontSee('Open now');
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('shows "Closed now" before opening time but mentions today\'s opening hour', function () {
    CarbonImmutable::setTestNow($this->monday->setTime(12, 0));

    try {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Closed now')
            ->assertSee('Opens today at 5:00 PM');
    } finally {
        CarbonImmutable::setTestNow();
    }
});

it('lists all treatments with pricing and duration', function () {
    $this->get(route('treatments.index'))
        ->assertOk()
        ->assertSee('Treatments &amp; transparent pricing', false)
        ->assertSee('Teeth Cleaning')
        ->assertSee('Root Canal')
        ->assertSee('General Checkup')
        ->assertSee('Tooth Extraction')
        ->assertSee('Braces Consultation')
        ->assertSee('$300.00')
        ->assertSee('90 min visit')
        ->assertSee('Monday – Saturday · 5:00 PM – 9:00 PM');
});

it('shows a treatment detail page with included items and instructions', function () {
    $rootCanal = Treatment::query()->where('slug', 'root-canal')->firstOrFail();

    $this->get(route('treatments.show', ['treatment' => $rootCanal->slug]))
        ->assertOk()
        ->assertSee('Root Canal')
        ->assertSee('$300.00')
        ->assertSee('90 minute visit')
        ->assertSee('Local anaesthesia for total comfort') // "what's included" line
        ->assertSee('Eat a light meal before the appointment') // pre-appointment line
        ->assertSee('Book this treatment')
        ->assertSee('Book online'); // header navigation
});

it('shows related treatments on a treatment detail page', function () {
    $checkup = Treatment::query()->where('slug', 'general-checkup')->firstOrFail();

    $this->get(route('treatments.show', ['treatment' => $checkup->slug]))
        ->assertOk()
        ->assertSee('Other treatments you may need')
        ->assertSee('Teeth Cleaning');
});

it('hides inactive treatments from the public site', function () {
    $braces = Treatment::query()->where('slug', 'braces-consultation')->firstOrFail();
    $braces->update(['is_active' => false]);

    $this->get(route('home'))
        ->assertOk()
        ->assertDontSee('Braces Consultation');

    $this->get(route('treatments.index'))
        ->assertOk()
        ->assertDontSee('Braces Consultation');

    $this->get(route('treatments.show', ['treatment' => $braces->slug]))
        ->assertNotFound();
});

it('returns 404 for an unknown treatment slug', function () {
    $this->get('/treatments/not-a-real-treatment')->assertNotFound();
});

it('shows the landing page treatment grid with "Book this" links', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Book this')
        ->assertSee(route('book'));
});
