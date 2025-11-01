<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>สมัครสมาชิก | SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
  :root{
    --primary:#0f2342; --primary-light:#1a2f4f;
    --accent:#3b82f6; --accent-light:#dbeafe;
    --success:#10b981; --warning:#f59e0b; --danger:#ef4444;
    --dark:#1f2937; --gray:#6b7280; --light-gray:#f3f4f6; --white:#fff;
    --shadow:0 10px 25px rgba(15,35,66,.1);
    --radius:16px; --radius-lg:20px;
    --gradient:linear-gradient(135deg,#667eea 0%,#764ba2 100%);
    --transition:.3s ease;
  }
  *{box-sizing:border-box}
  body{
    margin:0; min-height:100vh; display:flex; flex-direction:column;
    font-family:system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;
    color:var(--dark);
    background:linear-gradient(to bottom,#f8fafc,#f1f5f9);
    line-height:1.6;
  }

  header{background:var(--primary); color:#fff; display:flex; justify-content:space-between; align-items:center; padding:12px 24px; box-shadow:0 4px 12px rgba(0,0,0,.1); position:sticky; top:0; z-index:100}
  .brand a{font-size:1.6rem; font-weight:700; background:var(--gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; text-decoration:none}
  .backhome{background:#fff; color:var(--primary); border:0; border-radius:10px; padding:10px 16px; font-weight:600; text-decoration:none; transition:var(--transition); font-size:14px; display:flex; align-items:center; gap:6px}
  .backhome:hover{background:var(--light-gray); transform:translateY(-1px); box-shadow:0 2px 8px rgba(0,0,0,.1)}

  .main-wrapper{flex:1; display:flex; align-items:center; justify-content:center; padding:40px 20px}
  .card{width:100%; max-width:580px; background:#fff; border-radius:var(--radius-lg); box-shadow:var(--shadow); border:1px solid rgba(59,130,246,.1); padding:32px; animation:fadeInUp .5s ease-out}
  @keyframes fadeInUp{from{opacity:0; transform:translateY(20px)} to{opacity:1; transform:translateY(0)}}

  .card h2{margin:0 0 24px; font-size:1.75rem; font-weight:700; color:var(--primary); display:flex; align-items:center; gap:8px}
  .card h2 i{color:var(--accent)}

  .form-group{margin-bottom:20px}
  .form-group label{display:block; font-size:14px; font-weight:600; margin-bottom:8px; color:var(--dark)}
  .form-control{width:100%; padding:14px 16px; border:1px solid #e5e7eb; border-radius:12px; font-size:16px; transition:.2s ease; background:var(--light-gray)}
  .form-control:focus{outline:none; border-color:var(--accent); box-shadow:0 0 0 3px rgba(59,130,246,.1); background:#fff}

  .btn{background:var(--primary); color:#fff; border:0; border-radius:var(--radius); padding:12px 18px; cursor:pointer; width:100%; font-weight:600; font-size:15px; transition:.2s ease}
  .btn:hover{background:var(--primary-light); transform:translateY(-2px); box-shadow:0 4px 12px rgba(15,35,66,.15)}
  .btn:active{transform:translateY(0)}

  .muted{color:var(--gray); font-size:14px; margin-top:20px; text-align:center}
  .muted a{color:var(--primary); text-decoration:none; font-weight:500}
  .muted a:hover{text-decoration:underline}

  .err{color:var(--danger); font-size:13px; margin-top:6px; font-weight:500}

  /* พรีวิวรูป */
  .avatar-wrap{display:flex; gap:16px; align-items:flex-start; flex-wrap:wrap; justify-content:center}
  .avatar-box{width:220px; height:220px; border:2px solid #e5e7eb; border-radius:16px; display:flex; align-items:center; justify-content:center; overflow:hidden; background:var(--light-gray); transition:.2s}
  .avatar-box:hover{border-color:var(--primary); box-shadow:0 4px 12px rgba(15,35,66,.1)}
  .avatar-box img{max-width:100%; max-height:100%; object-fit:cover}
  .avatar-actions{display:flex; align-items:center; gap:10px; margin-bottom:8px}
  .btn-ghost{background:#fff; border:1px solid #d1d5db; border-radius:10px; padding:10px 16px; cursor:pointer; font-weight:500; font-size:14px; transition:.2s}
  .btn-ghost:hover{background:var(--light-gray); border-color:var(--primary); transform:translateY(-1px); box-shadow:0 2px 8px rgba(0,0,0,.1)}
  .file-name{font-size:13px; color:var(--gray); text-align:center; margin-top:8px}

  @media (max-width:768px){
    .main-wrapper{padding:20px 16px}
    .card{margin:30px 16px; padding:24px; max-width:90%}
    .card h2{font-size:1.5rem}
    .avatar-wrap{gap:12px; justify-content:center}
    .avatar-box{width:180px; height:180px}
  }

  @media (max-width:520px){
    .main-wrapper{padding:16px 12px}
    .card{margin:20px 12px; padding:20px}
    .card h2{font-size:1.4rem}
    .avatar-box{width:160px; height:160px}
  }
  </style>
</head>
<body>
  @include('layouts.navbar')

  <div class="main-wrapper">
    <div class="card">
      <h2><i class="fas fa-user-plus"></i> สมัครสมาชิก</h2>

      <form method="POST" action="{{ route('signup') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label for="User_Name">ชื่อผู้ใช้</label>
          <input type="text" id="User_Name" name="User_Name" value="{{ old('User_Name') }}" autofocus class="form-control">
          @error('User_Name') <div class="err"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label for="Email">อีเมล</label>
          <input type="email" id="Email" name="Email" value="{{ old('Email') }}" class="form-control">
          @error('Email') <div class="err"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label for="password">รหัสผ่าน</label>
          <input type="password" id="password" name="password" class="form-control">
          @error('password') <div class="err"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
          <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
          @error('password_confirmation') <div class="err"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label>รูปโปรไฟล์ (ไม่บังคับ)</label>
          <div class="avatar-wrap">
            <div class="avatar-box">
              <img id="avatarPreview" alt="Preview" src="{{ asset('images/placeholder-user.png') }}">
            </div>
            <div>
              <div class="avatar-actions">
                <label class="btn-ghost" for="picture">เลือกไฟล์</label>
                <button class="btn-ghost" type="button" id="clearPicture">ลบรูป</button>
              </div>
              <div class="file-name" id="fileName">ไม่ได้เลือกไฟล์ใด</div>
              <input id="picture" type="file" name="picture" accept=".jpg,.jpeg,.png,.webp" style="display:none;">
              @error('picture') <div class="err"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
          </div>
        </div>

        <button class="btn" type="submit"><i class="fas fa-user-plus"></i> สมัครสมาชิก</button>
      </form>

      <div class="muted">
        มีบัญชีอยู่แล้ว? <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ</a>
      </div>
    </div>
  </div>

  <script>
  (function(){
    const input = document.getElementById('picture');
    const img = document.getElementById('avatarPreview');
    const fileName = document.getElementById('fileName');
    const clearBtn = document.getElementById('clearPicture');
    const placeholder = "{{ asset('images/placeholder-user.png') }}";

    input.addEventListener('change', () => {
      const f = input.files && input.files[0];
      if (!f) {
        img.src = placeholder;
        fileName.textContent = 'ไม่ได้เลือกไฟล์ใด';
        return;
      }
      fileName.textContent = f.name;
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
