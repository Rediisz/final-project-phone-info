<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\MobileNews;

class NewsPageController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', 1)->orderBy('sort_order')->get();
        $brands  = Brand::orderBy('Brand')->get();

        $items = MobileNews::with(['cover','images','brand','mobile'])
            ->orderByDesc('Date')->orderByDesc('ID')
            ->paginate(10);

        // ชี้ไปที่ไฟล์ news.blade.php (อยู่ระดับเดียวกับ home.blade.php)
        return view('news', compact('banners','brands','items'));
    }

    public function show(MobileNews $news)
    {
        $news->load(['images','brand','mobile']);
        $banners = Banner::where('is_active', 1)->orderBy('sort_order')->get();
        $brands  = Brand::orderBy('Brand')->get();

        return view('news_show', compact('news','banners','brands')); // ถ้าจะทำหน้าเดี่ยว แยกเป็น news_show.blade.php
    }
}
