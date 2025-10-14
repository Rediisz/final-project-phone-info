<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    // LIST
    public function index()
    {
        // เรียงด้วย sort_order ก่อน แล้ว fallback ด้วย bannerID (ใหม่กว่าอยู่บนเมื่อ sort เท่ากัน)
        $banners = Banner::orderBy('sort_order')
            ->orderByDesc('bannerID')
            ->paginate(15);

        return view('admin.banners.index', compact('banners'));
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.banners.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'bannerName' => ['required','string','max:255'],
            'image'      => ['required','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active'  => ['nullable','boolean'],
            'sort_order' => ['nullable','integer'],
        ]);

        // เก็บไฟล์
        $path = $request->file('image')->store('banners', 'public');

        Banner::create([
            'bannerName' => $request->bannerName,
            'bannerImg'  => $path,
            'is_active'  => $request->boolean('is_active'),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        // ✅ ใช้ ok ให้ตรงกับ layout
        return redirect()->route('admin.banners.index')
                         ->with('ok', 'เพิ่มแบนเนอร์เรียบร้อยแล้ว');
    }

    // EDIT FORM
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    // UPDATE
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'bannerName' => ['required','string','max:255'],
            'image'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'is_active'  => ['nullable','boolean'],
            'sort_order' => ['nullable','integer'],
        ]);

        $data = [
            'bannerName' => $request->bannerName,
            'is_active'  => $request->boolean('is_active'),
            'sort_order' => $request->input('sort_order', $banner->sort_order),
        ];

        if ($request->hasFile('image')) {
            if ($banner->bannerImg && Storage::disk('public')->exists($banner->bannerImg)) {
                Storage::disk('public')->delete($banner->bannerImg);
            }
            $data['bannerImg'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')
                         ->with('ok', 'อัปเดตแบนเนอร์เรียบร้อยแล้ว');
    }

    // TOGGLE ACTIVE
    public function toggle(Request $request, Banner $banner)
    {
        $banner->is_active = ! $banner->is_active;
        $banner->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success'   => true,
                'is_active' => (bool) $banner->is_active,
                'id'        => $banner->bannerID,
            ]);
        }

        return back()->with('ok', 'อัปเดตสถานะแบนเนอร์แล้ว');
    }

    // SORT
    public function sort(Banner $banner, string $direction)
    {
        if (!in_array($direction, ['up','down'])) {
            return back();
        }

        $operator = $direction === 'up' ? '<' : '>';
        $order    = $direction === 'up' ? 'desc' : 'asc';

        $neighbor = Banner::where('sort_order', $operator, $banner->sort_order)
            ->orderBy('sort_order', $order)
            ->first();

        if ($neighbor) {
            $tmp = $banner->sort_order;
            $banner->sort_order = $neighbor->sort_order;
            $neighbor->sort_order = $tmp;
            $banner->save();
            $neighbor->save();
        } else {
            $banner->sort_order += ($direction === 'up' ? -1 : 1);
            $banner->save();
        }

        return back()->with('ok', 'จัดลำดับแบนเนอร์แล้ว');
    }

    // DESTROY
    public function destroy(Banner $banner)
    {
        if ($banner->bannerImg && Storage::disk('public')->exists($banner->bannerImg)) {
            Storage::disk('public')->delete($banner->bannerImg);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
                         ->with('ok', 'ลบแบนเนอร์เรียบร้อยแล้ว');
    }
}
