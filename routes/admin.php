<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\MobileController;
use App\Http\Controllers\Admin\NewsController;


//เข้ามาที่หน้า login ของแอดมินก่อน (ไม่ต้อง auth) 
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
//Google login route
Route::get('/admin/login/google', [AdminAuthController::class, 'redirectToGoogle'])->name('admin.login.google');
Route::get('/admin/login/google/callback', [AdminAuthController::class, 'handleGoogleCallback'])->name('admin.login.google.callback');

// login เป็นแอดมินเท่านั้น 
Route::prefix('admin')
    ->middleware(['auth', 'is_admin'])   // 'auth' ของ Laravel + middleware is_admin 
    ->as('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        //Banner
        Route::resource('banners', BannerController::class)->only(['index','create','store','edit','update']); 
        Route::patch('banners/{banner}/sort/{direction}', [BannerController::class, 'sort'])->name('banners.sort'); 
        Route::patch('banners/{banner}/toggle', [BannerController::class, 'toggle'])->name('banners.toggle');
        Route::delete('banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');
        //News
        Route::resource('news', NewsController::class)->except(['show']);
        Route::patch('news/{news}/cover/{img}', [NewsController::class,'setCover'])->name('news.cover');
        Route::delete('news/{news}/image/{img}', [NewsController::class,'deleteImage'])->name('news.image.delete');
        Route::get('news/mobiles', [NewsController::class, 'listMobilesByBrand'])->name('news.mobiles'); 

        //Member
        Route::get('/members', [MemberController::class, 'index'])->name('members.index');
        Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
        Route::post('/members', [MemberController::class, 'store'])->name('members.store');
        Route::get('/members/{user}/edit', [MemberController::class, 'edit'])->name('members.edit');
        Route::put('/members/{user}', [MemberController::class, 'update'])->name('members.update');
        Route::delete('/members/{user}', [MemberController::class, 'destroy'])->name('members.destroy');
        //Mobile
        Route::resource('phones', MobileController::class)
            ->names('phones')                   // => admin.phones.*
            ->parameters(['phones' => 'mobile']); 
        
    });





