<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('admin')->user(); // ใช้ guard admin เท่านั้น

        if (!$user || !$user->role || strtolower($user->role->Role) !== 'admin') {
            // เพื่อ UX ที่ดี ส่งกลับไปหน้า login ของ BO
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
