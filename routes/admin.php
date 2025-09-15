<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;

// --- หน้า login ของแอดมิน (ไม่ต้อง auth) ---
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// --- โซนหลังบ้าน: ต้อง login + เป็นแอดมินเท่านั้น ---
Route::prefix('admin')
    ->middleware(['auth', 'is_admin'])   // 'auth' ของ Laravel + middleware is_admin ที่คุณสร้างไว้
    ->as('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/banners', fn() => view('admin.banners.index'))->name('banners.index');
        Route::get('/phones', function () {
            $items = [
                ['id'=>1,'title'=>'iPhone 15 Pro','image'=>asset('images/placeholder.png'),'active'=>true],
                ['id'=>2,'title'=>'Samsung S24','image'=>asset('images/placeholder.png'),'active'=>false],
            ];
            return view('admin.phones.index', compact('items'));
        })->name('phones.index');
        Route::get('/news', function () {
            $items = [
                ['id'=>1,'title'=>'เปิดตัวรุ่นใหม่','image'=>asset('images/placeholder.png'),'active'=>true],
                ['id'=>2,'title'=>'อัปเดตแพตช์ความปลอดภัย','image'=>asset('images/placeholder.png'),'active'=>true],
            ];
            return view('admin.news.index', compact('items'));
        })->name('news.index');
        Route::get('/members', function () {
            $items = [
                [
                    'id'    => 1,
                    'name'  => 'admin',
                    'email' => 'admin@gmail.com',
                    'role'  => 'admin',
                    'avatar'=> asset('images/placeholder-user.png'),
                ],
                [
                    'id'    => 2,
                    'name'  => 'user1',
                    'email' => 'user1@example.com',
                    'role'  => 'user',
                    'avatar'=> asset('images/placeholder-user.png'),
                ],
            ];
            return view('admin.members.index', compact('items'));
        })->name('members.index');
    });



