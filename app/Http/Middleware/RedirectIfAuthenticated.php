<?php
//กันกรณี “ล็อกอินแล้วแต่ยังเห็นหน้า login”
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        // รองรับหลาย guard
        foreach ($guards ?: [null] as $guard) {
            if (Auth::guard($guard)->check()) {
                // ถ้าเข้าหน้าในกลุ่ม admin/* และล็อกอินแอดมินแล้ว → กลับแดชบอร์ดแอดมิน
                if ($request->is('admin/*') || $request->routeIs('admin.*')) {
                    return redirect()->route('admin.dashboard');
                }
                // ผู้ใช้ทั่วไป → กลับหน้าแรก (หรือ route ที่ต้องการ)
                return redirect()->route('home'); // ปรับเป็น route ของคุณ
            }
        }
        return $next($request);
    }
}
