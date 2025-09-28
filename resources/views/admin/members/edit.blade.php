@extends('layouts.admin')

@section('title','แก้ไขสมาชิก | Back Office')

@section('topbar')
  <h1>แก้ไขสมาชิก</h1>
@endsection

@section('content')
  <div class="panel" style="max-width:680px;margin:auto">
    <form method="POST" action="{{ route('admin.members.update', $user->getKey()) }}"
          enctype="multipart/form-data"
          style="display:flex;flex-direction:column;gap:16px">
      @csrf
      @method('PUT')

      <div>
        <label style="font-weight:600">ชื่อผู้ใช้</label>
        <input type="text" name="User_Name" value="{{ old('User_Name', $user->User_Name) }}"
               style="width:100%;padding:8px;border:1px solid var(--line);border-radius:6px">
        @error('User_Name')<div style="color:#dc2626">{{ $message }}</div>@enderror
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
        <div>
          <label style="font-weight:600">อีเมล</label>
          <input type="email" name="Email" value="{{ old('Email', $user->Email) }}"
                 style="width:100%;padding:8px;border:1px solid var(--line);border-radius:6px">
          @error('Email')<div style="color:#dc2626">{{ $message }}</div>@enderror
        </div>

        <div>
          <label style="font-weight:600">รหัสผ่าน (ปล่อยว่างถ้าไม่เปลี่ยน)</label>
          <input type="password" name="Password"
                 style="width:100%;padding:8px;border:1px solid var(--line);border-radius:6px">
          @error('Password')<div style="color:#dc2626">{{ $message }}</div>@enderror
        </div>
      </div>

      <div>
        @php $isSelf = auth()->id() === $user->ID; @endphp

        <label style="font-weight:600">สิทธิ์ผู้ใช้งาน</label>
        <select name="RoleID" @if($isSelf) disabled @endif
                style="width:220px;padding:8px;border:1px solid var(--line);border-radius:6px">
        <option value="2" {{ old('RoleID',$user->RoleID)==2?'selected':'' }}>user</option>
        <option value="1" {{ old('RoleID',$user->RoleID)==1?'selected':'' }}>admin</option>
        </select>
        @if($isSelf)
        <input type="hidden" name="RoleID" value="{{ $user->RoleID }}">
        <div style="color:#64748b;font-size:12px">ไม่สามารถเปลี่ยนสิทธิ์ของบัญชีตัวเองได้</div>
        @endif
        @error('RoleID')<div style="color:#dc2626">{{ $message }}</div>@enderror
      </div>

      {{-- แสดงรูปเดิมและพรีวิวไฟล์ใหม่ทับทันที --}}
      <div>
        <label style="font-weight:600; display:block; margin-bottom:6px">รูปโปรไฟล์</label>
        <img id="previewImg" src="{{ $user->avatar_url }}" alt="avatar"
             style="max-width:220px;border:1px solid #e5e7eb;border-radius:8px;display:block">
        <input id="avatarFile" type="file" name="Picture" accept="image/*" style="display:none">
        <button type="button" id="pickBtn" class="btn"
                style="margin-top:8px;background:#f3f4f6;border:1px solid #d1d5db;padding:8px 12px;border-radius:8px">
          เลือกไฟล์ใหม่
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
      reader.onload = e => img.src = e.target.result;   // เปลี่ยนรูปทับทันที
      reader.readAsDataURL(f);
    });
  })();
</script>
@endpush
