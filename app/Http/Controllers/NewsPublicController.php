<?php

namespace App\Http\Controllers;

use App\Models\MobileNews;

class NewsPublicController extends Controller
{
public function show($id)
{
    $news = \App\Models\MobileNews::with(['cover','images','brand','mobile'])->findOrFail($id);
    return view('news.show', compact('news'));  // ← ชื่อวิวถูกต้อง
}
}
