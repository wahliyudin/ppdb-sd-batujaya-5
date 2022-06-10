<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentRateController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TypePaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\FormController;
use App\Http\Controllers\Student\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('master-data')->group(function () {
        Route::prefix('tarif-pembayaran')->name('payment-rates.')->group(function () {
            Route::get('/', [PaymentRateController::class, 'index'])->name('index');
        });
    });

    Route::prefix('data-siswa')->name('students.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('create', [StudentController::class, 'create'])->name('create');
        Route::get('{id}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::get('{id}/show', [StudentController::class, 'show'])->name('show');

        Route::get('verif-berkas/{id}/{status}', [StudentController::class, 'verifBerkas'])->name('verif-berkas');
    });
});

Route::middleware(['auth', 'role:siswa'])->name('students.')->group(function () {
    Route::get('form-pendaftaran', [FormController::class, 'index'])->name('form-pendaftaran');
    Route::post('form-pendaftaran/store', [FormController::class, 'store'])->name('form-pendaftaran.store');
    Route::get('form-pendaftaran/kirim-ke-panitia', [
        FormController::class,
        'kirimKePanitia'
    ])->name('form-pendaftaran.kirim-ke-panitia');

    Route::prefix('profile')->name('profiles.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
    });
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
