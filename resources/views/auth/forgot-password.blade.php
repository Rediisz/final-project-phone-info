<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8"><title>ลืมรหัสผ่าน | SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <style>
    body{background:#f3f6fb;font-family:sans-serif;margin:0;color:#0f2342}
    header{background:#0f2342;color:#fff;display:flex;justify-content:space-between;align-items:center;padding:12px 24px}
    .card{max-width:420px;margin:40px auto;background:#fff;border-radius:14px;box-shadow:0 10px 24px rgba(15,35,66,.12);padding:18px}
    .row{display:flex;flex-direction:column;margin-bottom:12px}
    label{font-size:13px;margin-bottom:6px}
    input[type=email]{padding:10px 12px;border:1px solid #d1d5db;border-radius:10px}
    .btn{background:#0f2342;color:#fff;border:0;border-radius:10px;padding:10px 14px;cursor:pointer;width:100%}
    .muted{color:#6b7280;font-size:13px;margin-top:10px;text-align:center}
    .err{color:#b91c1c;font-size:13px;margin-top:4px}
    .ok{background:#ecfdf5;border:1px solid #34d399;color:#065f46;padding:8px 10px;border-radius:8px;margin-bottom:10px}
  </style>
</head>
<body>
<header></header>

<div class="card">
  <h2 style="margin:0 0 12px">ลืมรหัสผ่าน</h2>

  @if (session('status')) <div class="ok">{{ session('status') }}</div> @endif

  <form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="row">
      <label>อีเมล</label>
      <input type="email" name="email" value="{{ old('email') }}" autofocus required>
      @error('email')<div class="err">{{ $message }}</div>@enderror
    </div>

    <button class="btn" type="submit">ส่งลิงก์รีเซ็ตรหัสผ่าน</button>
  </form>

  <div class="muted" style="margin-top:12px;">
    <a href="{{ route('login') }}">กลับไปหน้าเข้าสู่ระบบ</a>
  </div>
</div>
</body>
</html>
