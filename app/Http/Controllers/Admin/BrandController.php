<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
         $brands = Brand::orderByRaw('CASE WHEN SortOrder = 0 THEN 1 ELSE 0 END') // 0 ไปท้าย
                   ->orderBy('SortOrder')   // น้อยไปมาก
                   ->orderBy('Brand')       // ผูกท้ายด้วยชื่อ (กันค่าเท่ากัน)
                   ->paginate(20);          // ✅ เปลี่ยนจาก get() เป็น paginate()

        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        $brand = new Brand();
        return view('admin.brand.create', compact('brand'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'Brand'     => 'required|string|max:120|unique:brand,Brand',
            'SortOrder' => 'nullable|integer|min:0|max:255',
            'IsActive'  => 'sometimes|boolean',
            'logo'      => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ], [], ['Brand'=>'ชื่อแบรนด์','logo'=>'โลโก้']);

        $b = new Brand();
        $b->Brand     = $data['Brand'];
        $b->SortOrder = (int)($data['SortOrder'] ?? 0);
        $b->IsActive  = $r->boolean('IsActive'); // checkbox ไม่ติ๊ก = false

        if ($r->hasFile('logo')) {
            $b->Logo_Path = $r->file('logo')->store('brands/logos', 'public');
        }

        $b->save();

        return redirect()->route('admin.brands.index')->with('ok', 'เพิ่มแบรนด์แล้ว');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $r, Brand $brand)
    {
        $data = $r->validate([
            'Brand'     => 'required|string|max:120|unique:brand,Brand,'.$brand->ID.',ID',
            'SortOrder' => 'nullable|integer|min:0|max:255',
            'IsActive'  => 'sometimes|boolean',
            'logo'      => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ], [], ['Brand'=>'ชื่อแบรนด์','logo'=>'โลโก้']);

        $brand->Brand     = $data['Brand'];
        $brand->SortOrder = (int)($data['SortOrder'] ?? 0);
        $brand->IsActive  = $r->boolean('IsActive');

        if ($r->hasFile('logo')) {
            if ($brand->Logo_Path) {
                Storage::disk('public')->delete($brand->Logo_Path); // ลบไฟล์เก่า
            }
            $brand->Logo_Path = $r->file('logo')->store('brands/logos','public');
        }

        $brand->save();

        return redirect()->route('admin.brands.index')->with('ok', 'บันทึกการแก้ไขแล้ว');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->Logo_Path) {
            Storage::disk('public')->delete($brand->Logo_Path);
        }
        $brand->delete();

        return back()->with('ok', 'ลบแบรนด์แล้ว');
    }
}
