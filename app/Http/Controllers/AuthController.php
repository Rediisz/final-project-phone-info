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
        $data = $request->validate(
            // Rules
            [
                'User_Name' => ['required','string','max:100','unique:user,User_Name'],
                'Email'     => ['required','email','max:150','unique:user,Email'],
                'password'  => ['required','string','min:6','confirmed'],
                'picture'   => ['required','image','mimes:jpg,jpeg,png,webp','max:2048'],
            ],
            // Messages (ไทย)
            [
                'required'  => 'กรุณากรอก :attribute',
                'string'    => ':attribute ต้องเป็นตัวอักษร',
                'email'     => 'รูปแบบ :attribute ไม่ถูกต้อง',
                'min'       => [
                    'string' => ':attribute ต้องมีอย่างน้อย :min ตัวอักษร',
                ],
                'max'       => [
                    'string' => ':attribute ต้องไม่เกิน :max ตัวอักษร',
                    'file'   => ':attribute ต้องมีขนาดไม่เกิน :max กิโลไบต์',
                ],
                'confirmed' => 'ยืนยัน :attribute ไม่ตรงกัน',
                'unique'    => ':attribute นี้ถูกใช้งานแล้ว',
                'image'     => ':attribute ต้องเป็นไฟล์รูปภาพ',
                'mimes'     => ':attribute ต้องเป็นไฟล์ประเภท: :values',
            ],
            // Attributes (ชื่อฟิลด์ไทย)
            [
                'User_Name'             => 'ชื่อผู้ใช้',
                'Email'                 => 'อีเมล',
                'password'              => 'รหัสผ่าน',
                'password_confirmation' => 'ยืนยันรหัสผ่าน',
                'picture'               => 'รูปโปรไฟล์',
            ]
        );

        // จัดเก็บรูป (ถ้ามี)
        $path = null;
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('users','public'); // storage/app/public/users/...
        }

        // สร้างผู้ใช้ใหม่
        $user = User::create([
            'User_Name' => $data['User_Name'],
            'Email'     => $data['Email'],
            'Password'  => Hash::make($data['password']),
            'Picture'   => $path,
            'RoleID'    => $request->input('RoleID', 2),
        ]);

        // ล็อกอินทันทีหลังสมัคร
        Auth::login($user);

        return redirect()->route('home')->with('ok','สมัครสมาชิกสำเร็จและเข้าสู่ระบบแล้ว');
    }

    public function login(Request $request)
    {
        $request->validate(
            // Rules
            [
                'login'    => ['required','string','max:150'],
                'password' => ['required','string'],
            ],
            // Messages (ไทย)
            [
                'required' => 'กรุณากรอก :attribute',
                'string'   => ':attribute ต้องเป็นตัวอักษร',
                'max'      => [
                    'string' => ':attribute ต้องไม่เกิน :max ตัวอักษร',
                ],
            ],
            // Attributes (ชื่อฟิลด์ไทย)
            [
                'login'    => 'อีเมลหรือชื่อผู้ใช้',
                'password' => 'รหัสผ่าน',
            ]
        );

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
