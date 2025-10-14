<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = ['Brand','Logo_Path','SortOrder','IsActive'];
    
    public function getLogoUrlAttribute(): string
    {
        return $this->Logo_Path
            ? asset('storage/'.$this->Logo_Path)
            : asset('images/brand-placeholder.png'); // สร้างไฟล์นี้ไว้ได้
    }


    public function mobiles()   { return $this->hasMany(MobileInfo::class, 'Brand_ID', 'ID'); }
    public function news()      { return $this->hasMany(MobileNews::class, 'Brand_ID', 'ID'); }
}
