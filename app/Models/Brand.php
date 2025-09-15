<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function mobiles()   { return $this->hasMany(MobileInfo::class, 'Brand_ID', 'ID'); }
    public function news()      { return $this->hasMany(MobileNews::class, 'Brand_ID', 'ID'); }
}
