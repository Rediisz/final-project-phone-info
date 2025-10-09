<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;   // ✅ เพิ่มบรรทัดนี้
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;   // ✅ เพิ่ม trait นี้

    protected $table = 'user';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = ['User_Name', 'Email', 'Password', 'Picture', 'RoleID'];
    protected $hidden = ['Password'];

    public function role() {
        return $this->belongsTo(Role::class, 'RoleID');
    }

    // ✅ บอก Laravel ว่ารหัสผ่านจริงอยู่ในฟิลด์ชื่อ "Password"
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
            : asset('storage/'.$path);
    }

    // ✅ บอก Laravel ให้ใช้คอลัมน์ "Email" สำหรับระบบรีเซ็ตรหัสผ่าน
    public function getEmailForPasswordReset()
    {
        return $this->Email;
    }

    // ✅ บอกระบบ Notification ให้ส่งอีเมลไปที่คอลัมน์ "Email"
    public function routeNotificationForMail(): string
    {
        return $this->Email;
    }
}
