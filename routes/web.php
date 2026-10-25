<?php

use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DentistController as AdminDentistController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TreatmentController as AdminTreatmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentLookupController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PatientAuthController;
use App\Http\Controllers\Auth\PatientPasswordResetController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DentistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Patient\ProfileController as PatientProfileController;
use App\Http\Controllers\TreatmentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website (Phase 5) — landing, treatments & guest lookup
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/treatments', [TreatmentController::class, 'index'])->name('treatments.index');
Route::get('/treatments/{treatment:slug}', [TreatmentController::class, 'show'])->name('treatments.show');

// Figma calls this page "Services"; keep /treatments as the canonical URL.
Route::get('/services', [TreatmentController::class, 'index'])->name('services.index');
Route::get('/services/{treatment:slug}', [TreatmentController::class, 'show'])->name('services.show');

Route::get('/dentists', [DentistController::class, 'index'])->name('dentists.index');
Route::get('/dentists/{slug}', [DentistController::class, 'show'])->name('dentists.show');

Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])
    ->middleware('throttle:6,1')
    ->name('contact.send');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/appointment/lookup', [AppointmentLookupController::class, 'show'])->name('appointment.lookup');
Route::post('/appointment/lookup', [AppointmentLookupController::class, 'lookup'])
    ->middleware('throttle:12,1')
    ->name('appointment.lookup.find');
Route::post('/appointment/lookup/cancel', [AppointmentLookupController::class, 'cancel'])
    ->middleware('throttle:12,1')
    ->name('appointment.lookup.cancel');

/*
|--------------------------------------------------------------------------
| Public patient booking portal (Phase 1) — powered by the slot engine
|--------------------------------------------------------------------------
*/
Route::get('/book', [AppointmentController::class, 'index'])->name('book');
Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment');
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');

Route::get('/appointments/available-slots', [AppointmentController::class, 'availableSlots'])
    ->name('appointments.available-slots');

Route::post('/appointments', [AppointmentController::class, 'store'])
    ->middleware('auth:patient,web')
    ->name('appointments.store');
Route::post('/appointment', [AppointmentController::class, 'store'])
    ->middleware('auth:patient,web');

/*
|--------------------------------------------------------------------------
| Patient portal (Phase 5) — signup, dashboard, receipts
|--------------------------------------------------------------------------
*/
Route::prefix('patient')->name('patient.')->group(function (): void {
    Route::middleware('guest:patient')->group(function (): void {
        Route::get('register', [PatientAuthController::class, 'showRegister'])->name('register');
        Route::post('register', [PatientAuthController::class, 'register'])
            ->middleware('throttle:6,1')
            ->name('register.store');

        Route::get('login', [PatientAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [PatientAuthController::class, 'authenticate'])
            ->middleware('throttle:6,1')
            ->name('login.authenticate');

        Route::get('forgot-password', [PatientPasswordResetController::class, 'requestForm'])
            ->name('password.request');
        Route::post('forgot-password', [PatientPasswordResetController::class, 'sendResetLink'])
            ->middleware('throttle:6,1')
            ->name('password.email');
        Route::get('reset-password/{token}', [PatientPasswordResetController::class, 'resetForm'])
            ->name('password.reset');
        Route::post('reset-password', [PatientPasswordResetController::class, 'reset'])
            ->middleware('throttle:6,1')
            ->name('password.store');
    });

    Route::middleware('auth:patient')->group(function (): void {
        Route::post('logout', [PatientAuthController::class, 'logout'])->name('logout');

        Route::get('dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');

        Route::get('profile', [PatientProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [PatientProfileController::class, 'update'])->name('profile.update');

        Route::get('appointments/{appointment}/slots', [PatientAppointmentController::class, 'slots'])
            ->name('appointments.slots');
        Route::post('appointments/{appointment}/cancel', [PatientAppointmentController::class, 'cancel'])
            ->name('appointments.cancel');
        Route::get('appointments/{appointment}/reschedule', [PatientAppointmentController::class, 'rescheduleForm'])
            ->name('appointments.reschedule');
        Route::patch('appointments/{appointment}/reschedule', [PatientAppointmentController::class, 'reschedule'])
            ->name('appointments.reschedule.update');
        Route::get('appointments/{appointment}/receipt', [PatientAppointmentController::class, 'receipt'])
            ->name('appointments.receipt');
    });
});

Route::get('/register', fn () => redirect()->route('patient.register'))->name('register');
Route::get('/forgot-password', fn () => redirect()->route('patient.password.request'))->name('password.request');
Route::get('/reset-password/{token}', fn (string $token) => redirect()->route('patient.password.reset', ['token' => $token]))->name('password.reset');
Route::get('/dashboard', fn () => auth('patient')->check() ? redirect()->route('patient.dashboard') : (auth()->check() ? redirect()->route('admin.dashboard') : redirect()->route('patient.login')))->name('dashboard');
Route::get('/profile', fn () => auth('patient')->check() ? redirect()->route('patient.profile.edit') : redirect()->route('patient.login'))->name('profile');

/*
|--------------------------------------------------------------------------
| Admin authentication (simple session-based)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])
    ->middleware('throttle:6,1')
    ->name('login.authenticate');

/*
|--------------------------------------------------------------------------
| Dashboard (Phase 2) — protected by the auth middleware
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('appointments', [AdminAppointmentController::class, 'index'])
        ->name('appointments.index');

    Route::patch('appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])
        ->name('appointments.update-status');
    Route::patch('appointments/{appointment}/notes', [AdminAppointmentController::class, 'updateNotes'])
        ->name('appointments.update-notes');

    Route::post('appointments/{appointment}/send-whatsapp', [AdminAppointmentController::class, 'sendWhatsApp'])
        ->name('appointments.send-whatsapp');

    Route::get('appointments/{appointment}/history', [AdminAppointmentController::class, 'history'])
        ->name('appointments.history');
    Route::get('appointments/{appointment}/receipt', [AdminAppointmentController::class, 'receipt'])
        ->name('appointments.receipt');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');

    Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::put('schedule', [ScheduleController::class, 'update'])->name('schedule.update');

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::resource('treatments', AdminTreatmentController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::patch('treatments/{treatment}/toggle', [AdminTreatmentController::class, 'toggle'])
        ->name('treatments.toggle');

    Route::resource('dentists', AdminDentistController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::patch('dentists/{dentist}/toggle', [AdminDentistController::class, 'toggle'])
        ->name('dentists.toggle');

    Route::resource('blog', AdminBlogPostController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->parameters(['blog' => 'blogPost']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
