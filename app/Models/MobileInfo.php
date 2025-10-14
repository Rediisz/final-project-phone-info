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

    /**
     * อนุญาตทุกฟิลด์ (สะดวกเมื่อมีคอลัมน์จำนวนมาก)
     * ถ้าต้องการจำกัดเฉพาะบางฟิลด์ ให้สลับมาใช้ $fillable แทน
     */
    protected $guarded = [];

    /**
     * แปลงชนิดข้อมูลให้ตรงกับสคีมา (อ้างอิงจากรูป structure ที่ส่งมา)
     */
    protected $casts = [
        // วัน/เลขทศนิยม/จำนวนเต็ม
        'LaunchDate'            => 'date',
        'ScreenSize_in'         => 'decimal:1',  // decimal(3,1)
        'Price'                 => 'decimal:2',
        'LaunchPrice'           => 'decimal:2',

        'RAM_GB'                => 'integer',
        'Storage_GB'            => 'integer',
        'Display_RefreshRate'   => 'integer',
        'Display_Brightness'    => 'integer',
        'OS_Updates_Years'      => 'integer',
        'Battery_mAh'           => 'integer',
        'Weight_g'              => 'integer',
        'Charging_Wired_Watt'   => 'integer',
        'Charging_Wireless_Watt'=> 'integer',
        'Charging_Reverse_Watt' => 'integer',

        // tinyint(1) -> boolean
        'Expandable'            => 'boolean',
        'NFC'                   => 'boolean',
        'Infrared'              => 'boolean',
        'eSIM'                  => 'boolean',
        'Jack35'                => 'boolean',
        'Stereo_Speakers'       => 'boolean',
        'Dolby_Atmos'           => 'boolean',
        'Face_Unlock'           => 'boolean',
        'GPS'                   => 'boolean',
    ];

    /** -------------------- Relationships -------------------- */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'Brand_ID', 'ID');
    }

    // รูปทั้งหมด
    public function images()
    {
        return $this->hasMany(MobileImg::class, 'Mobile_ID', 'ID');
    }

    // รูปหน้าปก (IsCover = 1)
    public function coverImage()
    {
        return $this->hasOne(MobileImg::class, 'Mobile_ID', 'ID')
                    ->where('IsCover', 1);
    }

    // (เดิมใช้ชื่อ firstImage) — เก็บไว้ให้เข้ากับโค้ดเก่า
    public function firstImage()
    {
        return $this->hasOne(MobileImg::class, 'Mobile_ID', 'ID')->where('IsCover', 1);
    }

    // คอมเมนต์แบบ polymorphic
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable', 'commentable_type', 'commentable_id', 'ID')
                    ->orderByDesc('Date');
    }

    /** ให้ Router bind ด้วยคีย์ ID */
    public function getRouteKeyName()
    {
        return 'ID';
    }

    /** Accessor: URL ของรูปปก */
    public function getCoverUrlAttribute()
    {
        $imgPath = $this->coverImage->Img ?? $this->images()->value('Img'); // fallback เป็นรูปแรก
        return $imgPath ? asset('storage/'.$imgPath) : asset('images/default.jpg');
    }

    /** -------------------- Scopes / Search -------------------- */
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
