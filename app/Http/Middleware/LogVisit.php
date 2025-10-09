<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visit;

class LogVisit
{
    public function handle(Request $request, Closure $next)
    {
        // ข้ามหลังบ้าน
        if ($request->is('admin*')) {
            return $next($request);
        }

        // กันบอท/ครอว์เลอร์ที่ชัดเจน (เอาออกได้ถ้าไม่ต้องการ)
        $ua = $request->userAgent() ?? '';
        if (preg_match('/bot|crawl|spider|slurp|bingpreview/i', $ua)) {
            return $next($request);
        }

        // Normalize path: root = '/', อื่น ๆ ขึ้นต้นด้วย '/'
        $raw  = $request->path();              // บาง env หน้า root จะได้เป็น '' 
        $path = ($raw === '' || $raw === '/')  // ให้เก็บเป็น '/'
            ? '/'
            : '/' . ltrim($raw, '/');

        // บันทึกทุกหน้า
        Visit::create([
            'ip'         => $request->ip(),
            'user_agent' => $ua,
            'path'       => $path,
        ]);

        return $next($request);
    }
}
