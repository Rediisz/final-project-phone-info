<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8"><title>เข้าสู่ระบบ | SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    *{box-sizing:border-box}
    body{background:#f3f6fb;font-family:system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;margin:0;color:#0f2342;line-height:1.6}
    header{background:#0f2342;color:#fff;display:flex;justify-content:space-between;align-items:center;padding:14px 24px;box-shadow:0 2px 8px rgba(0,0,0,.1)}
    .card{max-width:440px;margin:50px auto;background:#fff;border-radius:18px;box-shadow:0 8px 32px rgba(15,35,66,.1);padding:32px;border:1px solid #e8eef5}
    .card h2{margin:0 0 24px;font-size:1.75rem;font-weight:700;color:#0f2342}
    .row{display:flex;flex-direction:column;margin-bottom:18px}
    label{font-size:14px;font-weight:600;margin-bottom:8px;color:#374151}
    input[type=text],input[type=password]{padding:12px 16px;border:1px solid #d1d5db;border-radius:12px;font-size:14px;font-family:inherit;transition:all .2s ease;background:#fff}
    input[type=text]:focus,input[type=password]:focus{outline:none;border-color:#0f2342;box-shadow:0 0 0 3px rgba(15,35,66,.08)}
    .btn{background:#0f2342;color:#fff;border:0;border-radius:12px;padding:12px 18px;cursor:pointer;width:100%;font-weight:600;font-size:15px;transition:all .2s ease;margin-top:8px}
    .btn:hover{background:#0a1a2e;transform:translateY(-1px);box-shadow:0 4px 12px rgba(15,35,66,.15)}
    .btn:active{transform:translateY(0)}
    .muted{color:#6b7280;font-size:14px;margin-top:20px;text-align:center}
    .muted a{color:#0f2342;text-decoration:none;font-weight:500}
    .muted a:hover{text-decoration:underline}
    .err{color:#b91c1c;font-size:13px;margin-top:6px;font-weight:500}
    .brand{margin:0;font-size:1.5rem;font-weight:700}
    .brand a{color:#fff;text-decoration:none}
    .backhome{background:#fff;color:#0f2342;border:0;border-radius:10px;padding:10px 16px;font-weight:600;text-decoration:none;transition:all .2s ease;font-size:14px}
    .backhome:hover{background:#f9fafb;transform:translateY(-1px);box-shadow:0 2px 8px rgba(0,0,0,.1)}
    @media (max-width:520px){ .card{margin:30px 16px;padding:24px} }
  </style>
</head>
<body>
<header>
  <h1 class="brand"><a href="{{ route('home') }}">SmartSpec</a></h1>
  <a class="backhome" href="{{ route('home') }}">← กลับหน้าหลัก</a>
</header>

<div class="card">
  <h2 style="margin:0 0 12px">เข้าสู่ระบบ</h2>

  @if(session('ok'))
    <div style="background:#ecfdf5;border:1px solid #34d399;color:#065f46;padding:8px 10px;border-radius:8px;margin-bottom:10px">
      {{ session('ok') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="row">
      <label>อีเมลหรือชื่อผู้ใช้</label>
      <input type="text" name="login" value="{{ old('login') }}" autofocus>
      @error('login')<div class="err">{{ $message }}</div>@enderror
    </div>
    <div class="row">
      <label>รหัสผ่าน</label>
      <input type="password" name="password">
      @error('password')<div class="err">{{ $message }}</div>@enderror
    </div>
    <button class="btn" type="submit">เข้าสู่ระบบ</button>
    <div class="muted"><a href="{{ route('password.request') }}">ลืมรหัสผ่าน?</a></div>

  </form>

  <div class="muted">ยังไม่มีบัญชี? <a href="{{ route('signup') }}">สมัครสมาชิก</a></div>
</div>
</body>
</html>
