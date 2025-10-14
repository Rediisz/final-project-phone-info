<?php
// app/Http/Controllers/Admin/MobileController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMobileRequest;
use App\Http\Requests\UpdateMobileRequest;
use App\Models\MobileInfo;
use App\Models\MobileImg;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MobileController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string)$request->input('q', ''));

        $items = MobileInfo::with(['brand','firstImage'])
            ->when($q !== '', function ($s) use ($q) {
                $s->where(function ($w) use ($q) {
                    $w->where('Model', 'like', "%{$q}%")
                      ->orWhereHas('brand', fn($b) => $b->where('Brand', 'like', "%{$q}%"));
                });
            })
            ->orderByDesc('ID')
            ->paginate(15)
            ->withQueryString();

        return view('admin.phones.index', compact('items','q'));
    }

    public function create()
    {
        $brands = Brand::orderBy('Brand','asc')->get();
        return view('admin.phones.create', compact('brands'));
    }

    public function store(StoreMobileRequest $request)
    {
        DB::transaction(function() use ($request){
            $data = $request->validated();
            unset($data['cover'],$data['images']);

            $m = MobileInfo::create($data);

            if ($request->hasFile('cover')) {
                $path = $request->file('cover')->store('mobiles','public');
                MobileImg::create([
                    'Mobile_ID' => $m->ID,
                    'Img'       => $path,
                    'IsCover'   => 1,
                ]);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $f) {
                    $path = $f->store('mobiles','public');
                    MobileImg::create([
                        'Mobile_ID' => $m->ID,
                        'Img'       => $path,
                        'IsCover'   => 0,
                    ]);
                }
            }

            if (!$m->firstImage && $m->images()->exists()) {
                $first = $m->images()->first();
                $first->update(['IsCover' => 1]);
            }
        });

        return redirect()
            ->route('admin.phones.index')
            ->with('ok','เพิ่มข้อมูลมือถือเรียบร้อยแล้ว');
    }

    public function edit(MobileInfo $mobile)
    {
        $mobile->load(['images','brand']);
        $brands = Brand::orderBy('Brand','asc')->get();
        return view('admin.phones.edit', compact('mobile','brands'));
    }

    public function update(UpdateMobileRequest $request, MobileInfo $mobile)
    {
        DB::transaction(function() use ($request,$mobile){
            $data = $request->validated();
            unset($data['cover'],$data['images'],$data['remove_image_ids']);

            if (empty($data['LaunchDate'])) {
                $data['LaunchDate'] = $mobile->LaunchDate;
            }

            $mobile->update($data);

            if ($ids = $request->input('remove_image_ids')) {
                $imgs = MobileImg::where('Mobile_ID',$mobile->ID)->whereIn('ID',$ids)->get();
                foreach ($imgs as $im) {
                    Storage::disk('public')->delete($im->Img);
                    $im->delete();
                }
            }

            if ($request->hasFile('cover')) {
                $path = $request->file('cover')->store('mobiles','public');
                MobileImg::where('Mobile_ID',$mobile->ID)->update(['IsCover'=>0]);
                MobileImg::create([
                    'Mobile_ID' => $mobile->ID,
                    'Img'       => $path,
                    'IsCover'   => 1,
                ]);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $f) {
                    $path = $f->store('mobiles','public');
                    MobileImg::create([
                        'Mobile_ID' => $mobile->ID,
                        'Img'       => $path,
                        'IsCover'   => 0,
                    ]);
                }
            }

            if (!$mobile->firstImage && $mobile->images()->exists()) {
                $first = $mobile->images()->first();
                $first->update(['IsCover' => 1]);
            }
        });

        return redirect()
            ->route('admin.phones.index')
            ->with('ok','บันทึกการแก้ไขเรียบร้อยแล้ว');
    }

    public function destroy(MobileInfo $mobile)
    {
        DB::transaction(function () use ($mobile) {
            $mobile->loadMissing('images');

            foreach ($mobile->images as $im) {
                if ($im->Img && Storage::disk('public')->exists($im->Img)) {
                    Storage::disk('public')->delete($im->Img);
                }
                $im->delete();
            }

            $mobile->delete();
        });

        return redirect()
            ->route('admin.phones.index')
            ->with('ok','ลบข้อมูลเรียบร้อยแล้ว');
    }

    public function show(MobileInfo $mobile)
    {
        $mobile->load(['brand','images','coverImage']);
        return view('mobile.show', compact('mobile'));
    }
}
