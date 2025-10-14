<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MobileInfo;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    const PER_PAGE = 16;

    public function index(Request $request)
    {
        // แบนเนอร์ & แบรนด์
        $banners = Banner::where('is_active', 1)
            ->whereNotNull('bannerImg')->where('bannerImg','!=','')
            ->orderBy('sort_order')->get();

        $brands  = Brand::orderBy('Brand')->get();

        // สร้าง query + ฟิลเตอร์ จากพารามิเตอร์ (ถ้าไม่มี ก็ถือว่าเป็น "ค้นหาแบบไม่ใส่ตัวกรอง")
        $query   = $this->buildQuery($request);

        // เรียง & แบ่งหน้าเท่ากันเสมอ
        $mobiles = $query->orderBy('mobile_info.Model')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        // รายการ OS / CPU สำหรับดรอปดาวน์
        $osList = MobileInfo::query()
            ->whereNotNull('OS')->where('OS','!=','')
            ->select('OS')->distinct()->orderBy('OS')->pluck('OS');

        $cpuList = MobileInfo::query()
            ->whereNotNull('Processor')->where('Processor','!=','')
            ->select('Processor')->distinct()->orderBy('Processor')->pluck('Processor');

        return view('home', compact('banners','brands','mobiles','osList','cpuList'));
    }

    // ให้ /search ใช้ logic เดียวกับหน้าแรก
    public function search(Request $request)
    {
        return $this->index($request);
    }

    /** รวมเงื่อนไขฟิลเตอร์ทั้งหมดไว้ที่เดียว */
    private function buildQuery(Request $request): Builder
    {
        $q = trim((string)$request->query('q', ''));

        $query = MobileInfo::query()
            ->with(['coverImage','images','brand'])
            ->leftJoin('brand', 'brand.ID', '=', 'mobile_info.Brand_ID')
            ->select('mobile_info.*');

        // คำค้น
        if ($q !== '') {
            $query->where(function($qq) use ($q) {
                $qq->where('mobile_info.Model', 'like', "%{$q}%")
                   ->orWhere('brand.Brand', 'like', "%{$q}%")
                   ->orWhere('mobile_info.Processor','like',"%{$q}%");
            });
        }

        // ฟิลเตอร์หลัก
        if ($brand = $request->query('brand')) {
            $query->where('mobile_info.Brand_ID', $brand);
        }
        if ($os = trim($request->query('os', ''))) {
            $query->where('mobile_info.OS','like',"%{$os}%");
        }
        if ($cpu = trim($request->query('cpu', ''))) {
            $query->where('mobile_info.Processor','like',"%{$cpu}%");
        }
        if ($request->boolean('has5g')) {
            $query->where('mobile_info.Network','like','%5G%');
        }

        // ช่วงค่า
        $between = function($field, $minKey, $maxKey) use ($request, $query) {
            if ($request->filled($minKey)) $query->where($field,'>=',$request->input($minKey));
            if ($request->filled($maxKey)) $query->where($field,'<=',$request->input($maxKey));
        };
        $between('mobile_info.RAM_GB',        'ram_min',     'ram_max');
        $between('mobile_info.ScreenSize_in', 'screen_min',  'screen_max');
        $between('mobile_info.Battery_mAh',   'battery_min', 'battery_max');
        $between('mobile_info.Price',         'price_min',   'price_max');

        // กล้อง (varchar) → แปลงเป็นตัวเลขเปรียบเทียบ
        if ($request->filled('rear_mp_min'))  $query->whereRaw("CAST(mobile_info.BackCamera  AS UNSIGNED) >= ?", [$request->integer('rear_mp_min')]);
        if ($request->filled('rear_mp_max'))  $query->whereRaw("CAST(mobile_info.BackCamera  AS UNSIGNED) <= ?", [$request->integer('rear_mp_max')]);
        if ($request->filled('front_mp_min')) $query->whereRaw("CAST(mobile_info.FrontCamera AS UNSIGNED) >= ?", [$request->integer('front_mp_min')]);
        if ($request->filled('front_mp_max')) $query->whereRaw("CAST(mobile_info.FrontCamera AS UNSIGNED) <= ?", [$request->integer('front_mp_max')]);

        // ปีเปิดตัว (จาก LaunchDate)
        if ($request->filled('year_from')) $query->whereYear('mobile_info.LaunchDate','>=',$request->integer('year_from'));
        if ($request->filled('year_to'))   $query->whereYear('mobile_info.LaunchDate','<=',$request->integer('year_to'));

        return $query;
    }
}
