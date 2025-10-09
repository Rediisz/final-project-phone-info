<?php
// app/Models/MobileInfo.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MobileInfo extends Model
{
    protected $table = 'mobile_info';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Brand_ID',
        'Model',
        'LaunchDate',
        'OS',
        'Processor',
        'RAM_GB',
        'ScreenSize_in',
        'Display',
        'FrontCamera',
        'BackCamera',
        'Battery_mAh',
        'Network',
        'Material',
        'Weight_g',
        'Price',
    ];

    protected $casts = [
        'LaunchDate'    => 'date',
        'RAM_GB'        => 'integer',
        'ScreenSize_in' => 'decimal:2',
        'Battery_mAh'   => 'integer',
        'Weight_g'      => 'integer',
        'Price'         => 'decimal:2',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'Brand_ID', 'ID');
    }

    public function firstImage()
    {
        return $this->hasOne(MobileImg::class, 'Mobile_ID', 'ID')->where('IsCover', 1);
    }

    /**
     * คอมเมนต์แบบ polymorphic ให้สอดคล้องตาราง comment เดิม
     * - ใช้คอลัมน์ commentable_type / commentable_id
     * - local key ของ MobileInfo คือ 'ID'
     * - เรียงล่าสุดก่อนตามคอลัมน์ Date
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable', 'commentable_type', 'commentable_id', 'ID')
                    ->orderByDesc('Date');
    }

    public function getRouteKeyName()
    {
        return 'ID';
    }

    public function images()
    {
        return $this->hasMany(MobileImg::class, 'Mobile_ID', 'ID');
    }

    public function coverImage()
    {
        return $this->hasOne(MobileImg::class, 'Mobile_ID', 'ID')
                    ->where('IsCover', 1);
    }

    // เรียกใน blade ได้เลย: $mobile->cover_url
    public function getCoverUrlAttribute()
    {
        $imgPath = $this->coverImage->Img ?? $this->images()->value('Img'); // fallback เป็นรูปแรก
        return $imgPath ? asset('storage/'.$imgPath) : asset('images/default.jpg');
    }

    public function scopeSearch(Builder $q, string $term): Builder
    {
        $term = trim($term);
        if ($term === '') return $q;

        $words = preg_split('/\s+/u', mb_strtolower($term), -1, PREG_SPLIT_NO_EMPTY);

        return $q->where(function ($qq) use ($words) {
            foreach ($words as $w) {
                $qq->where(function ($q2) use ($w) {
                    $q2->whereRaw('LOWER(mobile_info.Model) LIKE ?', ["%{$w}%"])
                       ->orWhereHas('brand', fn($b) =>
                           $b->whereRaw('LOWER(brand.Brand) LIKE ?', ["%{$w}%"])
                       );
                });
            }
        });
    }
}
