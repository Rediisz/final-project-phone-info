<?php
// app/Models/MobileInfo.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileInfo extends Model
{
    protected $table = 'mobile_info';
    //protected $fillable = ['Mobile_ID', 'Img', 'IsCover'];
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

    public function brand()      { return $this->belongsTo(Brand::class, 'Brand_ID', 'ID'); }
    public function firstImage()
        {
            return $this->hasOne(MobileImg::class, 'Mobile_ID', 'ID')->where('IsCover', 1);
        }
    public function comments()   { return $this->morphMany(Comment::class, 'commentable', 'commentable_type', 'commentable_id'); }
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
}
