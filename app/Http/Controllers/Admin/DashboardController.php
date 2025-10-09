<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\MobileInfo;
use App\Models\MobileNews;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลแบนเนอร์
        $recentBanners = Banner::orderBy('sort_order')
            ->orderByDesc('bannerID')
            ->limit(6)
            ->get();

        $bannersCount = Banner::count();

        $recentPhones = MobileInfo::with(['coverImage','images','brand'])
            ->orderByDesc('ID')
            ->limit(5)
            ->get();

        $phonesCount = MobileInfo::count();

        $recentNews = MobileNews::with('cover')
            ->orderByDesc('Date')
            ->orderByDesc('ID')
            ->limit(2)
            ->get();

        $newsCount  = MobileNews::count(); 
        $membersCount = User::count();   

        $start = now()->startOfDay();
        $end   = now()->endOfDay();

        $todayVisitors = Visit::whereBetween('created_at', [
                          now()->startOfDay(),
                          now()->endOfDay()
                      ])
                      ->distinct('ip')
                      ->count('ip');

        // ส่งตัวแปรทั้งหมดให้ blade
        return view('admin.dashboard', [
            'recentBanners' => $recentBanners,
            'bannersCount'  => $bannersCount,
            'phonesCount'   => $phonesCount,
            'recentPhones'  => $recentPhones,
            'newsCount'     => $newsCount,
            'recentNews'    => $recentNews,
            'membersCount'  => $membersCount,
            'todayVisitors'   => $todayVisitors,
            //'recentMembers' => collect(),
        ]);
    }
}
