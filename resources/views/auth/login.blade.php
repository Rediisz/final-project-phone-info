<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เข้าสู่ระบบ | SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
  :root {
    --primary: #0f2342;
    --primary-light: #1a2f4f;
    --accent: #3b82f6;
    --accent-light: #dbeafe;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --dark: #1f2937;
    --gray: #6b7280;
    --light-gray: #f3f4f6;
    --white: #ffffff;
    --shadow: 0 10px 25px rgba(15, 35, 66, 0.1);
    --shadow-sm: 0 4px 12px rgba(15, 35, 66, 0.08);
    --radius: 16px;
    --radius-lg: 20px;
    --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --transition: all 0.3s ease;
  }

  * {
    box-sizing: border-box;
  }

  body {
    background: linear-gradient(to bottom, #f8fafc, #f1f5f9);
    font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    margin: 0;
    color: var(--dark);
    line-height: 1.6;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }

  /* ===== Navbar ===== */
  header {
    background: var(--primary);
    color: var(--white);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 24px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 100;
  }

  .brand a {
    font-size: 1.6rem;
    font-weight: 700;
    background: var(--gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-decoration: none;
  }

  .backhome {
    background: var(--white);
    color: var(--primary);
    border: 0;
    border-radius: 10px;
    padding: 10px 16px;
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .backhome:hover {
    background: var(--light-gray);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  /* ===== Main Content ===== */
  .main-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
  }

  .card {
    max-width: 440px;
    width: 100%;
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    border: 1px solid rgba(59, 130, 246, 0.1);
    padding: 32px;
    animation: fadeInUp 0.5s ease-out;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: (0);
    }
  }

  .card h2 {
    margin: 0 0 24px;
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--primary);
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .card h2 i {
    color: var(--accent);
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--dark);
  }

  .form-control {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    font-size: 16px;
    font-family: inherit;
    transition: var(--transition);
    background: var(--light-gray);
  }

  .form-control:focus {
    outline: none;
    border-color: var(--alert);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background: var(--white);
  }

  .btn {
    background: var(--primary);
    color: var(--white);
    border: 0;
    border-radius: var(--radius);
    padding: 12px 18px;
    cursor: pointer;
    width: 100%;
    font-weight: 600;
    font-size: 15px;
    transition: var(--card);
  }

  .btn:hover {
    background: var(--primary-light);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(15, 35, 66, 0.15);
  }

  .btn:active {
    transform: translateY(0);
  }

  .alert {
    background: #ecfdf5;
    border: 1px solid #34d399;
    color: #065f46;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 16px;
    font-size: 14px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .alert i {
    color: #065f46;
  }

  .muted {
    color: var(--gray);
    font-size: 14px;
    margin-top: 20px;
    text-align: center;
  }

  .muted a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
  }

  .muted a:hover {
    text-decoration: underline;
  }

  .err {
    color: var(--danger);
    font-size: 13px;
    margin-top: 6px;
    font-weight: 500;
  }

  /* ===== Responsive Design ===== */
  @media (max-width: 520px) {
    .main-wrapper {
      padding: 20px 16px;
    }

    .card {
      margin: 30px 16px;
      padding: 24px;
    }

    .card h2 {
      font-size: 1.5rem;
    }
  }
  </style>
</head>
<body>
  @include('layouts.navbar')

  <div class="main-wrapper">
    <div class="card">
      <h2>
        <i class="fas fa-sign-in-alt"></i>
        เข้าสู่ระบบ
      </h2>

      @if(session('ok'))
        <div class="alert">
          <i class="fas fa-check-circle"></i>
          {{ session('ok') }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
          <label for="login">อีเมลหรือชื่อผู้ใช้</label>
          <input type="text" id="login" name="login" value="{{ old('login') }}" autofocus class="form-control">
          @error('login')
            <div class="err">
              <i class="fas fa-exclamation-circle"></i>
              {{ $message }}
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="password">รหัสผ่าน</label>
          <input type="password" id="password" name="password" class="form-control">
          @error('password')
            <div class="err">
              <i class="fas fa-exclamation-circle"></i>
              {{ $message }}
            </div>
          @enderror
        </div>
        <button type="submit" class="btn">
          <i class="fas fa-sign-in-alt"></i>
          เข้าสู่ระบบ
        </button>
        <div class="muted">
          ยังไม่มีบัญชี?
          <a href="{{ route('signup') }}">
            <i class="fas fa-user-plus"></i>
            สมัครสมาชิก
          </a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>