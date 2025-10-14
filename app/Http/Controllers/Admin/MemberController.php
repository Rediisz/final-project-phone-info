<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $items = User::orderBy('ID')->paginate(15);
        return view('admin.members.index', compact('items'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'User_Name' => ['required','string','max:150'],
            'Email'     => ['nullable','email','unique:user,Email'],
            'Password'  => ['required','string','min:8'],
            'RoleID'    => ['required','integer'], // 1=admin, 2=user
            'Picture'   => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);

        $data = [
            'User_Name' => $request->User_Name,
            'Email'     => $request->Email,
            'Password'  => Hash::make($request->Password),
            'RoleID'    => $request->RoleID,
        ];

        if ($request->hasFile('Picture')) {
            $data['Picture'] = $request->file('Picture')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()
            ->route('admin.members.index')
            ->with('ok','เพิ่มสมาชิกเรียบร้อยแล้ว');
    }

    public function edit(User $user)
    {
        return view('admin.members.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // ถ้าจำเป็นต้องกัน “แก้ role ตัวเอง” ให้เทียบกับ guard แอดมิน
        $isSelf = false; // ผู้ดูแลแก้ข้อมูลสมาชิกทั่วไปได้ตามปกติ

        $rules = [
            'User_Name' => ['required','string','max:150'],
            'Email'     => ['nullable','email','unique:user,Email,'.$user->ID.',ID'],
            'Password'  => ['nullable','string','min:6'],
            'Picture'   => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ];
        if (!$isSelf) {
            $rules['RoleID'] = ['required','integer'];
        }
        $request->validate($rules);

        $user->User_Name = $request->User_Name;
        $user->Email     = $request->Email;

        if (!$isSelf) { // (กันไม่ให้แก้ role ตัวเอง ถ้าเปิดใช้)
            $user->RoleID = $request->RoleID;
        }

        if ($request->filled('Password')) {
            $user->Password = Hash::make($request->Password);
        }

        if ($request->hasFile('Picture')) {
            if ($user->Picture && Storage::disk('public')->exists($user->Picture)) {
                Storage::disk('public')->delete($user->Picture);
            }
            $user->Picture = $request->file('Picture')->store('avatars', 'public');
        }

        $user->save();

        return redirect()
            ->route('admin.members.index')
            ->with('ok','อัปเดตสมาชิกเรียบร้อยแล้ว');
    }

    public function destroy(User $user)
    {
        // ถ้าต้องการกัน “ลบตัวเอง” สำหรับสมาชิก ให้เปิดใช้ได้
        // if ($user->getKey() === auth()->id()) {
        //     return back()->with('error','ไม่สามารถลบบัญชีของตัวเองได้');
        // }

        if ($user->Picture && Storage::disk('public')->exists($user->Picture)) {
            Storage::disk('public')->delete($user->Picture);
        }

        $user->delete();

        return redirect()
            ->route('admin.members.index')
            ->with('ok','ลบผู้ใช้เรียบร้อยแล้ว');
    }
}
