<?php

use App\Http\Controllers\API\PaymentRateController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\TypePaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::name('api.')->group(function () {
    Route::prefix('students')->name('students.')->group(function () {
        Route::post('/', [StudentController::class, 'index'])->name('index');
        Route::post('update-or-create', [StudentController::class, 'updateOrCreate'])->name('update-or-create');
        Route::get('{id}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::delete('{id}/destroy', [StudentController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('payment-rates')->name('payment-rates.')->group(function () {
        Route::post('/', [PaymentRateController::class, 'index'])->name('index');
        Route::post('update-or-create', [PaymentRateController::class, 'updateOrCreate'])->name('update-or-create');
        Route::get('{id}/edit', [PaymentRateController::class, 'edit'])->name('edit');
        Route::delete('{id}/destroy', [PaymentRateController::class, 'destroy'])->name('destroy');
    });
});
