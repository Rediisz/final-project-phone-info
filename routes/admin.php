<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\MobileController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\BrandController;

Route::prefix('admin')->name('admin.')->group(function () {


    // --- Login / OAuth (เฉพาะคนที่ยังไม่ได้ล็อกอินใน guard:admin) ---
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login',  [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

        // Google OAuth
        Route::get('/login/google',          [AdminAuthController::class, 'redirectToGoogle'])->name('login.google');
        Route::get('/login/google/callback', [AdminAuthController::class, 'handleGoogleCallback'])->name('login.google.callback');
    });

    // --- Authenticated zone (ต้องผ่าน guard:admin + เป็นแอดมิน) ---
    Route::middleware(['auth:admin','is_admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Banner
        Route::resource('banners', BannerController::class)->only(['index','create','store','edit','update']);
        Route::patch('banners/{banner}/sort/{direction}', [BannerController::class, 'sort'])->name('banners.sort');
        Route::patch('banners/{banner}/toggle',           [BannerController::class, 'toggle'])->name('banners.toggle');
        Route::delete('banners/{banner}',                 [BannerController::class, 'destroy'])->name('banners.destroy');

        // News
        Route::resource('news', NewsController::class)->except(['show']);
        Route::patch('news/{news}/cover/{img}', [NewsController::class,'setCover'])->name('news.cover');
        Route::delete('news/{news}/image/{img}', [NewsController::class,'deleteImage'])->name('news.image.delete');
        Route::get('news/mobiles', [NewsController::class, 'listMobilesByBrand'])->name('news.mobiles');

        // Member
        Route::get('/members',               [MemberController::class, 'index'])->name('members.index');
        Route::get('/members/create',        [MemberController::class, 'create'])->name('members.create');
        Route::post('/members',              [MemberController::class, 'store'])->name('members.store');
        Route::get('/members/{user}/edit',   [MemberController::class, 'edit'])->name('members.edit');
        Route::put('/members/{user}',        [MemberController::class, 'update'])->name('members.update');
        Route::delete('/members/{user}',     [MemberController::class, 'destroy'])->name('members.destroy');

        // Mobile
        Route::resource('phones', MobileController::class)
            ->names('phones')
            ->parameters(['phones' => 'mobile']);
        
        // Brand
        Route::resource('brands', BrandController::class)->except(['show']);
        
    });
});
