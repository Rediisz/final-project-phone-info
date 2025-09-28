<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = ['User_Name', 'Email', 'Password', 'Picture', 'RoleID'];
    protected $hidden = ['Password'];

    public function role() { return $this->belongsTo(Role::class, 'RoleID'); }

    // บอก Laravel ว่าฟิลด์รหัสผ่านชื่ออะไร (ไม่ใช่ 'password')
    public function getAuthPassword()
    {
        return $this->Password;
    }

    protected $appends = ['avatar_url'];

    public function getAvatarUrlAttribute(): string
    {
        if (empty($this->Picture)) {
            return asset('images/placeholder-user.png');
        }
        $path = str_replace('\\','/',$this->Picture);
        return Str::startsWith($path, ['http://','https://','//'])
            ? $path
            : asset('storage/'.$path); // storage/app/public/...
    }
}
