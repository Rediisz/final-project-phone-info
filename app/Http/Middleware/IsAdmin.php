<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin {
    public function handle($request, Closure $next) {
        if (!Auth::check() || !Auth::user()->role || strtolower(Auth::user()->role->Role) !== 'admin') {
            abort(403,'Unauthorized');
        }
        return $next($request);
    }
}