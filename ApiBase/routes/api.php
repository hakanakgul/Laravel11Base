<?php

use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ForgotPasswordController; //Şifre sıfırlama için ekledik
use App\Http\Controllers\Api\ResetPasswordController; //Şifre sıfırlama için ekledik
use App\Http\Controllers\VerificationController; // E-posta doğrulama için ekledik


Route::post('/register', [AuthController::class, 'register'])->middleware('guest'); //guest middleware giriş yapmış kullanıcının tekrar kayıt olmasını engeller.
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::middleware(['throttle:5,1'])->group(function () { // Giriş denemelerine hız sınırlaması (5 deneme/1 dakika)
    Route::post('/login', [AuthController::class, 'login']);
});


Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [ResetPasswordController::class, 'reset']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify'); // E-posta doğrulama linki için
    Route::get('/email/verify-resend', [VerificationController::class, 'resend'])->name('verification.resend'); //Doğrulama e-postasını tekrar göndermek için
    Route::apiResource('students', StudentController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});