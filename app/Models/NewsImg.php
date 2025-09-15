<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsImg extends Model
{
    protected $table = 'news_img';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function news() { return $this->belongsTo(MobileNews::class, 'News_ID', 'ID'); }
}
