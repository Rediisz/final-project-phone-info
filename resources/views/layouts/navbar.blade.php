<!-- resources/views/layouts/navbar.blade.php -->
<style>
  html{ overflow-y: scroll; }

  .site-header{
    background:var(--primary, #0f2342); 
    color:#fff;
    display:flex; 
    justify-content:space-between; 
    align-items:center;
    padding:12px 24px; 
    width:100%; 
    box-sizing:border-box;
    position:relative; 
    z-index:40;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
  }
  .site-title{ 
    margin:0; 
    font-size:1.9rem; 
    background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
  }
  .site-nav{ 
    display:flex; 
    align-items:center; 
    gap:12px; 
  }
  .site-nav a{ 
    color:#fff; 
    text-decoration:none; 
    transition:all 0.3s ease;
    position:relative;
    padding:4px 0;
  }
  .site-nav a:hover{ 
    color:#dbeafe;
  }
  .site-nav a::after {
    content:"";
    position:absolute;
    width:0;
    height:2px;
    bottom:-2px;
    left:0;
    background:var(--accent, #3b82f6);
    transition:width 0.3s ease;
  }
  .site-nav a:hover::after {
    width:100%;
  }

  .menu-toggle{
    display:none; 
    margin-left:auto; 
    appearance:none; 
    cursor:pointer;
    background:var(--accent, #3b82f6); 
    color:#fff; 
    border:0; 
    border-radius:10px;
    padding:8px 12px; 
    font-weight:600;
    transition:all 0.3s ease;
    align-items:center;
    gap:6px;
  }
  .menu-toggle:hover {
    background:var(--primary-light, #1a2f4f);
    transform:translateY(-2px);
  }

  .profile-box{ 
    display:flex; 
    align-items:center; 
    gap:8px; 
    margin-left:12px; 
  }
  .profile-box img{ 
    width:28px; 
    height:28px; 
    border-radius:50%; 
    object-fit:cover; 
    border:2px solid rgba(255,255,255,0.2);
  }
  .btn-logout{
    background:none; 
    border:1px solid rgba(255,255,255,0.3); 
    border-radius:8px;
    padding:6px 10px; 
    color:#fff; 
    cursor:pointer;
    transition:all 0.3s ease;
  }
  .btn-logout:hover {
    background:rgba(255,255,255,0.1);
    border-color:rgba(255,255,255,0.5);
  }

  /* Mobile layout - ปรับ max-width เป็น 600px */
  @media (max-width: 600px){
    .site-header{ 
      padding:10px 16px; 
    }
    .menu-toggle{ 
      display:inline-flex; 
      align-items:center; 
      gap:6px; 
    }

    .site-nav{
      position:absolute; 
      left:12px; 
      right:12px; 
      top:60px;
      background:var(--primary, #0f2342); 
      border:1px solid rgba(255,255,255,.12);
      border-radius:10px; 
      padding:10px; 
      box-sizing:border-box;
      display:none; 
      flex-direction:column; 
      align-items:flex-start; 
      gap:10px;
      box-shadow:0 8px 16px rgba(0,0,0,0.2);
    }
    .site-nav[aria-expanded="true"]{ 
      display:flex; 
    }

    .profile-box{ 
      margin-left:0; 
      width:100%; 
      justify-content:space-between; 
      padding-top:10px;
      border-top:1px solid rgba(255,255,255,0.1);
    }
    .site-nav a{ 
      padding:8px 0; 
      width:100%; 
      font-size:16px;
    }
  }
</style>
<header class="site-header">
  <h1 class="site-title">SmartSpec</h1>

  <button class="menu-toggle" type="button" aria-controls="siteNav" aria-expanded="false">
    <i class="fas fa-bars"></i>
    เมนู
  </button>

  <nav id="siteNav" class="site-nav" aria-expanded="false">
    <a href="{{ route('home') }}">
      <i class="fas fa-home"></i>
      หน้าแรก
    </a>
    <a href="{{ route('news') }}">
      <i class="fas fa-newspaper"></i>
      ข่าว
    </a>
    <a href="{{ route('compare') }}">
      <i class="fas fa-exchange-alt"></i>
      เปรียบเทียบ
    </a>

    @auth
      <div class="profile-box">
        <img src="{{ Auth::user()->avatar_url }}" alt="Profile">
        <span style="font-weight:600">{{ Auth::user()->User_Name }}</span>

        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
          @csrf
          <button type="submit" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i>
            ออกจากระบบ
          </button>
        </form>
      </div>
    @else
      <a href="{{ route('login') }}">
        <i class="fas fa-sign-in-alt"></i>
        เข้าสู่ระบบ
      </a>
      <a href="{{ route('signup') }}">
        <i class="fas fa-user-plus"></i>
        สมัครสมาชิก
      </a>
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