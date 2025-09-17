<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <style>
  /* ===== Theme คล้าย Back Office ===== */
  body {
    background: #f3f6fb;
    font-family: sans-serif;
    margin: 0;
    padding: 0;
    color: #0f2342;
  }

  /* Header */
  header {
    background: #0f2342;
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 24px;
  }
  header h1 { margin: 0; font-size: 1.6rem; }
  header nav a {
    color: #fff;
    margin-left: 14px;
    text-decoration: none;
  }
  header nav a:hover { text-decoration: underline; }

  /* Banner เต็มจอ */
  .banner-container {
    width: 100%;
    background: #3a3d40; /* สีเข้มกรณีไม่มี banner */
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
    margin-bottom: 20px;
    
  }
  .banner-container img {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
  }

  /* Layout 2 คอลัมน์ (ย้ายแบรนด์ลงมาใต้ banner) */
  .layout {
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 16px;
    padding: 16px;
  }

  /* Sidebar (แบรนด์) */
  .sidebar h3 { margin-top: 0; }
  .brand-list { list-style: none; padding: 0; margin: 0; }
  .brand-list li { margin: 4px 0; }
  .brand-list a { color: #0f2342; text-decoration: none; }
  .brand-list a:hover { text-decoration: underline; }

  /* Search Box */
  .search-box {
    background: #fff;
    padding: 12px;
    max-width: 100%;
    margin-bottom: 16px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(15, 35, 66, 0.08);
  }

  /* Mobile Grid */
  .mobile-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 16px;
    padding: 20px 0;
  }
  .mobile-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(15, 35, 66, 0.08);
    text-align: center;
    padding: 10px;
    transition: transform 0.15s;
    min-height: 200px;
  }
  .mobile-card:hover { transform: translateY(-2px); }
  .mobile-card img {
    max-width: 100%;
    height: 160px;
    object-fit: contain;
    margin-bottom: 8px;
  }
  .mobile-card h3 { font-size: 14px; margin: 0; }
  .mobile-card.placeholder { background: #e6e9ef; }
  </style>
</head>
<body>
  <header>
    <h1>SmartSpec</h1>
    <nav>
      <a href="#">หน้าแรก</a>
      <a href="#">ข่าว</a>
      <a href="#">เปรียบเทียบ</a>
      <a href="{{ url('/login') }}">Login</a>
      <a href="{{ url('/signup') }}">Sign Up</a>
    </nav>
  </header>

  {{-- ========== Banner เต็มจอ ========= --}}
  @if(count($news))
    <div class="banner-container">
      @foreach($news as $n)
        @php $banner = $n->Banner_Img; @endphp
        <img src="{{ Str::startsWith($banner, ['http://','https://']) ? $banner : asset($banner) }}" alt="News Banner">
      @endforeach
    </div>
  @else
    <div class="banner-container"></div>
  @endif

  <div class="layout">
    {{-- ========== Sidebar แบรนด์ ========= --}}
    <aside class="sidebar">
      <h3>แบรนด์</h3>
      <ul class="brand-list">
        @foreach($brands as $b)
          <li><a href="{{ url('/brand?id='.$b->ID) }}">{{ $b->Brand }}</a></li>
        @endforeach
      </ul>
    </aside>

    <main class="content">
      {{-- ========== Search ========= --}}
      <div class="search-box">
        <form method="GET" action="{{ url('/search') }}">
          <input type="text" name="q" placeholder="ค้นหามือถือ...">
          <button type="submit">ค้นหา</button>
        </form>
      </div>

      {{-- ========== Mobile Grid ========= --}}
      <div class="mobile-grid">
        @forelse($mobiles as $m)
          @php
            $imgPath = $m->firstImage?->Img ?? 'images/default.jpg';
            $imgUrl  = Str::startsWith($imgPath, ['http://','https://']) ? $imgPath : asset($imgPath);
          @endphp
          <div class="mobile-card">
            <img src="{{ $imgUrl }}" alt="{{ $m->Model }}">
            <h3>{{ $m->Model }}</h3>
          </div>
        @empty
          @for($i=0; $i<16; $i++)
            <div class="mobile-card placeholder"></div>
          @endfor
        @endforelse
      </div>
    </main>
  </div>
</body>
</html>
