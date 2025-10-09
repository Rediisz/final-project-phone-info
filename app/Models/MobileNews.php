<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class MobileNews extends Model
{
    protected $table = 'mobile_news';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'Title','Intro','Details','Details2','Details3',
        'Date','Brand_ID','Mobile_ID',
    ];

    protected $casts = ['Date' => 'datetime'];

    //ความสัมพันธ์ไป Brand 
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'Brand_ID', 'ID');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable', 'commentable_type', 'commentable_id', 'ID')
                    ->orderByDesc('Date'); // ล่าสุดอยู่บน
    }
    public function mobile()
    {
        return $this->belongsTo(MobileInfo::class, 'Mobile_ID', 'ID');
    }

    // allรูปของข่าว 
    public function images()
    {
        return $this->hasMany(NewsImg::class, 'News_ID', 'ID');
    }

    // รูปปกของข่าว
    public function cover()
    {
        return $this->hasOne(NewsImg::class, 'News_ID', 'ID')->where('IsCover', 1);
    }

    /** URL รูปปก fallback เป็นรูปแรก/placeholder */
    public function coverUrl(): string
    {
        $img = $this->cover()->first() ?? $this->images()->first();
        return $img
            ? asset('storage/'.$img->Img)
            : asset('images/placeholder.png');
    }
    public function scopeSearch(Builder $q, string $term): Builder
    {
        $term = trim($term);
        if ($term === '') return $q;

        $words = preg_split('/\s+/u', mb_strtolower($term), -1, PREG_SPLIT_NO_EMPTY);

        return $q->where(function ($qq) use ($words) {
            foreach ($words as $w) {
                $qq->where(function ($q2) use ($w) {
                    // หัวข้อ / คำเกริ่น / เนื้อหา
                    $q2->whereRaw('LOWER(Title)   LIKE ?', ["%{$w}%"])
                       ->orWhereRaw('LOWER(Intro)   LIKE ?', ["%{$w}%"])
                       ->orWhereRaw('LOWER(Details) LIKE ?', ["%{$w}%"])
                       // แบรนด์ / รุ่นที่โยง
                       ->orWhereHas('brand',  fn($b) => $b->whereRaw('LOWER(brand.Brand) LIKE ?', ["%{$w}%"]))
                       ->orWhereHas('mobile', fn($m) => $m->whereRaw('LOWER(mobile_info.Model) LIKE ?', ["%{$w}%"]));
                });
            }
        });
    }
}
