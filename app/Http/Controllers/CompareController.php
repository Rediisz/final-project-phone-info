<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MobileInfo;
use App\Models\Brand;
use App\Models\Banner;

class CompareController extends Controller
{
    public function index(Request $request)
    {
        // โหลด banners เหมือนหน้า home
        $banners = Banner::where('is_active', 1)
            ->whereNotNull('bannerImg')
            ->where('bannerImg', '!=', '')
            ->orderBy('sort_order')
            ->get();

        // โหลด brands ไว้โชว์ sidebar เหมือน home
        $brands = Brand::orderBy('Brand')->get();

        // โหลดมือถือที่เลือกมา 3 ช่อง
        $mobiles = [1=>null, 2=>null, 3=>null];
        foreach ([1,2,3] as $slot) {
            $id = $request->query("m$slot");
            if ($id) {
                $mobiles[$slot] = MobileInfo::with(['coverImage','brand'])->find($id);
            }
        }

        return view('compare', compact('banners','brands','mobiles'));
    }
    public function search(Request $request)
    {
        $q = (string) $request->query('q', '');

        $items = MobileInfo::query()
            ->with(['coverImage','images','brand'])
            ->leftJoin('brand', 'brand.ID', '=', 'mobile_info.Brand_ID')
            ->select('mobile_info.*')
            ->search($q) // <<< ใช้ scope เดิม
            ->orderByRaw('
                (CASE WHEN LOWER(mobile_info.Model) LIKE ? THEN 3 ELSE 0 END) +
                (CASE WHEN LOWER(brand.Brand)      LIKE ? THEN 2 ELSE 0 END) +
                (CASE WHEN LOCATE(LOWER(?), LOWER(mobile_info.Model)) > 0 THEN 1 ELSE 0 END)
            DESC, mobile_info.Model ASC
            ', [
                mb_strtolower($q).'%',
                mb_strtolower($q).'%',
                mb_strtolower($q),
            ])
            ->limit(10)
            ->get()
            ->map(function($m){
                $img = $m->coverImage?->Img ?? ($m->images->first()?->Img ?? null);
                return [
                    'id'    => $m->ID,
                    'name'  => $m->Model,
                    'brand' => $m->brand?->Brand,
                    'img'   => $img ? asset('storage/'.$img) : asset('images/default.jpg'),
                ];
            });

        return response()->json(['data' => $items]);
    }
}
