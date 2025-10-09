<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Mail;

// กลุ่ม guest: login/signup
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup',[AuthController::class, 'storeSignup']);
});

// logout (ต้อง auth)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');



Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordController::class,'requestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordController::class,'emailLink'])->name('password.email');

    Route::get('/reset-password/{token}', [PasswordController::class,'resetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordController::class,'updatePassword'])->name('password.update');


Route::get('/_mailtest', function () {
    Mail::raw('SMTP OK', function ($m) {
        $m->to('captain998899@gmail.com')
          ->subject('SMTP test from SmartSpec');
    });
    return 'sent';
});
});