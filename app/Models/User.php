<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

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
}
