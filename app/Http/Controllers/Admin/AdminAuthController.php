<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'User_Name' => ['required','string'],
            'Password'  => ['required'],
        ],[],[
            'User_Name' => 'ชื่อผู้ใช้',
            'Password'  => 'รหัสผ่าน',
        ]);

        $user = User::where('User_Name', $data['User_Name'])->first();

        if (!$user || !Hash::check($data['Password'], $user->Password)) {
            return back()->withErrors(['User_Name' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'])
                         ->onlyInput('User_Name');
        }

        if (!$user->role || strtolower($user->role->Role) !== 'admin') {
            return back()->withErrors(['User_Name' => 'คุณไม่มีสิทธิ์แอดมิน'])
                         ->onlyInput('User_Name');
        }

        // สำคัญ: แยกเซสชันด้วย guard('admin')
        Auth::guard('admin')->login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    // Google OAuth
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->stateless()
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

            $gUser = Socialite::driver('google')->stateless()->user();
            $email = $gUser->getEmail();

            $user = User::where('Email', $email)->first();

            if (!$user || !$user->role || strtolower($user->role->Role) !== 'admin') {
                return redirect()->route('admin.login')
                    ->withErrors(['email' => 'ไม่มีสิทธิ์ผู้ดูแลระบบ']);
            }

            Auth::guard('admin')->login($user);
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        } catch (\Throwable $e) {
            Log::error('Google OAuth error: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('admin.login')
                ->withErrors(['google' => 'Google OAuth: '.$e->getMessage()]);
        }
    }
    //กันให้ถ้ายังไม่ล็อคอินของ BO ก็ให้เข้าที่หน้าของ BO กันไปเข้าของหน้าบ้าน
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            return $request->is('admin/*') ? route('admin.login') : route('login');
        }
        return null;
    }
}
