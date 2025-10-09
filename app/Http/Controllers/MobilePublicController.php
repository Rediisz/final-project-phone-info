<?php

namespace App\Http\Controllers;

use App\Models\MobileInfo;

class MobilePublicController extends Controller
{
    public function show($id)
    {
        $mobile = MobileInfo::with(['brand','images','coverImage'])->findOrFail($id);
        return view('mobile.show', compact('mobile'));
    }
}
