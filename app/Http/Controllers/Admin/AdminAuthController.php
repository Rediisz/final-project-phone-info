<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;  
use GuzzleHttp\Exception\ClientException;            //จับ token error
use Laravel\Socialite\Two\InvalidStateException; 
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;   // ต่อเน็ต/SSL ล้มเหลว
use GuzzleHttp\Exception\RequestException;   // ข้อผิดพลาดฝั่ง request รวม ๆ

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

    public function redirectToGoogle()
    {
        // ส่งผู้ใช้ไป login google 
        return Socialite::driver('google')
            ->stateless() //แก้ invalid state 
            ->scopes(['openid','email','profile'])
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            if ($request->has('error')) {
                return redirect()->route('admin.login')
                    ->withErrors(['google' => 'Google: '.$request->get('error')]);
            }

            // ใช้แบบ default ก่อน (ไม่ setHttpClient, ไม่ verify ไฟล์)
            $gUser = \Laravel\Socialite\Facades\Socialite::driver('google')
                ->stateless()
                ->user();// socialiet แลก token กับ google

            $email = $gUser->getEmail();
            $user  = \App\Models\User::where('Email', $email)->first();

            if (!$user || (int)($user->RoleID ?? 2) !== 1) {
                return redirect()->route('admin.login')
                    ->withErrors(['email' => 'ไม่มีสิทธิ์ผู้ดูแลระบบ']);
            }

            \Illuminate\Support\Facades\Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Google OAuth error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            // debug ที่่ login ไม่ได้ไม่ตรง
            return redirect()->route('admin.login')
                ->withErrors(['google' => 'Google OAuth: '.$e->getMessage()]);
        }
    }
}
