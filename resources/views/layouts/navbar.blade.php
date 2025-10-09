<!-- resources/views/layouts/navbar.blade.php -->
<style>
  html{ overflow-y: scroll; }  /* บังคับให้มีสกรอลบาร์เสมอ → ความกว้าง viewport คงที่ทุกหน้า */
</style>
<header style="background:#0f2342;color:#fff;
               display:flex;justify-content:space-between;align-items:center;
               padding:12px 24px;
               width:100%;box-sizing:border-box;">
  <h1 style="margin:0;font-size:1.9rem;">SmartSpec</h1>

  <nav style="display:flex;align-items:center;gap:12px;">
    <a href="{{ route('home') }}" style="color:#fff;text-decoration:none;">หน้าแรก</a>
    <a href="{{ route('news') }}" style="color:#fff;text-decoration:none;">ข่าว</a>
    <a href="{{ route('compare') }}" style="color:#fff;text-decoration:none;">เปรียบเทียบ</a>

    @auth
      <div style="display:flex;align-items:center;gap:8px;margin-left:12px">
        <img src="{{ Auth::user()->avatar_url }}"
             alt="Profile"
             style="width:28px;height:28px;border-radius:50%;object-fit:cover;">
        <span style="font-weight:600">{{ Auth::user()->User_Name }}</span>

        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
          @csrf
          <button type="submit"
                  style="background:none;border:1px solid #d1d5db;border-radius:8px;padding:6px 10px;color:#fff;cursor:pointer;">
            ออกจากระบบ
          </button>
        </form>
      </div>
    @else
      <a href="{{ route('login') }}" style="color:#fff;text-decoration:none;">เข้าสู่ระบบ</a>
      <a href="{{ route('signup') }}" style="color:#fff;text-decoration:none;">สมัครสมาชิก</a>
    @endauth
  </nav>
</header>
