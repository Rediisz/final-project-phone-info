<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
}
