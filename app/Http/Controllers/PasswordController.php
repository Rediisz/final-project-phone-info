<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function requestForm()
    {
        return view('auth.forgot-password');
    }

    public function emailLink(Request $request)
    {
        $request->validate(['email' => ['required','email']], [], ['email' => 'อีเมล']);

        // ใช้คีย์ให้ตรงคอลัมน์ใน DB => Email (E ใหญ่)
        // แสดงข้อความกลางเสมอเพื่อความปลอดภัย (ไม่บอกว่าอีเมลมี/ไม่มี)
        Password::sendResetLink(['Email' => $request->email]);

        return back()->with(['status' => 'ส่งลิงก์รีเซ็ตรหัสผ่านไปให้แล้ว']);
    }

    public function resetForm(string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request('email'),
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:6',
        ], [], [
            'email'    => 'อีเมล',
            'password' => 'รหัสผ่าน',
        ]);

        // ใช้คีย์ Email ให้ตรงกับคอลัมน์ และอัปเดตคอลัมน์ Password (พิมพ์ P ใหญ่)
        $status = Password::reset(
            [
                'Email'                 => $request->email,
                'password'              => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'token'                 => $request->token,
            ],
            function ($user, $password) {
                // อัปเดตเฉพาะคอลัมน์ Password ของคุณ
                $user->forceFill([
                    'Password' => Hash::make($password),
                ])->save();

                event(new \Illuminate\Auth\Events\PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('ok', 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว')
            : back()->withErrors(['email' => 'ลิงก์หมดอายุหรือไม่ถูกต้อง กรุณาขอลิงก์ใหม่']);
    }
}
