<?php
// app/Http/Controllers/Admin/MemberController.php
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

        return redirect()->route('admin.members.index')->with('success','เพิ่มสมาชิกเรียบร้อย');
    }

    public function edit(User $user)
    {
        return view('admin.members.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $isSelf = $user->getKey() === auth()->id(); // แก้ตัวเองหรือไม่

        // ถ้าเป็นตัวเอง บังคับให้ RoleID กลับเป็นค่าปัจจุบัน (กันแก้สิทธิ์)
        if ($isSelf) {
            $request->merge(['RoleID' => $user->RoleID]);
        }

        // ถ้าเป็นตัวเองไม่ต้องตรวจ RoleID
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

        if (!$isSelf) { // ไม่ให้แก้ role ของตัวเอง
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

        return redirect()->route('admin.members.index')->with('success','อัปเดตสมาชิกเรียบร้อย');
    }


    public function destroy(User $user)
    {
        // Xลบตัวเอง
        if ($user->getKey() === auth()->id()) {
            return back()->with('error', 'ไม่สามารถลบบัญชีของตัวเองได้');
        }

        // ลบรูปโปรไฟล์ถ้ามี
        if ($user->Picture && Storage::disk('public')->exists($user->Picture)) {
            Storage::disk('public')->delete($user->Picture);
        }

        $user->delete();

        return redirect()->route('admin.members.index')->with('success', 'ลบผู้ใช้เรียบร้อย');
    }
}
