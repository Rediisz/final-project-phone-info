<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsImg extends Model
{
    protected $table = 'news_img';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = ['News_ID','Img','IsCover'];


    public function news() { return $this->belongsTo(MobileNews::class, 'News_ID'); }
}
