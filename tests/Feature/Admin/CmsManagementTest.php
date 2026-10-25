<?php

namespace Tests\Feature\Admin;

use App\Models\BlogPost;
use App\Models\Dentist;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_admin_can_view_dentists_list(): void
    {
        Dentist::create([
            'name' => 'Dr. Test Dentist',
            'short_name' => 'Dr. Test',
            'role' => 'Orthodontist',
            'experience' => '7 years',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.dentists.index'));

        $response->assertOk();
        $response->assertSee('Dr. Test Dentist');
    }

    public function test_admin_can_create_a_dentist(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.dentists.store'), [
            'name' => 'Dr. New Doctor',
            'short_name' => 'Dr. New',
            'role' => 'Pediatric Dentist',
            'experience' => '3 years',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.dentists.index'));
        $this->assertDatabaseHas('dentists', [
            'name' => 'Dr. New Doctor',
            'role' => 'Pediatric Dentist',
        ]);
    }

    public function test_admin_can_view_blog_posts_list(): void
    {
        BlogPost::create([
            'title' => 'Healthy Habits For Teeth',
            'category' => 'Dental Care',
            'author' => 'Dr. Editor',
            'status' => 'published',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.blog.index'));

        $response->assertOk();
        $response->assertSee('Healthy Habits For Teeth');
    }

    public function test_admin_can_create_a_blog_post(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.blog.store'), [
            'title' => 'Five Ways To Whiten Smiles',
            'category' => 'Cosmetic',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.blog.index'));
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Five Ways To Whiten Smiles',
            'category' => 'Cosmetic',
        ]);
    }

    public function test_public_navbar_renders_guest_buttons_for_guests(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee(route('patient.login'));
        $response->assertSee(route('patient.register'));
    }

    public function test_public_navbar_renders_user_dropdown_for_logged_in_patient(): void
    {
        $patient = Patient::create([
            'name' => 'John Patient Doe',
            'email' => 'john.patient@example.com',
            'phone' => '+9647701112233',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($patient, 'patient')->get(route('home'));

        $response->assertOk();
        $response->assertSee('John Patient Doe');
        $response->assertSee('My Dashboard');
        $response->assertSee('Track Appointment');
        $response->assertSee('My Profile');
        $response->assertSee(route('patient.logout'));
    }
}
