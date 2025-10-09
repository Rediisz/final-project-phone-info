<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8"><title>ตั้งรหัสผ่านใหม่ | SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <style>
    body{background:#f3f6fb;font-family:sans-serif;margin:0;color:#0f2342}
    header{background:#0f2342;color:#fff;display:flex;justify-content:space-between;align-items:center;padding:12px 24px}
    .card{max-width:420px;margin:40px auto;background:#fff;border-radius:14px;box-shadow:0 10px 24px rgba(15,35,66,.12);padding:18px}
    .row{display:flex;flex-direction:column;margin-bottom:12px}
    label{font-size:13px;margin-bottom:6px}
    input{padding:10px 12px;border:1px solid #d1d5db;border-radius:10px}
    .btn{background:#0f2342;color:#fff;border:0;border-radius:10px;padding:10px 14px;cursor:pointer;width:100%}
    .err{color:#b91c1c;font-size:13px;margin-top:4px}
  </style>
</head>
<body>
<header></header>

<div class="card">
  <h2 style="margin:0 0 12px">ตั้งรหัสผ่านใหม่</h2>

  <form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="row">
      <label>อีเมล</label>
      <input type="email" name="email" value="{{ old('email', $email ?? '') }}" required>
      @error('email')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="row">
      <label>รหัสผ่านใหม่</label>
      <input type="password" name="password" required>
      @error('password')<div class="err">{{ $message }}</div>@enderror
    </div>

    <div class="row">
      <label>ยืนยันรหัสผ่านใหม่</label>
      <input type="password" name="password_confirmation" required>
    </div>

    <button class="btn" type="submit">บันทึกรหัสผ่านใหม่</button>
  </form>
</div>
</body>
</html>
