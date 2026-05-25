<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChartController;

// ============================================
// LANGUAGE SWITCHER - DO NOT DELETE

// ============================================
// LANGUAGE SWITCHER - DO NOT DELETE
// ============================================
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'ar'])) {
        session(['locale' => $locale]);
        App::setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

// باقي الرواتب...
// ============================================
// ============================================
// ============================================
// LANGUAGE SWITCHER
// ============================================
// PAGE D'ACCUEIL
// ============================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ============================================
// AUTHENTIFICATION
// ============================================
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================
// DONOR ROUTES
// ============================================
Route::middleware(['auth', 'donor'])->prefix('donor')->group(function () {
    Route::get('/dashboard', [DonorController::class, 'dashboard'])->name('donor.dashboard');
    Route::get('/profile/edit', [DonorController::class, 'editProfile'])->name('donor.profile.edit');
    Route::post('/profile/update', [DonorController::class, 'updateProfile'])->name('donor.profile.update');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('donor.appointments');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('donor.appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('donor.appointments.store');
    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('donor.appointments.cancel');
    Route::get('/search', [SearchController::class, 'index'])->name('donor.search');
    Route::post('/search', [SearchController::class, 'search'])->name('donor.search.results');
    Route::get('/history', [DonorController::class, 'history'])->name('donor.history');
    Route::get('/settings', [DonorController::class, 'settings'])->name('donor.settings');
    Route::get('/reports/donor-card/{donor}', [ReportController::class, 'donorCard'])->name('reports.donor-card');
});

// ============================================
// ADMIN ROUTES
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/donors', [AdminController::class, 'donors'])->name('admin.donors');
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    Route::get('/blood-stock', [AdminController::class, 'bloodStock'])->name('admin.blood-stock');
    Route::post('/appointments/{id}/status', [AdminController::class, 'updateAppointmentStatus'])->name('admin.update-status');
    Route::post('/blood-stock/{id}', [AdminController::class, 'updateBloodStock'])->name('admin.update-blood-stock');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/donors', [ReportController::class, 'donorsReport'])->name('reports.donors');
    Route::get('/reports/blood-stock', [ReportController::class, 'bloodStockReport'])->name('reports.blood-stock');
    Route::get('/reports/appointments', [ReportController::class, 'appointmentsReport'])->name('reports.appointments');
    Route::get('/charts', [ChartController::class, 'index'])->name('charts.index');
    Route::get('/charts-data', [ChartController::class, 'getData'])->name('charts.data');
    Route::get('/export-xml', [ReportController::class, 'exportXML'])->name('admin.export-xml');
    Route::post('/import-xml', [ReportController::class, 'importXML'])->name('admin.import-xml');
});