<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>SmartSpec</title>
  <link rel="stylesheet" href="{{ asset('style/style.css') }}">
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
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

  {{-- 🔄 Banner ข่าวล่าสุด --}}
  <div class="banner-carousel">
    @foreach($news as $n)
      @php $banner = $n->Banner_Img; @endphp
      <div class="banner-slide">
        <img src="{{ Str::startsWith($banner, ['http://','https://']) ? $banner : asset($banner) }}" alt="News Banner">
      </div>
    @endforeach
  </div>

  {{-- 🔍 ค้นหา --}}
  <div class="search-box">
    <form method="GET" action="{{ url('/search') }}">
      <input type="text" name="q" placeholder="ค้นหามือถือ...">
      <button type="submit">ค้นหา</button>
    </form>
  </div>

  {{-- 🧭 แบรนด์ --}}
  <div class="brands-filter">
    @foreach($brands as $b)
      <a href="{{ url('/brand?id='.$b->ID) }}">{{ $b->Brand }}</a>
    @endforeach
  </div>

  {{-- 📱 มือถือ --}}
  <div class="mobile-grid">
    @foreach($mobiles as $m)
      @php
        $imgPath = $m->firstImage?->Img ?? 'images/default.jpg'; // เตรียม public/images/default.jpg
        $imgUrl  = Str::startsWith($imgPath, ['http://','https://']) ? $imgPath : asset($imgPath);
      @endphp
      <div class="mobile-card">
        <img src="{{ $imgUrl }}" alt="{{ $m->Model }}">
        <h3>{{ $m->Model }}</h3>
      </div>
    @endforeach
  </div>
</body>
</html>
