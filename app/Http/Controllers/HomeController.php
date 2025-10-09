<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MobileInfo;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', 1)
            ->whereNotNull('bannerImg')
            ->where('bannerImg', '!=', '')
            ->orderBy('sort_order')
            ->get();

        $brands  = Brand::orderBy('Brand')->get();
        $mobiles = MobileInfo::with(['firstImage','brand'])->limit(16)->get();

        // รายการ OS / CPU สำหรับดรอปดาวน์
        $osList = MobileInfo::query()
            ->whereNotNull('OS')->where('OS','!=','')
            ->select('OS')->distinct()->orderBy('OS')->pluck('OS');

        $cpuList = MobileInfo::query()
            ->whereNotNull('Processor')->where('Processor','!=','')
            ->select('Processor')->distinct()->orderBy('Processor')->pluck('Processor');

        return view('home', compact('banners','brands','mobiles','osList','cpuList'));
    }

    public function search(Request $request)
    {
        $q = trim((string)$request->query('q', ''));

        $query = MobileInfo::query()
            ->with(['coverImage','images','brand'])
            ->leftJoin('brand', 'brand.ID', '=', 'mobile_info.Brand_ID')
            ->select('mobile_info.*');

        // คำค้น (optional)
        if ($q !== '') {
            $query->where(function($qq) use ($q) {
                $qq->where('mobile_info.Model', 'like', "%{$q}%")
                   ->orWhere('brand.Brand', 'like', "%{$q}%");
            });
        }

        // ===== ตัวกรอง =====
        if ($brand = $request->query('brand')) {
            $query->where('mobile_info.Brand_ID', $brand);
        }
        if ($os = trim($request->query('os', ''))) {
            $query->where('mobile_info.OS','like',"%{$os}%");
        }
        if ($cpu = trim($request->query('cpu', ''))) {
            // ใช้เท่ากับหรือ like ก็ได้; เลือก like เผื่อ string มี suffix
            $query->where('mobile_info.Processor','like',"%{$cpu}%");
        }

        // RAM
        if ($request->filled('ram_min')) $query->where('mobile_info.RAM_GB','>=',$request->integer('ram_min'));
        if ($request->filled('ram_max')) $query->where('mobile_info.RAM_GB','<=',$request->integer('ram_max'));

        // Screen
        if ($request->filled('screen_min')) $query->where('mobile_info.ScreenSize_in','>=',(float)$request->query('screen_min'));
        if ($request->filled('screen_max')) $query->where('mobile_info.ScreenSize_in','<=',(float)$request->query('screen_max'));

        // Battery
        if ($request->filled('battery_min')) $query->where('mobile_info.Battery_mAh','>=',$request->integer('battery_min'));
        if ($request->filled('battery_max')) $query->where('mobile_info.Battery_mAh','<=',$request->integer('battery_max'));

        // Price
        if ($request->filled('price_min')) $query->where('mobile_info.Price','>=',(float)$request->query('price_min'));
        if ($request->filled('price_max')) $query->where('mobile_info.Price','<=',(float)$request->query('price_max'));

        // กล้อง (varchar) -> เอาเลขตัวแรกด้วย CAST(… AS UNSIGNED) ให้รองรับ MySQL/MariaDB ทั่วไป
        if ($request->filled('rear_mp_min')) $query->whereRaw("CAST(mobile_info.BackCamera  AS UNSIGNED) >= ?", [$request->integer('rear_mp_min')]);
        if ($request->filled('rear_mp_max')) $query->whereRaw("CAST(mobile_info.BackCamera  AS UNSIGNED) <= ?", [$request->integer('rear_mp_max')]);
        if ($request->filled('front_mp_min'))$query->whereRaw("CAST(mobile_info.FrontCamera AS UNSIGNED) >= ?", [$request->integer('front_mp_min')]);
        if ($request->filled('front_mp_max'))$query->whereRaw("CAST(mobile_info.FrontCamera AS UNSIGNED) <= ?", [$request->integer('front_mp_max')]);

        // ปีเปิดตัว
        if ($request->filled('year_from')) $query->whereYear('mobile_info.LaunchDate','>=',$request->integer('year_from'));
        if ($request->filled('year_to'))   $query->whereYear('mobile_info.LaunchDate','<=',$request->integer('year_to'));

        // 5G
        if ($request->boolean('has5g')) $query->where('mobile_info.Network','like','%5G%');

        $mobiles = $query->orderBy('mobile_info.Model')->paginate(24)->withQueryString();

        // ข้อมูลประกอบ
        $banners = Banner::where('is_active', 1)
            ->whereNotNull('bannerImg')->where('bannerImg','!=','')
            ->orderBy('sort_order')->get();

        $brands  = Brand::orderBy('Brand')->get();

        $osList = MobileInfo::query()
            ->whereNotNull('OS')->where('OS','!=','')
            ->select('OS')->distinct()->orderBy('OS')->pluck('OS');

        $cpuList = MobileInfo::query()
            ->whereNotNull('Processor')->where('Processor','!=','')
            ->select('Processor')->distinct()->orderBy('Processor')->pluck('Processor');

        return view('home', compact('banners','brands','mobiles','osList','cpuList'));
    }
}
