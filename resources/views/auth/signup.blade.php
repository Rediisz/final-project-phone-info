<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8"><title>สมัครสมาชิก | SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body{background:#f3f6fb;font-family:sans-serif;margin:0;color:#0f2342}
    header{background:#0f2342;color:#fff;display:flex;justify-content:space-between;align-items:center;padding:12px 24px}
    .card{max-width:520px;margin:40px auto;background:#fff;border-radius:14px;box-shadow:0 10px 24px rgba(15,35,66,.12);padding:18px}
    .row{display:flex;flex-direction:column;margin-bottom:12px}
    label{font-size:13px;margin-bottom:6px}
    input[type=text],input[type=email],input[type=password]{padding:10px 12px;border:1px solid #d1d5db;border-radius:10px}
    .btn{background:#0f2342;color:#fff;border:0;border-radius:10px;padding:10px 14px;cursor:pointer;width:100%}
    .muted{color:#6b7280;font-size:13px;margin-top:10px;text-align:center}
    .err{color:#b91c1c;font-size:13px;margin-top:4px}

    /* พรีวิวรูป */
    .avatar-wrap{display:flex;gap:14px;align-items:flex-start;flex-wrap:wrap}
    .avatar-box{
      width:220px;height:220px;border:1px solid #e5e7eb;border-radius:12px;
      display:flex;align-items:center;justify-content:center;overflow:hidden;background:#f9fafb;
    }
    .avatar-box img{max-width:100%;max-height:100%;object-fit:cover}
    .avatar-actions{display:flex;align-items:center;gap:10px}
    .btn-ghost{background:#fff;border:1px solid #d1d5db;border-radius:10px;padding:8px 12px;cursor:pointer}
    .file-name{font-size:13px;color:#6b7280}
  </style>
  <style>
    .brand{margin:0;font-size:1.4rem}
    .brand a{color:#fff;text-decoration:none}
    .backhome{background:#fff;color:#0f2342;border:0;border-radius:10px;padding:8px 12px;font-weight:700;text-decoration:none}
    .backhome:hover{filter:brightness(.95)}
    input:focus{outline:3px solid rgba(15,35,66,.15);outline-offset:2px}
    @media (max-width:560px){ .card{margin:24px 12px} .avatar-wrap{gap:10px} }
  </style>
</head>
<body>
<header>
  <h1 class="brand"><a href="{{ route('home') }}">SmartSpec</a></h1>
  <a class="backhome" href="{{ route('home') }}">← กลับหน้าหลัก</a>
</header>

<div class="card">
  <h2 style="margin:0 0 12px">สมัครสมาชิก</h2>

  <form method="POST" action="{{ route('signup') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
      <label>ชื่อผู้ใช้</label>
      <input type="text" name="User_Name" value="{{ old('User_Name') }}" autofocus>
      @error('User_Name')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="row">
      <label>อีเมล</label>
      <input type="email" name="Email" value="{{ old('Email') }}">
      @error('Email')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="row">
      <label>รหัสผ่าน</label>
      <input type="password" name="password">
      @error('password')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="row">
      <label>ยืนยันรหัสผ่าน</label>
      <input type="password" name="password_confirmation">
    </div>

    <div class="row">
      <label>รูปโปรไฟล์ (ไม่บังคับ)</label>

      <div class="avatar-wrap">
        <div class="avatar-box">
          <img id="avatarPreview" alt="Preview"
               src="{{ asset('images/placeholder-user.png') }}">
        </div>

        <div>
          <div class="avatar-actions">
            <label class="btn-ghost" for="picture">เลือกไฟล์</label>
            <button class="btn-ghost" type="button" id="clearPicture">ลบรูป</button>
          </div>
          <div class="file-name" id="fileName">ไม่ได้เลือกไฟล์ใด</div>

          <input id="picture" type="file" name="picture" accept=".jpg,.jpeg,.png,.webp" style="display:none">
          @error('picture')<div class="err" style="margin-top:8px">{{ $message }}</div>@enderror
        </div>
      </div>
    </div>

    <button class="btn" type="submit">สมัครสมาชิก</button>
  </form>

  <div class="muted">มีบัญชีอยู่แล้ว? <a href="{{ route('login') }}">เข้าสู่ระบบ</a></div>
</div>

<script>
(function(){
  const input = document.getElementById('picture');
  const img   = document.getElementById('avatarPreview');
  const fileName = document.getElementById('fileName');
  const clearBtn = document.getElementById('clearPicture');
  const placeholder = "{{ asset('images/placeholder-user.png') }}";

  input.addEventListener('change', () => {
    const f = input.files && input.files[0];
    if (!f) { img.src = placeholder; fileName.textContent = 'ไม่ได้เลือกไฟล์ใด'; return; }

    // แสดงชื่อไฟล์
    fileName.textContent = f.name;

    // พรีวิวภาพ
    const url = URL.createObjectURL(f);
    img.onload = () => URL.revokeObjectURL(url);
    img.src = url;
  });

  clearBtn.addEventListener('click', () => {
    input.value = '';
    img.src = placeholder;
    fileName.textContent = 'ไม่ได้เลือกไฟล์ใด';
  });
})();
</script>
</body>
</html>
