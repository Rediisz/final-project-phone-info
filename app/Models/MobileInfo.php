<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileInfo extends Model
{
    protected $table = 'mobile_info';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function brand()     { return $this->belongsTo(Brand::class, 'Brand_ID', 'ID'); }
    public function images()    { return $this->hasMany(MobileImg::class, 'Mobile_ID', 'ID'); }
    public function firstImage(){ return $this->hasOne(MobileImg::class, 'Mobile_ID', 'ID')->oldest('ID'); }
    public function comments()  { return $this->morphMany(Comment::class, 'commentable', 'commentable_type', 'commentable_id'); }
}
