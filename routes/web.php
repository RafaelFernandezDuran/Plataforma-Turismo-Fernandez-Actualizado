<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\CompanyRegistrationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Accommodation;

Route::get('/', function () {
    $featuredAccommodations = Accommodation::active()
        ->orderByDesc('rating')
        ->take(3)
        ->get();

    return view('welcome', [
        'featuredAccommodations' => $featuredAccommodations,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/payment-method', [DashboardController::class, 'storeSavedPaymentMethod'])->name('payment-method.store');
    Route::delete('/payment-method', [DashboardController::class, 'destroySavedPaymentMethod'])->name('payment-method.destroy');
});

// Ruta de prueba de base de datos
Route::get('/test-db', function () {
    try {
        // Probar la conexión
        $connection = DB::connection()->getPdo();
        
        // Obtener información de la base de datos
        $dbName = DB::connection()->getDatabaseName();
        $tables = DB::select('SHOW TABLES');
        $users = DB::table('users')->count();
        $companies = DB::table('companies')->count();
        $tours = DB::table('tours')->count();
        $categories = DB::table('tour_categories')->count();
        
        return view('database-test', [
            'status' => 'success',
            'message' => 'Conexión exitosa con MySQL',
            'database' => $dbName,
            'tables' => $tables,
            'users_count' => $users,
            'companies_count' => $companies,
            'tours_count' => $tours,
            'categories_count' => $categories
        ]);
    } catch (\Exception $e) {
        return view('database-test', [
            'status' => 'error',
            'message' => 'Error de conexión: ' . $e->getMessage(),
            'database' => null,
            'tables' => [],
            'users_count' => 0,
            'companies_count' => 0,
            'tours_count' => 0,
            'categories_count' => 0
        ]);
    }
});

// Rutas públicas
Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{tour}', [TourController::class, 'show'])->name('tours.show');
Route::get('/alojamientos', [AccommodationController::class, 'index'])->name('accommodations.index');
Route::get('/alojamientos/{accommodation:slug}', [AccommodationController::class, 'show'])->name('accommodations.show');
Route::post('/alojamientos/{accommodation:slug}/solicitud', [AccommodationController::class, 'submitRequest'])->name('accommodations.request');

// Rutas de registro de empresas
Route::get('/company/register', [CompanyRegistrationController::class, 'showRegistrationForm'])->name('company.register');
Route::post('/company/register', [CompanyRegistrationController::class, 'register'])->name('company.register.submit');
Route::get('/company/register/step/{step}', [CompanyRegistrationController::class, 'getStepData'])->name('company.register.step');
Route::post('/company/register/check-availability', [CompanyRegistrationController::class, 'checkAvailability'])->name('company.register.availability');

// Rutas para empresas turísticas
Route::middleware(['auth', 'user.type:company_admin'])->prefix('company')->name('company.')->group(function () {
    Route::get('/dashboard', [CompanyController::class, 'dashboard'])->name('dashboard');
    Route::resource('tours', TourController::class)->except(['index', 'show']);
    Route::post('/tours/{tour}/toggle-status', [TourController::class, 'toggleStatus'])->name('tours.toggle-status');
    Route::post('/tours/{tour}/toggle-featured', [TourController::class, 'toggleFeatured'])->name('tours.toggle-featured');
});

// Rutas de reservas
Route::middleware(['auth'])->group(function () {
    Route::get('/tours/{tour}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/pdf', [BookingController::class, 'downloadPdf'])->name('bookings.pdf');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
});

// Rutas para administradores
Route::middleware(['auth', 'user.type:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
