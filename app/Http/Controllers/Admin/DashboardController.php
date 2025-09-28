<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\MobileInfo;
use App\Models\MobileNews;

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

        // ส่งตัวแปรทั้งหมดให้ blade
        return view('admin.dashboard', [
            'recentBanners' => $recentBanners,
            'bannersCount'  => $bannersCount,
            'phonesCount'   => $phonesCount,
            'recentPhones'  => $recentPhones,
            'newsCount'     => $newsCount,
            'recentNews'    => $recentNews,

            // ที่เหลือยังไม่ทำ( ถ้าอารมณ์ดีอาจทำ)
            'membersCount'  => 0,
            'todayVisits'   => 0,
            'recentMembers' => collect(),
        ]);
    }
}
