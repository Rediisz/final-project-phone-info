<!doctype html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">  {{-- สำคัญต่อความ responsive --}}
  <title>BACK OFFICE</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <style>
    :root{
      --primary:#0f2342;       /* กรมท่า */
      --primary-50:#162d54;
      --muted:#e5e7eb;
      --text:#2f3542;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial;
      color:var(--text);
      background:#f8f5f5;
      display:flex; align-items:center; justify-content:center;
      padding:16px;               /* กันชนรอบขอบจอมือถือ */
    }
    .wrap{width:100%; max-width:520px}
    .brand-wrap{display:flex; flex-direction:column; align-items:center; gap:6px; margin-bottom:0.01px}
    .logo-box{
        width:250px; height:auto;        /* ปรับตรงนี้ให้ใหญ่/เล็ก */
        background:
            center/80% no-repeat;           /* 80% = ขนาดโลโก้ในกล่อง */
        border-radius:8px;                /* เอาเป็นวงกลมก็ได้: 50% */
        margin:0 auto 8px;                /* จัดให้อยู่กลาง */
    }
    .brand{margin:0; font-weight:700; color:var(--primary); font-size:clamp(18px, 2.6vw, 22px)}
    .sub{margin-top:-4px; font-size:12px; color:#6b7280}

    .card{
      background:#fff; border:1px solid #eef1f5; border-radius:14px;
      padding:clamp(18px, 4vw, 28px);
      box-shadow:0 8px 24px rgba(15,35,66,.06);
    }

    .divider{
      display:grid; grid-template-columns:1fr auto 1fr; align-items:center;
      column-gap:12px; color:#6b7280; font-weight:600; letter-spacing:.5px;
      margin-bottom:14px;
    }
    .divider::before,.divider::after{content:""; height:1px; background:var(--muted)}

    form{display:grid; gap:12px}
    label{font-size:13px; color:#4b5563}
    .field{display:grid; gap:6px}
    input[type="text"], input[type="password"]{
      width:100%;
      padding:12px 14px;
      border:1px solid #e5e7eb; border-radius:10px; background:#fff;
      font-size:16px;            /* 16px เพื่อกัน iOS zoom */
      transition:border-color .15s, box-shadow .15s;
    }
    input:focus{border-color:#cdd6e3; box-shadow:0 0 0 4px rgba(15,35,66,.06); outline:none}

    .btn{
      width:100%; padding:12px 16px; margin-top:4px;
      background:var(--primary); color:#fff; border:0; border-radius:10px;
      font-weight:700; letter-spacing:.2px; cursor:pointer; transition:background .15s;
      touch-action:manipulation;
    }
    .btn:hover{background:var(--primary-50)}
    .google-btn:hover {
      background: #f3f4f6; 
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08); 
    }

    .error{
      margin-bottom:10px; background:#fff5f5; color:#b00020;
      border:1px solid #ffd0d0; padding:10px 12px; border-radius:10px; font-size:13px;
    }

    .footer{margin-top:12px; text-align:center; font-size:12px; color:#9aa0a6}

    /* ----------------- Breakpoints ----------------- */
    /* จอแคบมาก ≤ 360px: ลดระยะห่าง/ขนาดโลโก้ */
    @media (max-width: 360px){
      .logo{width:70px}
      .card{padding:16px}
    }

    /* จอใหญ่ขึ้น ≥ 768px: ขยายโลโก้/ฟอนต์/เงาให้โปร่ง */
    @media (min-width: 768px){
      .logo{width:92px}
      .card{padding:28px}
      .btn{padding:13px 18px}
    }

    /* โหมดมืด (ถ้าเครื่องผู้ใช้ตั้งค่าไว้) */
    /* @media (prefers-color-scheme: dark){
      body{background:#0b1220; color:#e5e7eb}
      .card{background:#0f172a; border-color:#141c2f}
      input{background:#0b1220; border-color:#243047; color:#e5e7eb}
      input:focus{box-shadow:0 0 0 4px rgba(66,153,225,.18)}
      .divider::before,.divider::after{background:#243047}
      .sub{color:#9aa0a6}
    } */
  </style>
</head>
<body>
    
  <div class="wrap" role="main">
    <div class="brand-wrap">

      <img class="logo-box" src="{{ asset('images/icon.png') }}" alt="SmartSpec Logo">
    
    </div>
    <div id="bo-title" class="divider">BACK OFFICE</div><br>
    <div class="card" aria-labelledby="bo-title">
      
      @if ($errors->any())
        <div class="error" role="alert">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="field">
          <label for="user">Username</label>
          <input id="user" type="text" name="User_Name" value="{{ old('User_Name') }}" required autocomplete="username" autofocus>
        </div>

        <div class="field">
          <label for="pass">Password</label>
          <input id="pass" type="password" name="Password" required autocomplete="current-password">
        </div>

        <button class="btn" type="submit">เข้าสู่ระบบ</button>
        <a href="{{ route('admin.login.google') }}" class="google-btn"
          style="display:flex;align-items:center;justify-content:center;padding:10px;border:1px solid #e5e7eb;border-radius:8px;background:#fff;font-weight:600  ;text-decoration: none; color: #0F2342">
          <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="" style="width:18px;height:18px;margin-right:8px">
          Sign in with Google
        </a>
      </form>
    </div>

    <div class="footer">SmartSpec
