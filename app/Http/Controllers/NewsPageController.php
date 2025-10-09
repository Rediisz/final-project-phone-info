<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\MobileNews;
use App\Models\MobileInfo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NewsPageController extends Controller
{
    public function index(Request $request)
    {
        $q        = trim((string)$request->query('q',''));
        $brandSel = $request->query('brand');   // Brand_ID
        $modelSel = $request->query('model');   // Mobile_ID
        $osSel    = trim((string)$request->query('os',''));

        $query = MobileNews::query()
            ->with(['cover','images','brand','mobile']);

        // คำค้น
        if ($q !== '') {
            $query->where(function($qq) use ($q){
                $words = preg_split('/\s+/u', mb_strtolower($q), -1, PREG_SPLIT_NO_EMPTY);
                foreach ($words as $w) {
                    $qq->orWhereRaw('LOWER(Title)   LIKE ?', ["%{$w}%"])
                       ->orWhereRaw('LOWER(Intro)   LIKE ?', ["%{$w}%"])
                       ->orWhereRaw('LOWER(Details) LIKE ?', ["%{$w}%"])
                       ->orWhereHas('brand',  fn($b)=>$b->whereRaw('LOWER(brand.Brand) LIKE ?', ["%{$w}%"]))
                       ->orWhereHas('mobile', fn($m)=>$m->whereRaw('LOWER(mobile_info.Model) LIKE ?', ["%{$w}%"]));
                }
            });
        }

        // ===== ตัวกรอง =====
        if ($brandSel) $query->where('mobile_news.Brand_ID', $brandSel);
        if ($modelSel) $query->where('mobile_news.Mobile_ID', $modelSel);

        // OS อ้างอิงจากรุ่นมือถือที่โยงกับข่าว (Mobile_ID)
        if ($osSel !== '') {
            $query->whereHas('mobile', function($m) use ($osSel){
                $m->where('OS', 'like', "%{$osSel}%");
            });
        }

        // ===== ช่วง "ปีที่ลงข่าว" → แปลงเป็นช่วงวันเต็มปี =====
        $yf = $request->query('news_year_from');   // ปีเริ่ม
        $yt = $request->query('news_year_to');     // ปีสุดท้าย
        if ($yf !== null || $yt !== null) {
            $yf = (int) ($yf ?: 1900);
            $yt = (int) ($yt ?: 9999);
            if ($yf > $yt) { [$yf, $yt] = [$yt, $yf]; } // กันลากสลับข้าง

            $start = Carbon::create($yf,  1,  1,  0, 0, 0)->startOfDay();
            $end   = Carbon::create($yt, 12, 31, 23, 59, 59)->endOfDay();

            $query->whereBetween('mobile_news.Date', [$start, $end]);
        }

        $items = $query->orderByDesc('mobile_news.Date')
                       ->orderByDesc('mobile_news.ID')
                       ->paginate(10)->withQueryString();

        // ===== ข้อมูลประกอบฟอร์ม =====
        $banners = Banner::where('is_active',1)
            ->whereNotNull('bannerImg')->where('bannerImg','!=','')
            ->orderBy('sort_order')->get();

        $brands  = Brand::orderBy('Brand')->get();

        // รายการรุ่น (ถ้าเลือกแบรนด์แล้ว แสดงเฉพาะแบรนด์นั้น)
        $models = MobileInfo::query()
            ->when($brandSel, fn($qq)=>$qq->where('Brand_ID',$brandSel))
            ->orderBy('Model')
            ->get(['ID','Model','Brand_ID']);

        // รายการ OS สำหรับดรอปดาวน์
        $osList = MobileInfo::query()
            ->whereNotNull('OS')->where('OS','!=','')
            ->select('OS')->distinct()->orderBy('OS')->pluck('OS');

        return view('news', compact('items','banners','brands','models','osList'));
    }

    public function show(MobileNews $news)
    {
        $news->load(['images','brand','mobile']);

        $banners = Banner::where('is_active', 1)
            ->whereNotNull('bannerImg')->where('bannerImg','!=','')
            ->orderBy('sort_order')->get();

        $brands  = Brand::orderBy('Brand')->get();

        return view('news_show', compact('news','banners','brands'));
    }
}
