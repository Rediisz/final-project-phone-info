<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\MobileNews;
use App\Models\NewsImg;
use App\Models\Brand;
use App\Models\MobileInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $items = MobileNews::with(['cover','brand','mobile'])
            ->orderByDesc('Date')
            ->orderByDesc('ID')
            ->paginate(15);

        return view('admin.news.index', compact('items'));
    }

    public function create()
    {
        $brands = Brand::orderBy('Brand')->get(['ID','Brand']);
        return view('admin.news.create', compact('brands'));
    }

    public function store(StoreNewsRequest $request)
    {
        $data = $request->only([
            'Title','Intro','Details','Details2','Details3','Brand_ID','Mobile_ID'
        ]);

        $news = MobileNews::create($data);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('news','public');
            NewsImg::create(['News_ID'=>$news->ID, 'Img'=>$path, 'IsCover'=>1]);
        }
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $f) {
                $path = $f->store('news','public');
                NewsImg::create(['News_ID'=>$news->ID, 'Img'=>$path, 'IsCover'=>0]);
            }
        }
        if (!$news->cover()->exists() && $news->images()->exists()) {
            $news->images()->first()?->update(['IsCover'=>1]);
        }

        return redirect()->route('admin.news.index')->with('ok','สร้างข่าวสำเร็จ');
    }

    public function edit(MobileNews $news)
    {
        $brands  = Brand::orderBy('Brand')->get(['ID','Brand']);
        $mobiles = MobileInfo::where('Brand_ID', $news->Brand_ID)
                    ->orderBy('Model')->get(['ID','Model']);

        $news->load('images','cover','brand','mobile');
        return view('admin.news.edit', compact('news','brands','mobiles'));
    }

    public function update(UpdateNewsRequest $request, MobileNews $news)
{
    $data = $request->only([
        'Title','Intro','Details','Details2','Details3','Brand_ID','Mobile_ID'
    ]);

    $news->update($data);

    $ids = $request->input('remove_image_ids', []);
    if (!empty($ids)) {
    $imgs = NewsImg::where('News_ID',$news->ID)->whereIn('ID',$ids)->get();
    foreach ($imgs as $im) {
        if ($im->Img && Storage::disk('public')->exists($im->Img)) {
            Storage::disk('public')->delete($im->Img);
        }
        $im->delete();
        }
    }


    /* ถ้ามีปกใหม่ */
    if ($request->hasFile('cover')) {
        NewsImg::where('News_ID',$news->ID)->update(['IsCover'=>0]);
        $path = $request->file('cover')->store('news','public');
        NewsImg::create(['News_ID'=>$news->ID,'Img'=>$path,'IsCover'=>1]);
    }

    /* เพิ่มรูปแกลเลอรีใหม่ */
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $f) {
            $path = $f->store('news','public');
            NewsImg::create(['News_ID'=>$news->ID,'Img'=>$path,'IsCover'=>0]);
        }
    }

    /* ถ้าไม่มีปกแล้วแต่ยังมีรูป → ตั้งรูปแรกเป็นปก  */
    if (!$news->cover()->exists() && $news->images()->exists()) {
        $news->images()->first()?->update(['IsCover'=>1]);
    }

    return redirect()->route('admin.news.index')->with('ok','บันทึกข่าวแล้ว');
}

    // เปลี่ยนรูปเป็น "ปก"
    public function setCover(MobileNews $news, NewsImg $img)
    {
        abort_unless($img->News_ID === $news->ID, 404);
        NewsImg::where('News_ID',$news->ID)->update(['IsCover'=>0]);
        $img->update(['IsCover'=>1]);
        return back()->with('ok','ตั้งรูปปกแล้ว');
    }

    // ลบรูปเดี่ยว
    public function deleteImage(MobileNews $news, NewsImg $img)
    {
        abort_unless($img->News_ID === $news->ID, 404);
        Storage::disk('public')->delete($img->Img);
        $img->delete();
        return back()->with('ok','ลบรูปแล้ว');
    }

    // ใช้สำหรับ ajax ดึงรุ่นตาม brand
    public function listMobilesByBrand(Request $request)
    {
        $brandId = (int)$request->query('brand_id');
        $rows = MobileInfo::where('Brand_ID', $brandId)
                ->orderBy('Model')->get(['ID','Model']);
        return response()->json($rows);
    }

    public function destroy(MobileNews $news)
    {
        $news->load('images');

        foreach ($news->images as $img) {
            Storage::disk('public')->delete($img->Img);
        }
        $news->images()->delete();
        $news->delete();

        return redirect()->route('admin.news.index')->with('ok', 'ลบข่าวเรียบร้อยแล้ว');
    }


}
