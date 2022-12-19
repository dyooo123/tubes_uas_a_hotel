<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserVerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\TamuController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('email/verify/{id}', [UserVerificationController::class, 'verify'])->name('verification.verify');
Route::get('email/resend', [UserVerificationController::class, 'resend'])->name('verification.resend');
Route::group(['middleware' => ['auth:sanctum']], function () {
Route::get('/profile', [UserController::class, 'show']);

    Route::apiResource('/kamars', App\Http\Controllers\KamarController::class);
    Route::apiResource('/tamus', App\Http\Controllers\TamuController::class);
    Route::apiResource('/karyawans', App\Http\Controllers\KaryawanController::class);
    Route::put('/profile', [UserController::class, 'update']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
