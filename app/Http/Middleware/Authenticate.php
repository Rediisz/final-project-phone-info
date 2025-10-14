<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        if ($request->expectsJson()) return null;

        // รองรับโปรเจ็กต์ที่อยู่ใต้ subfolder เช่น /Final_Project/public/...
        $firstSegment = $request->segment(1); // "admin" | "login" | ฯลฯ
        $isAdminArea  = ($firstSegment === 'admin') || ($request->route() && $request->route()->named('admin.*'));

        if ($isAdminArea) {
            // ถ้ามี route ชื่อ admin.login ใช้อันนั้น ไม่มีก็ fallback เป็น /admin/login
            return Route::has('admin.login') ? route('admin.login') : url('/admin/login');
        }

        // โซนอื่น ๆ ให้ใช้ /login ปกติ (หรือ route('login') ถ้ามี)
        return Route::has('login') ? route('login') : url('/login');
    }
}
