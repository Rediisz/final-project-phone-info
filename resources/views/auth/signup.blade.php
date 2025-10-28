<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8"><title>สมัครสมาชิก | SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    *{box-sizing:border-box}
    body{background:#f3f6fb;font-family:system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;margin:0;color:#0f2342;line-height:1.6}
    header{background:#0f2342;color:#fff;display:flex;justify-content:space-between;align-items:center;padding:14px 24px;box-shadow:0 2px 8px rgba(0,0,0,.1)}
    .card{max-width:580px;margin:50px auto;background:#fff;border-radius:18px;box-shadow:0 8px 32px rgba(15,35,66,.1);padding:32px;border:1px solid #e8eef5}
    .card h2{margin:0 0 24px;font-size:1.75rem;font-weight:700;color:#0f2342}
    .row{display:flex;flex-direction:column;margin-bottom:18px}
    label{font-size:14px;font-weight:600;margin-bottom:8px;color:#374151}
    input[type=text],input[type=email],input[type=password]{padding:12px 16px;border:1px solid #d1d5db;border-radius:12px;font-size:14px;font-family:inherit;transition:all .2s ease;background:#fff}
    input[type=text]:focus,input[type=email]:focus,input[type=password]:focus{outline:none;border-color:#0f2342;box-shadow:0 0 0 3px rgba(15,35,66,.08)}
    .btn{background:#0f2342;color:#fff;border:0;border-radius:12px;padding:12px 18px;cursor:pointer;width:100%;font-weight:600;font-size:15px;transition:all .2s ease;margin-top:8px}
    .btn:hover{background:#0a1a2e;transform:translateY(-1px);box-shadow:0 4px 12px rgba(15,35,66,.15)}
    .btn:active{transform:translateY(0)}
    .muted{color:#6b7280;font-size:14px;margin-top:20px;text-align:center}
    .muted a{color:#0f2342;text-decoration:none;font-weight:500}
    .muted a:hover{text-decoration:underline}
    .err{color:#b91c1c;font-size:13px;margin-top:6px;font-weight:500}

    /* พรีวิวรูป */
    .avatar-wrap{display:flex;gap:16px;align-items:flex-start;flex-wrap:wrap}
    .avatar-box{
      width:220px;height:220px;border:2px solid #e5e7eb;border-radius:16px;
      display:flex;align-items:center;justify-content:center;overflow:hidden;background:#f9fafb;
      transition:border-color .2s ease,box-shadow .2s ease
    }
    .avatar-box:hover{border-color:#0f2342;box-shadow:0 4px 12px rgba(15,35,66,.1)}
    .avatar-box img{max-width:100%;max-height:100%;object-fit:cover}
    .avatar-actions{display:flex;align-items:center;gap:10px;margin-bottom:8px}
    .btn-ghost{background:#fff;border:1px solid #d1d5db;border-radius:10px;padding:10px 16px;cursor:pointer;font-weight:500;transition:all .2s ease;font-size:14px}
    .btn-ghost:hover{background:#f9fafb;border-color:#0f2342;transform:translateY(-1px);box-shadow:0 2px 8px rgba(0,0,0,.1)}
    .file-name{font-size:13px;color:#6b7280;font-weight:500}
    .brand{margin:0;font-size:1.5rem;font-weight:700}
    .brand a{color:#fff;text-decoration:none}
    .backhome{background:#fff;color:#0f2342;border:0;border-radius:10px;padding:10px 16px;font-weight:600;text-decoration:none;transition:all .2s ease;font-size:14px}
    .backhome:hover{background:#f9fafb;transform:translateY(-1px);box-shadow:0 2px 8px rgba(0,0,0,.1)}
    @media (max-width:560px){ .card{margin:30px 16px;padding:24px} .avatar-wrap{gap:12px} .avatar-box{width:180px;height:180px} }
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
