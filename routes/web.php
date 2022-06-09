<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentRateController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TypePaymentController;
use App\Http\Controllers\HomeController;
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
    });
});

Route::middleware(['auth', 'role:siswa'])->name('student.')->group(function () {
    Route::get('', []);
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
