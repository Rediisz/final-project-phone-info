<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MobileInfo;
use App\Models\MobileNews;

class HomeController extends Controller
{
    public function index()
    {
        $news = MobileNews::with('images')
            ->orderByDesc('Date')->limit(5)->get();

        $brands = Brand::orderBy('Brand')->get();

        $mobiles = MobileInfo::with(['firstImage','brand'])
            ->limit(16)->get();

        return view('home', compact('news','brands','mobiles'));
    }
}
