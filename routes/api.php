<?php

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
    Route::prefix('type-payments')->name('type-payments.')->group(function () {
        Route::post('/', [TypePaymentController::class, 'index'])->name('index');
        Route::post('update-or-create', [TypePaymentController::class, 'updateOrCreate'])->name('update-or-create');
        Route::get('{id}/edit', [TypePaymentController::class, 'edit'])->name('edit');
        Route::delete('{id}/destroy', [TypePaymentController::class, 'destroy'])->name('destroy');
    });
});
