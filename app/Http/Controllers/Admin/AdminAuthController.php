<?php 
// app/Http/Controllers/Admin/AdminAuthController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLoginForm() { return view('admin.auth.login'); }

    public function login(Request $request)
    {
        $data = $request->validate([
            'User_Name' => ['required','string'],
            'Password' => ['required'],
        ]);

        $user = User::where('User_Name',$data['User_Name'])->first();
        if (!$user || !Hash::check($data['Password'], $user->Password)) {
            return back()->withErrors(['User_Name'=>'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'])->onlyInput('User_Name');
        }

        // เช็ค role เป็น admin เท่านั้น
        if (!$user->role || strtolower($user->role->Role) !== 'admin') {
            return back()->withErrors(['User_Name'=>'คุณไม่มีสิทธิ์แอดมิน'])->onlyInput('User_Name');
        }

        Auth::login($user); // ใช้ session guard ปกติ
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
