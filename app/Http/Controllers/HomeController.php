<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MobileInfo;
use App\Models\MobileNews;
use App\Models\Banner;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', 1)
            ->whereNotNull('bannerImg')
            ->where('bannerImg', '!=', '')
            ->orderBy('sort_order')
            ->get();

        $brands = Brand::orderBy('Brand')->get();
        $mobiles = MobileInfo::with(['firstImage','brand'])->limit(16)->get();

        return view('home', compact('banners','brands','mobiles'));
    }

}
