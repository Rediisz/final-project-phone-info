<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()  { return view('auth.login'); }
    public function showSignup() { return view('auth.signup'); }

    public function storeSignup(Request $request)
    {
        $data = $request->validate([
            'User_Name' => ['required','string','max:100','unique:user,User_Name'],
            'Email'     => ['required','email','max:150','unique:user,Email'],
            'password'  => ['required','string','min:6','confirmed'],
            'picture'   => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ],[],[
            'User_Name' => 'ชื่อผู้ใช้',
            'Email'     => 'อีเมล',
            'password'  => 'รหัสผ่าน',
            'picture'   => 'รูปโปรไฟล์',
        ]);

        // จัดเก็บรูป (ถ้ามี)
        $path = null;
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('users','public'); // storage/app/public/users/...
        }

        // สร้างผู้ใช้ใหม่ (คอลัมน์ตามโมเดล: User_Name, Email, Password, Picture, RoleID)
        $user = User::create([
            'User_Name' => $data['User_Name'],
            'Email'     => $data['Email'],
            'Password'  => Hash::make($data['password']),
            'Picture'   => $path,
            'RoleID'    => $request->input('RoleID', 2), // ถ้าอยากกำหนด default role ใส่ค่าตรงนี้ได้
        ]);

        // ล็อกอินทันทีหลังสมัคร (remember=false)
        Auth::login($user);

        return redirect()->route('home')->with('ok','สมัครสมาชิกสำเร็จและเข้าสู่ระบบแล้ว');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => ['required','string','max:150'],
            'password' => ['required','string'],
        ],[],[
            'login'    => 'อีเมลหรือชื่อผู้ใช้',
            'password' => 'รหัสผ่าน',
        ]);

        $login    = $request->input('login');
        $password = $request->input('password');

        $credentials = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? ['Email' => $login, 'password' => $password]
            : ['User_Name' => $login, 'password' => $password];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()
            ->withErrors(['login' => 'ข้อมูลเข้าสู่ระบบไม่ถูกต้อง'])
            ->withInput($request->only('login'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
