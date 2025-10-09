<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        if ($request->expectsJson()) return null;

        // ถ้า URL เป็นของแอดมิน ให้เด้งไปหน้า login แอดมิน
        if ($request->is('admin/*') || $request->routeIs('admin.*')) {
            return route('admin.login');
        }

        // อื่น ๆ เป็นหน้าบ้าน
        return route('login');
    }
}
