@extends('layouts.admin')

@section('title','เพิ่มสมาชิก | Back Office')

@section('topbar')
  <h1>เพิ่มสมาชิก</h1>
@endsection

@section('content')
  <div class="panel" style="max-width:680px;margin:auto">
    <form method="POST" action="{{ route('admin.members.store') }}"
          enctype="multipart/form-data"
          style="display:flex;flex-direction:column;gap:16px">
      @csrf

      <div>
        <label style="font-weight:600">ชื่อผู้ใช้</label>
        <input type="text" name="User_Name" value="{{ old('User_Name') }}"
               style="width:100%;padding:8px;border:1px solid var(--line);border-radius:6px">
        @error('User_Name')<div style="color:#dc2626">{{ $message }}</div>@enderror
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
        <div>
          <label style="font-weight:600">อีเมล</label>
          <input type="email" name="Email" value="{{ old('Email') }}"
                 style="width:100%;padding:8px;border:1px solid var(--line);border-radius:6px">
          @error('Email')<div style="color:#dc2626">{{ $message }}</div>@enderror
        </div>

        <div>
          <label style="font-weight:600">รหัสผ่าน</label>
          <input type="password" name="Password"
                 style="width:100%;padding:8px;border:1px solid var(--line);border-radius:6px">
          @error('Password')<div style="color:#dc2626">{{ $message }}</div>@enderror
        </div>
      </div>

      <div>
        <label style="font-weight:600">สิทธิ์ผู้ใช้งาน</label>
        <select name="RoleID" style="width:220px;padding:8px;border:1px solid var(--line);border-radius:6px">
          <option value="2" {{ old('RoleID',2)==2?'selected':'' }}>user</option>
          <option value="1" {{ old('RoleID')==1?'selected':'' }}>admin</option>
        </select>
        @error('RoleID')<div style="color:#dc2626">{{ $message }}</div>@enderror
      </div>

      <div>
        <label style="font-weight:600; display:block; margin-bottom:6px">รูปโปรไฟล์</label>

        <img id="previewImg" src="{{ asset('images/placeholder-user.png') }}"
             alt="avatar" style="max-width:220px;border:1px solid #e5e7eb;border-radius:8px;display:block">

        <input id="avatarFile" type="file" name="Picture" accept="image/*" style="display:none">
        <button type="button" id="pickBtn" class="btn"
                style="margin-top:8px;background:#f3f4f6;border:1px solid #d1d5db;padding:8px 12px;border-radius:8px">
          เลือกไฟล์
        </button>
        <span id="fileName" style="margin-left:10px;color:#065f46">ยังไม่ได้เลือกไฟล์</span>
        @error('Picture')<div style="color:#dc2626">{{ $message }}</div>@enderror
      </div>

      <div style="display:flex;gap:8px">
        <button type="submit" class="btn" style="background:var(--primary);color:#fff">บันทึก</button>
        <a href="{{ route('admin.members.index') }}" class="btn" style="background:#ddd">ยกเลิก</a>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
<script>
  (function(){
    const input = document.getElementById('avatarFile');
    const btn = document.getElementById('pickBtn');
    const nameEl = document.getElementById('fileName');
    const img = document.getElementById('previewImg');

    btn.addEventListener('click', ()=> input.click());
    input.addEventListener('change', ()=>{
      const f = input.files?.[0];
      nameEl.textContent = f ? f.name : 'ยังไม่ได้เลือกไฟล์';
      if (!f) return;
      const reader = new FileReader();
      reader.onload = e => img.src = e.target.result; // พรีวิวทับรูปเดิมทันที
      reader.readAsDataURL(f);
    });
  })();
</script>
@endpush
