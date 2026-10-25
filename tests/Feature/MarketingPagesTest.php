<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('renders the about page with values, partners and the care team', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertSee('What we')
        ->assertSee('stand for!')
        ->assertSee('Trusted Partners')
        ->assertSee('A Trusted,')
        ->assertSee('Caring Team.')
        ->assertSee('Dr. James Morgan')
        ->assertSee('Dr. Andrew Flintoff');
});

it('renders the contact page with dynamic clinic details and the enquiry form', function () {
    $this->get(route('contact'))
        ->assertOk()
        ->assertSee('Make An Appointment')
        ->assertSee('Submit Message')
        ->assertSee(Setting::get(Setting::ClinicEmail))
        ->assertSee(Setting::get(Setting::ClinicPhone))
        ->assertSee(Setting::get(Setting::ClinicAddress));
});

it('sends contact messages to the clinic inbox', function () {
    Mail::fake();

    $this->post(route('contact.send'), [
        'name' => 'Mona Saleh',
        'email' => 'mona@example.com',
        'phone' => '+964 770 000 0000',
        'subject' => 'Wisdom tooth pain',
        'message' => 'I would like to book a consultation this week.',
    ])
        ->assertRedirect(route('contact'))
        ->assertSessionHas('status');
});

it('validates the contact form', function () {
    $this->from(route('contact'))
        ->post(route('contact.send'), [])
        ->assertSessionHasErrors([
            'name',
            'email',
            'phone',
            'subject',
            'message',
        ]);
});

it('renders the dentist index and a dentist profile', function () {
    $this->get(route('dentists.index'))
        ->assertOk()
        ->assertSee('Expert Doctors')
        ->assertSee('Dr. James Morgan, DMD')
        ->assertSee('Dr. Harshall Gibbs, RDH')
        ->assertSee('Dr. Alex Peterson, DMD')
        ->assertSee('Dr. Nadal James, DDS, MS')
        ->assertSee('Lena Torres, CDA')
        ->assertSee('Dr. Andrew Flintoff, DDS');

    $this->get(route('dentists.show', ['slug' => 'harshall-gibbs']))
        ->assertOk()
        ->assertSee('Dr. Harshall Gibbs')
        ->assertSee('Dental Assistant')
        ->assertSee('Location')
        ->assertSee(Setting::get(Setting::ClinicAddress))
        ->assertSee(Setting::get(Setting::ClinicEmail))
        ->assertSee('Open on Google Maps');
});

it('returns 404 for an unknown dentist', function () {
    $this->get('/dentists/not-a-real-dentist')->assertNotFound();
});

it('renders the blog index and a full article', function () {
    $this->get(route('blog.index'))
        ->assertOk()
        ->assertSee('Our Blog')
        ->assertSee('Benefits of Early Orthodontic Checkups for Kids.')
        ->assertSee('Simple Cosmetic Dentistry Options for Everyday Smiles.')
        ->assertSee('How Cosmetic Dentistry Can Improve Your Confidence.');

    $this->get(route('blog.show', ['slug' => 'simple-cosmetic-dentistry-options-for-everyday-smiles']))
        ->assertOk()
        ->assertSee('Simple Cosmetic Dentistry Options for Everyday Smiles.')
        ->assertSee('1. What Is Simple Cosmetic Dentistry?')
        ->assertSee('James Anderson')
        ->assertSee('Category :')
        ->assertSee('Cosmetic Dentistry');
});

it('returns 404 for an unknown article', function () {
    $this->get('/blog/not-a-real-article')->assertNotFound();
});

it('serves the Figma services and appointments URLs', function () {
    $this->get(route('services.index'))
        ->assertOk()
        ->assertSee('Our Services')
        ->assertSee('Teeth Cleaning');

    $this->get(route('services.show', ['treatment' => 'root-canal']))
        ->assertOk()
        ->assertSee('Root Canal');

    $this->get(route('appointments.index'))->assertOk();
});
