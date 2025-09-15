<!doctype html>
<html lang="th">
<head>
   {{--  ให้ layout ที่เป็น aside สามารถใช้ได้หลายหน้าเหมือนกันดึงไปเอา --}}
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title','Back Office')</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <style>
    :root{
      --nav:#1f3347; --nav-active:#0b1b2c;
      --bg:#f5f7fb; --card:#fff; --line:#e8eef5;
      --text:#1f2937; --muted:#6b7280; --primary:#0f2342;
    }
    *{box-sizing:border-box} html,body{height:100%}
    body{margin:0; display:flex; background:var(--bg); color:var(--text); font-family:system-ui,-apple-system,'Segoe UI',Roboto,Arial}

    /* sidebar fixed left */
    .sidebar{
      position:fixed; left:0; top:0; height:100vh; width:250px; z-index:1000;
      background:var(--nav); color:#e5edf6; padding:18px 14px; display:flex; flex-direction:column; gap:12px;
    }
    .brand{display:flex; align-items:center; gap:10px; font-weight:700}
    .brand img{width:36px;height:36px;border-radius:50%;background:#fff;object-fit:contain}
    .userbox{background:rgba(255,255,255,.06); border-radius:10px; padding:10px 12px; font-size:13px}
    .menu{display:flex; flex-direction:column; gap:6px}
    .menu a{display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:#d1d5db; text-decoration:none}
    .menu a:hover{background:var(--nav-active)}
    .menu a.active{background:#0b1b2c; color:#fff; font-weight:600}
    .menu i{width:18px}

    /* main */
    .main{flex:1; min-width:0; margin-left:250px; display:flex; flex-direction:column}
    .topbar{background:#fff; border-bottom:1px solid var(--line); padding:12px 18px}
    .content{padding:18px}
    .btn{padding:8px 12px; border:0; border-radius:10px; cursor:pointer}
    .btn-danger{background:#ef4444;color:#fff;width:100%}

    /* responsive: sidebar เป็น drawer บนจอเล็ก */
    @media (max-width:760px){
      .sidebar{transform:translateX(-260px); transition:transform .2s ease}
      .sidebar.open{transform:translateX(0)}
      .main{margin-left:0}
      .toggle{display:inline-flex; gap:8px; padding:8px 10px; background:#eef3f9; border-radius:8px}
      .overlay{position:fixed; inset:0; background:rgba(0,0,0,.35); display:none; z-index:900}
      .overlay.show{display:block}
    }
  </style>
  @stack('head')
</head>
<body>
  <aside class="sidebar" id="sb">
    <div class="brand">
      <img src="{{ asset('images/logo.png') }}" alt="logo"> BACK OFFICE
    </div>

    <div class="userbox">
      สวัสดี, <strong>{{ auth()->user()->User_Name }}</strong><br>
      <span style="color:#9aa0a6">Administrator</span>
    </div>

    <nav class="menu">
      <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
         href="{{ route('admin.dashboard') }}"><i>🏠</i> หน้าหลัก</a>

      <a class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"
         href="{{ route('admin.banners.index') }}"><i>📢</i> แบนเนอร์</a>

      <a class="{{ request()->routeIs('admin.phones.*') ? 'active' : '' }}"
         href="{{ route('admin.phones.index') }}"><i>📱</i> ข้อมูลมือถือ</a>

      <a class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}"
         href="{{ route('admin.news.index') }}"><i>📰</i> ข้อมูลข่าว</a>

      <a class="{{ request()->routeIs('admin.members.*') ? 'active' : '' }}"
         href="{{ route('admin.members.index') }}"><i>👥</i> ข้อมูลสมาชิก</a>

      <form action="{{ route('admin.logout') }}" method="POST" style="margin-top:8px">
        @csrf
        <button type="submit" class="btn btn-danger">ออกจากระบบ</button>
      </form>
    </nav>
  </aside>

  <div id="overlay" class="overlay" onclick="closeSidebar()"></div>

  <main class="main">
    <div class="topbar">
      <button class="toggle" onclick="toggleSidebar()" style="display:none">☰ เมนู</button>
      @yield('topbar')
    </div>
    <div class="content">
      @yield('content')
    </div>
  </main>

  <script>
    function toggleSidebar(){
      const sb = document.getElementById('sb');
      const ov = document.getElementById('overlay');
      const isOpen = sb.classList.toggle('open');
      if (window.matchMedia('(max-width:760px)').matches) {
        ov.classList.toggle('show', isOpen);
      } else { ov.classList.remove('show'); }
    }
    function closeSidebar(){
      document.getElementById('sb').classList.remove('open');
      document.getElementById('overlay').classList.remove('show');
    }
    document.querySelectorAll('.menu a').forEach(a=>a.addEventListener('click', closeSidebar));
  </script>
  @stack('scripts')
</body>
</html>
