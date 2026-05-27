<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\NewsController;
use App\Http\Controllers\Web\StartupController;
use App\Http\Controllers\Web\ProgramController;
use App\Http\Controllers\Web\ApplicationController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\StartupController as AdminStartupController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\CohortController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PasswordResetRequestController;

/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// News / Blog
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// Startups Portfolio
Route::get('/startups', [StartupController::class, 'index'])->name('startups.index');
Route::get('/startups/{slug}', [StartupController::class, 'show'])->name('startups.show');

// Programs & Services
Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');

// Cohort Application
Route::get('/apply', [ApplicationController::class, 'create'])->name('apply.create');
Route::post('/apply', [ApplicationController::class, 'store'])->name('apply.store');
Route::get('/apply/success', [ApplicationController::class, 'success'])->name('apply.success');
Route::get('/apply/track', [ApplicationController::class, 'track'])->name('apply.track');
Route::post('/apply/track', [ApplicationController::class, 'lookup'])->name('apply.track.lookup');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Admin CMS Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['admin.guard', 'prevent.cache'])->group(function () {

    // Auth
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest:admin');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'show'])->name('forgot-password')->middleware('guest:admin');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('forgot-password.store')->middleware('guest:admin');

    // Protected admin area
    Route::middleware('admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

        // Password reset requests
        Route::get('/password-reset-requests', [PasswordResetRequestController::class, 'index'])->name('password-resets.index');
        Route::patch('/password-reset-requests/{passwordResetRequest}/resolve', [PasswordResetRequestController::class, 'resolve'])->name('password-resets.resolve');

        // News
        Route::resource('news', AdminNewsController::class);
        Route::patch('news/{news}/toggle-publish', [AdminNewsController::class, 'togglePublish'])->name('news.toggle-publish');

        // Startups
        Route::resource('startups', AdminStartupController::class);
        Route::patch('startups/{startup}/toggle-featured', [AdminStartupController::class, 'toggleFeatured'])->name('startups.toggle-featured');

        // Applications
        Route::get('applications', [AdminApplicationController::class, 'index'])->name('applications.index');
        Route::get('applications/{application}', [AdminApplicationController::class, 'show'])->name('applications.show');
        Route::patch('applications/{application}/status', [AdminApplicationController::class, 'updateStatus'])->name('applications.update-status');
        Route::delete('applications/{application}', [AdminApplicationController::class, 'destroy'])->name('applications.destroy');

        // Programs
        Route::resource('programs', AdminProgramController::class);

        // Services
        Route::resource('services', ServiceController::class);

        // Team Members
        Route::resource('team', TeamController::class);

        // Cohorts
        Route::resource('cohorts', CohortController::class);
        Route::patch('cohorts/{cohort}/toggle-status', [CohortController::class, 'toggleStatus'])->name('cohorts.toggle-status');

        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

        // Notifications
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::patch('notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.mark-read');
        Route::post('notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
        Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    });
});
