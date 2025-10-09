<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    // ✅ อนุญาต mass assignment
    protected $guarded = []; 
    protected $casts = ['Date' => 'datetime'];

    public function commentable() { return $this->morphTo(__FUNCTION__, 'commentable_type', 'commentable_id'); }
    public function user()        { return $this->belongsTo(User::class, 'User_ID', 'ID'); }
}