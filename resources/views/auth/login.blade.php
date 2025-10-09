<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8"><title>เข้าสู่ระบบ | SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <style>
    body{background:#f3f6fb;font-family:sans-serif;margin:0;color:#0f2342}
    header{background:#0f2342;color:#fff;display:flex;justify-content:space-between;align-items:center;padding:12px 24px}
    .card{max-width:420px;margin:40px auto;background:#fff;border-radius:14px;box-shadow:0 10px 24px rgba(15,35,66,.12);padding:18px}
    .row{display:flex;flex-direction:column;margin-bottom:12px}
    label{font-size:13px;margin-bottom:6px}
    input[type=text],input[type=password]{padding:10px 12px;border:1px solid #d1d5db;border-radius:10px}
    .btn{background:#0f2342;color:#fff;border:0;border-radius:10px;padding:10px 14px;cursor:pointer;width:100%}
    .muted{color:#6b7280;font-size:13px;margin-top:10px;text-align:center}
    .err{color:#b91c1c;font-size:13px;margin-top:4px}
  </style>
</head>
<body>
<header></header>

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
