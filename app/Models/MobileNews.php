<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileNews extends Model
{
    protected $table = 'mobile_news';
    protected $primaryKey = 'ID';
    public $timestamps = false; // มีคอลัมน์ Date เอง

    public function brand()   { return $this->belongsTo(Brand::class, 'Brand_ID', 'ID'); }
    public function mobile()  { return $this->belongsTo(MobileInfo::class, 'Mobile_ID', 'ID'); } // ถ้าใช้
    public function images()  { return $this->hasMany(NewsImg::class, 'News_ID', 'ID'); }
    public function comments(){ return $this->morphMany(Comment::class, 'commentable', 'commentable_type', 'commentable_id'); }
}
