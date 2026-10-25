<?php

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('shows the admin login page', function () {
    $this->get(route('login'))
        ->assertOk()
        ->assertSee('Sign in')
        ->assertSee('BrightSmile Dental Clinic');
});

it('redirects guests from the dashboard to the login page', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    $this->get(route('admin.settings.index'))->assertRedirect(route('login'));
    $this->put(route('admin.settings.update'), [])->assertRedirect(route('login'));
    $this->get(route('admin.reports.index'))->assertRedirect(route('login'));
    $this->get(route('admin.reports.export'))->assertRedirect(route('login'));
});

it('signs the admin in with the seeded credentials', function () {
    $this->post(route('login.authenticate'), [
        'email' => 'admin@clinic.com',
        'password' => 'password',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticated();
});

it('rejects invalid credentials', function () {
    $this->from(route('login'))
        ->post(route('login.authenticate'), [
            'email' => 'admin@clinic.com',
            'password' => 'wrong-password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('redirects already-authenticated admins away from the login page', function () {
    signInAdmin();

    $this->get(route('login'))->assertRedirect(route('admin.dashboard'));
});

it('logs the admin out and destroys the session', function () {
    signInAdmin();

    $this->post(route('logout'))->assertRedirect(route('home'));

    $this->assertGuest();
});

it('protects admin appointment actions behind the auth middleware', function () {
    $appointment = Appointment::factory()->create();

    $this->patch(route('admin.appointments.update-status', $appointment), ['status' => 'confirmed'])
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

it('keeps the seeded admin password in the users table', function () {
    $admin = User::query()->where('email', 'admin@clinic.com')->first();

    expect($admin)->not->toBeNull()
        ->and(Hash::check('password', $admin->password))->toBeTrue();
});
