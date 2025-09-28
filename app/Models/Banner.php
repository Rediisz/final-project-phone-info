<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Banner extends Model
{
    protected $table = 'banner';    
    protected $primaryKey = 'bannerID';
    public $timestamps = true;

    protected $fillable = [
        'bannerName', 'bannerImg', 'is_active', 'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ทำให้เรียก $banner->image_url ได้
    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): string
    {
        if (!$this->bannerImg) {
            return asset('images/placeholder.png'); // เผื่อไม่มีรูป
        }

        // ถ้าเป็น URL ภายนอกอยู่แล้ว
        if (Str::startsWith($this->bannerImg, ['http://','https://','//'])) {
            return $this->bannerImg;
        }

        // path storage (เก็บแค่ banners/xxxx.jpg)
        return asset('storage/'.$this->bannerImg);
    }
}
