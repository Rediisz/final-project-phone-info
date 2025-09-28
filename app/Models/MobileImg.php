<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileImg extends Model
{
    protected $table = 'mobile_img';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'Mobile_ID',
        'Img',
        'IsCover',
    ];

    public function mobile()
    {
        return $this->belongsTo(MobileInfo::class, 'Mobile_ID', 'ID');
    }
}
