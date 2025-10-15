<!-- resources/views/layouts/navbar.blade.php -->
<style>
  html{ overflow-y: scroll; }

  .site-header{
    background:#0f2342; color:#fff;
    display:flex; justify-content:space-between; align-items:center;
    padding:12px 24px; width:100%; box-sizing:border-box;
    position:relative; z-index:40;
  }
  .site-title{ margin:0; font-size:1.9rem; }
  .site-nav{ display:flex; align-items:center; gap:12px; }
  .site-nav a{ color:#fff; text-decoration:none; }
  .site-nav a:hover{ text-decoration:underline; }

  .menu-toggle{
    display:none; margin-left:auto; appearance:none; cursor:pointer;
    background:#fff; color:#0f2342; border:0; border-radius:10px;
    padding:8px 10px; font-weight:700;
  }

  .profile-box{ display:flex; align-items:center; gap:8px; margin-left:12px; }
  .profile-box img{ width:28px; height:28px; border-radius:50%; object-fit:cover; }
  .btn-logout{
    background:none; border:1px solid #d1d5db; border-radius:8px;
    padding:6px 10px; color:#fff; cursor:pointer;
  }

  /* Mobile layout */
  @media (max-width: 768px){
    .site-header{ padding:10px 16px; }
    .menu-toggle{ display:inline-flex; align-items:center; gap:6px; }

    .site-nav{
      position:absolute; left:12px; right:12px; top:60px;
      background:#0f2342; border:1px solid rgba(255,255,255,.12);
      border-radius:10px; padding:10px; box-sizing:border-box;
      display:none; flex-direction:column; align-items:flex-start; gap:10px;
    }
    .site-nav[aria-expanded="true"]{ display:flex; }

    .profile-box{ margin-left:0; width:100%; justify-content:space-between; }
    .site-nav a{ padding:6px 2px; width:100%; }
  }
</style>
<header class="site-header">
  <h1 class="site-title">SmartSpec</h1>

  <button class="menu-toggle" type="button" aria-controls="siteNav" aria-expanded="false">
    เมนู
    <span aria-hidden="true">☰</span>
  </button>

  <nav id="siteNav" class="site-nav" aria-expanded="false">
    <a href="{{ route('home') }}">หน้าแรก</a>
    <a href="{{ route('news') }}">ข่าว</a>
    <a href="{{ route('compare') }}">เปรียบเทียบ</a>

    @auth
      <div class="profile-box">
        <img src="{{ Auth::user()->avatar_url }}" alt="Profile">
        <span style="font-weight:600">{{ Auth::user()->User_Name }}</span>

        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
          @csrf
          <button type="submit" class="btn-logout">ออกจากระบบ</button>
        </form>
      </div>
    @else
      <a href="{{ route('login') }}">เข้าสู่ระบบ</a>
      <a href="{{ route('signup') }}">สมัครสมาชิก</a>
    @endauth
  </nav>
</header>

<script>
  (function(){
    const btn = document.currentScript.previousElementSibling.querySelector('.menu-toggle');
    const nav = document.currentScript.previousElementSibling.querySelector('#siteNav');
    if(!btn || !nav) return;
    btn.addEventListener('click', function(){
      const isOpen = nav.getAttribute('aria-expanded') === 'true';
      const next = !isOpen;
      nav.setAttribute('aria-expanded', String(next));
      btn.setAttribute('aria-expanded', String(next));
    });
  })();
  // Keeps viewport width stable when vertical scrollbar appears on some pages
  document.documentElement.style.overflowY = 'scroll';
</script>
