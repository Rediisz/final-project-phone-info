<!doctype html>
<html lang="th">
<head>
  {{-- layout aside ใช้ร่วมหลายหน้า --}}
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title','Back Office')</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  {{-- NEW: สำหรับ AJAX/Fetch ทุกหน้า --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

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
    .topbar{background:#fff; border-bottom:1px solid var(--line); padding:12px 18px; display:flex; align-items:center; gap:10px}
    .content{padding:18px}
    .btn{padding:8px 12px; border:0; border-radius:10px; cursor:pointer}
    .btn-danger{background:#ef4444;color:#fff;width:100%}

    /* toggle btn (ซ่อนไว้บนจอใหญ่, โชว์บนจอเล็ก) */
    .toggle{display:none; gap:8px; padding:8px 10px; background:#eef3f9; border-radius:8px}

    /* responsive: sidebar เป็น drawer บนจอเล็ก */
    @media (max-width:760px){
      .sidebar{transform:translateX(-260px); transition:transform .2s ease}
      .sidebar.open{transform:translateX(0)}
      .main{margin-left:0}
      .toggle{display:inline-flex}
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
         href="{{ route('admin.dashboard') }}">🏠 หน้าหลัก</a>

      <a class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"
         href="{{ route('admin.banners.index') }}">📢 แบนเนอร์</a>

      <a class="{{ request()->routeIs('admin.phones.*') ? 'active' : '' }}"
         href="{{ route('admin.phones.index') }}">📱 ข้อมูลมือถือ</a>

      <a class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}"
         href="{{ route('admin.news.index') }}">📰 ข้อมูลข่าว</a>

      <a class="{{ request()->routeIs('admin.members.*') ? 'active' : '' }}"
         href="{{ route('admin.members.index') }}">👥 ข้อมูลสมาชิก</a>

      <form action="{{ route('admin.logout') }}" method="POST" style="margin-top:8px">
        @csrf
        <button type="submit" class="btn btn-danger">ออกจากระบบ</button>
      </form>
    </nav>
  </aside>

  <div id="overlay" class="overlay" onclick="closeSidebar()"></div>

  <main class="main">
    <div class="topbar">
      {{-- เอา inline display:none ออก ให้ media query คุมแทน --}}
      <button class="toggle" onclick="toggleSidebar()">☰ เมนู</button>
      @yield('topbar')
    </div>
    <div class="content">
      @yield('content')
    </div>
  </main>

  {{-- ===== Scripts กลาง ===== --}}
  <script>
    // drawer sidebar
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

    // สำหรับปุ่มจุดสีสลับสถานะ (เช่น แบนเนอร์)
    (function(){
      const csrf = document.querySelector('meta[name="csrf-token"]').content;

      window.bindStatusDots = function(selector = '.status-dot'){
        document.querySelectorAll(selector).forEach(function(el){
          if(el.dataset.bound === '1') return;  // กัน bind ซ้ำ
          el.dataset.bound = '1';

          el.addEventListener('click', async function(){
            const url = el.dataset.url;                     // route PATCH
            const isActive = el.dataset.active === '1';
            const actionText = isActive ? 'ปิดใช้งาน' : 'เปิดใช้งาน';
            if(!confirm(`ต้องการ${actionText}รายการนี้ใช่ไหม?`)) return;

            try {
              const res = await fetch(url, {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
              });
              if(!res.ok) throw new Error('Request failed');

              const data = await res.json();
              // อัปเดต UI ทันที
              el.dataset.active = data.is_active ? '1' : '0';
              el.style.background = data.is_active ? '#16a34a' : '#ef4444';
              el.title = data.is_active ? 'คลิกเพื่อปิดใช้งาน' : 'คลิกเพื่อเปิดใช้งาน';
            } catch (e) {
              alert('อัปเดตสถานะไม่สำเร็จ ลองใหม่อีกครั้ง');
            }
          });
        });
      };

      // bind ครั้งแรกเมื่อโหลดหน้า
      document.addEventListener('DOMContentLoaded', () => bindStatusDots());
    })();
  </script>

  {{-- สคริปต์เฉพาะหน้าจะมาถูกแปะตรงนี้ --}}
  @stack('scripts')
</body>
</html>
