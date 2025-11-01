<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ข่าว | SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <script src="{{ asset('js/brand-ajax.js') }}" defer></script>
  
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

  /* ===== Base / Navbar ===== */
  body{
    background:linear-gradient(to bottom, #f8fafc, #f1f5f9);
    font-family:system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;
    margin:0;color:var(--primary);line-height:1.6;
  }
  header{
    background:var(--primary);
    color:var(--white);
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 24px;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    position:sticky;
    top:0;
    z-index:100;
  }
  header h1{
    margin:0;
    font-size:1.6rem;
    font-weight:700;
    background:var(--gradient);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
  }
  header nav a{
    color:var(--white);
    margin-left:14px;
    text-decoration:none;
    transition:var(--transition);
    position:relative;
  }
  header nav a:hover{
    color:var(--accent-light);
  }
  header nav a::after {
    content:"";
    position:absolute;
    width:0;
    height:2px;
    bottom:-5px;
    left:0;
    background:var(--accent);
    transition:width 0.3s ease;
  }
  header nav a:hover::after {
    width:100%;
  }

  /* ===== Banner (robust center-mode) ===== */
  .banner-wrap{
    background:linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    position:relative;
    padding:30px 64px 40px;
    overflow:hidden;
  }
  .banner-wrap::before {
    content:"";
    position:absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background:url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="none"/><circle cx="50" cy="50" r="40" stroke="rgba(255,255,255,0.05)" stroke-width="1" fill="none"/></svg>');
    background-size:100px 100px;
    opacity:0.5;
  }
  .banner-empty{
    background:var(--primary);
    min-height:260px;
    position:relative;
  }
  .banner-empty::before {
    content:"";
    position:absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background:var(--gradient);
    opacity:0.3;
  }
  .carousel{
    max-width:min(1280px,100%);
    margin:0 auto;
    overflow:hidden;
    position:relative;
    z-index:2;
  }
  .carousel::before,.carousel::after{
    content:"";
    position:absolute;
    top:0;
    bottom:0;
    width:80px;
    z-index:2;
    pointer-events:none;
  }
  .carousel::before{
    left:0;
    background:linear-gradient(90deg,var(--primary),rgba(15,35,66,0))
  }
  .carousel::after {
    right:0;
    background:linear-gradient(-90deg,var(--primary),rgba(15,35,66,0))
  }
  .track{
    display:flex;
    align-items:center;
    gap:48px;
    will-change:transform;
    transition:transform .5s ease;
    padding:10px 4px;
  }
  .slide{
    flex:0 0 auto;
    width:clamp(260px, 26vw, 420px);
    aspect-ratio:16/9;
    border-radius:var(--radius-lg);
    background:rgba(255,255,255,0.1);
    overflow:hidden;
    box-shadow:0 14px 32px rgba(0,0,0,.35);
    transform:scale(.88);
    opacity:.7;
    transition:transform .35s ease, opacity .35s ease;
    cursor:pointer;
    border:2px solid rgba(255,255,255,0.1);
  }
  .slide.is-active{
    transform:scale(1);
    opacity:1;
    border-color:var(--accent);
  }
  .slide img{
    width:100%;
    height:100%;
    object-fit:cover;
    background:rgba(255,255,255,0.05);
  }
  .nav{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    width:44px;
    height:44px;
    border-radius:50%;
    border:0;
    background:var(--white);
    color:var(--primary);
    font-size:22px;
    font-weight:700;
    display:grid;
    place-items:center;
    cursor:pointer;
    z-index:3;
    box-shadow:0 6px 16px rgba(0,0,0,.3);
    transition:var(--transition);
  }
  .nav:hover{
    background:var(--accent);
    color:var(--white);
    transform:translateY(-50%) scale(1.1);
  }
  .nav.prev{left:16px} 
  .nav.next{right:16px}
  .dots{
    display:flex;
    gap:10px;
    justify-content:center;
    margin-top:20px;
    position:relative;
    z-index:2;
  }
  .dot{
    width:8px;
    height:8px;
    border-radius:50%;
    border:0;
    cursor:pointer;
    background:rgba(255,255,255,0.4);
    opacity:.75;
    transition:var(--transition);
  }
  .dot.is-active{
    width:24px;
    border-radius:4px;
    background:var(--white);
    opacity:1;
  }

  /* ===== Layout ===== */
  .layout{
    display:grid;
    grid-template-columns:280px 1fr;
    gap:24px;
    padding:24px;
    max-width:100%;
    box-sizing:border-box;
  }

  .search-box{
    background:var(--white);
    padding:20px;
    border-radius:var(--radius-lg);
    box-shadow:var(--shadow);
    margin-bottom:24px;
    border:1px solid rgba(59, 130, 246, 0.1);
    position:relative;
    overflow:hidden;
  }
  .search-box::before {
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:4px;
    height:100%;
    background:var(--accent);
  }
  .search-box form{
    display:flex;
    gap:12px;
    align-items:center;
  }
  .search-box input{
    flex:1;
    padding:14px 18px;
    border:1px solid #e5e7eb;
    border-radius:12px;
    font-size:16px;
    font-family:inherit;
    transition:var(--transition);
    background:var(--light-gray);
  }
  .search-box input:focus{
    outline:none;
    border-color:var(--accent);
    box-shadow:0 0 0 3px rgba(59, 130, 246, 0.1);
    background:var(--white);
  }
  .search-box button{
    padding:14px 20px;
    border:0;
    border-radius:12px;
    background:var(--accent);
    color:var(--white);
    font-weight:600;
    cursor:pointer;
    transition:var(--transition);
    font-size:16px;
    display:flex;
    align-items:center;
    gap:8px;
  }
  .search-box button:hover{
    background:var(--primary);
    transform:translateY(-2px);
    box-shadow:0 6px 16px rgba(15, 35, 66, 0.15);
  }
  .search-box button:active{
    transform:translateY(0);
  }
  .search-box button i {
    font-size:14px;
  }
  .btn-filter{
    padding:14px 20px;
    border:1px solid var(--accent);
    border-radius:12px;
    background:var(--white);
    color:var(--accent);
    font-weight:600;
    cursor:pointer;
    transition:var(--transition);
    font-size:16px;
    display:flex;
    align-items:center;
    gap:8px;
  }
  .btn-filter:hover{
    background:var(--accent);
    color:var(--white);
    transform:translateY(-2px);
    box-shadow:0 6px 16px rgba(59, 130, 246, 0.2);
  }
  .btn-filter i {
    font-size:14px;
  }

  /* ===== Modal Filters ===== */
  .modal{
    position:fixed;
    inset:0;
    display:none;
    z-index:50;
  }
  .modal[aria-hidden="false"]{
    display:block;
  }
  .modal__backdrop{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,.5);
    backdrop-filter:blur(4px);
  }
  .modal__panel{
    position:relative;
    max-width:min(980px,96vw);
    margin:5vh auto;
    background:var(--white);
    border-radius:var(--radius-lg);
    box-shadow:0 24px 60px rgba(0,0,0,.25);
    display:flex;
    flex-direction:column;
    overflow:hidden;
    max-height:90vh;
  }
  .modal__head,.modal__foot{
    padding:20px 24px;
    border-bottom:1px solid #eef1f5;
    display:flex;
    align-items:center;
  }
  .modal__foot{
    border-bottom:0;
    border-top:1px solid #eef1f5;
    gap:12px;
  }
  .modal__body{
    padding:24px;
    max-height:60vh;
    overflow:auto;
  }
  .modal__head h3{
    margin:0;
    font-size:20px;
    color:var(--primary);
    display:flex;
    align-items:center;
    gap:8px;
  }
  .modal__head h3 i {
    color:var(--accent);
  }
  .modal__close{
    border:0;
    background:var(--light-gray);
    border-radius:50%;
    width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    margin-left:auto;
    cursor:pointer;
    transition:var(--transition);
  }
  .modal__close:hover {
    background:var(--danger);
    color:var(--white);
  }
  .spacer{
    flex:1;
  }
  .link-reset{
    background:none;
    border:none;
    color:var(--accent);
    text-decoration:none;
    cursor:pointer;
    font-weight:500;
  }
  .link-reset:hover{
    text-decoration:underline;
  }
  .btn-apply{
    padding:12px 24px;
    border:0;
    border-radius:12px;
    background:var(--accent);
    color:var(--white);
    font-weight:700;
    cursor:pointer;
    transition:var(--transition);
  }
  .btn-apply:hover {
    background:var(--primary);
  }

  .filters-grid{
    display:grid;
    grid-template-columns:repeat(3,minmax(200px,1fr));
    gap:16px;
    margin-bottom:20px;
  }
  .filters-grid label{
    display:flex;
    flex-direction:column;
    font-size:14px;
    font-weight:500;
    gap:8px;
    color:var(--dark);
  }
  .filters-grid input,.filters-grid select{
    padding:12px 14px;
    border:1px solid #e5e7eb;
    border-radius:10px;
    font-size:14px;
    transition:var(--transition);
  }
  .filters-grid input:focus,.filters-grid select:focus {
    outline:none;
    border-color:var(--accent);
    box-shadow:0 0 0 3px rgba(59, 130, 246, 0.1);
  }

  /* ===== Dual range (year) ===== */
  .range-row{
    display:grid;
    gap:10px;
  }
  .range-label{
    font-size:14px;
    color:var(--dark);
    display:flex;
    align-items:center;
    gap:10px;
    font-weight:500;
  }
  .range-label i {
    color:var(--accent);
  }
  .range-val{
    font-size:12px;
    background:var(--accent);
    color:var(--white);
    border-radius:20px;
    padding:4px 10px;
  }
  .dual{
    position:relative;
    height:40px;
    display:flex;
    align-items:center;
  }
  .dual input[type="range"]{
    position:absolute;
    left:0;
    right:0;
    margin:0;
    height:0;
    appearance:none;
    background:transparent;
    pointer-events:auto;
  }
  .dual input[type="range"]::-webkit-slider-thumb{
    appearance:none;
    width:20px;
    height:20px;
    border-radius:50%;
    background:var(--accent);
    border:2px solid var(--white);
    box-shadow:0 2px 8px rgba(0,0,0,.25);
    cursor:pointer;
    position:relative;
    z-index:2;
  }
  .dual input[type="range"]::-moz-range-thumb{
    width:20px;
    height:20px;
    border:none;
    border-radius:50%;
    background:var(--accent);
    box-shadow:0 2px 8px rgba(0,0,0,.25);
    cursor:pointer;
    position:relative;
    z-index:2;
  }
  .dual__track{
    position:absolute;
    left:4px;
    right:4px;
    height:8px;
    background:#e5e7eb;
    border-radius:10px;
  }
  .dual__track .fill{
    position:absolute;
    top:0;
    bottom:0;
    left:0;
    right:0;
    background:var(--accent);
    border-radius:10px;
  }

  /* ===== News list & empty state ===== */
  .news-list{
    display:flex;
    flex-direction:column;
    gap:24px;
  }
  .news-item{
    display:grid;
    grid-template-columns:240px 1fr;
    gap:20px;
    background:var(--white);
    border-radius:var(--radius-lg);
    box-shadow:var(--shadow-sm);
    padding:20px;
    transition:var(--transition);
    border:1px solid rgba(59, 130, 246, 0.05);
    position:relative;
    overflow:hidden;
  }
  .news-item::before {
    content:"";
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:4px;
    background:var(--gradient);
    transform:translateX(-100%);
    transition:transform 0.3s ease;
  }
  .news-item:hover::before {
    transform:translateX(0);
  }
  .news-item:hover{
    transform:translateY(-5px);
    box-shadow:var(--shadow);
    border-color:rgba(59, 130, 246, 0.2);
  }
  .news-thumb{
    width:240px;
    height:160px;
    border-radius:12px;
    overflow:hidden;
    position:relative;
  }
  .news-thumb::after {
    content:"";
    position:absolute;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background:linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.1));
  }
  .news-thumb img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
    transition:var(--transition);
  }
  .news-item:hover .news-thumb img{
    transform:scale(1.05);
  }
  .news-title{
    margin:0 0 12px;
    font-size:20px;
    line-height:1.35;
    font-weight:700;
  }
  .news-title a{
    color:var(--primary);
    text-decoration:none;
    transition:var(--transition);
  }
  .news-title a:hover{
    color:var(--accent);
  }
  .news-intro{
    color:var(--gray);
    margin:0 0 16px;
    line-height:1.6;
  }
  .news-meta{
    font-size:14px;
    color:var(--gray);
    display:flex;
    gap:12px;
    align-items:center;
    flex-wrap:wrap;
  }
  .news-meta span {
    display:flex;
    align-items:center;
    gap:4px;
  }
  .news-meta i {
    color:var(--accent);
    font-size:12px;
  }
  .news-card-link{
    display:block;
    text-decoration:none;
    color:inherit;
  }

  .empty-state{
    background:var(--white);
    border-radius:var(--radius-lg);
    box-shadow:var(--shadow-sm);
    padding:40px;
    text-align:center;
    color:var(--gray);
  }
  .empty-state i {
    font-size:48px;
    margin-bottom:16px;
    color:var(--gray);
  }
  .empty-state h3{
    margin:0 0 16px;
    font-size:24px;
    color:var(--primary);
  }
  .btn-ghost{
    display:inline-block;
    margin-top:16px;
    padding:12px 20px;
    border:1px solid var(--accent);
    border-radius:12px;
    background:var(--white);
    color:var(--accent);
    font-weight:600;
    text-decoration:none;
    transition:var(--transition);
  }
  .btn-ghost:hover{
    background:var(--accent);
    color:var(--white);
  }

  /* ===== Brand panel ===== */
  .brand-panel{
    background:var(--white);
    border:1px solid rgba(59, 130, 246, 0.1);
    border-radius:var(--radius-lg);
    padding:20px;
    box-shadow:var(--shadow-sm);
    position:sticky;
    top:100px;
  }
  .brand-panel__head{
    font-weight:700;
    margin:0 0 16px;
    color:var(--primary);
    font-size:1.1rem;
    display:flex;
    align-items:center;
    gap:8px;
  }
  .brand-panel__head i {
    color:var(--accent);
  }

  .brand-grid{
    list-style:none;
    margin:0;
    padding:0;
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:12px;
  }
  @media (max-width: 760px){
    .brand-grid{ 
      grid-template-columns:repeat(3,1fr); 
    }
  }
  .brand-grid__item{
    margin:0;
    padding:0;
  }

  .brand-logo{
    display:flex;
    align-items:center;
    justify-content:center;
    height:70px;
    border-radius:12px;
    background:var(--light-gray);
    border:1px solid #e5e7eb;
    text-decoration:none;
    overflow:hidden;
    padding:10px;
    box-shadow:0 2px 4px rgba(15,35,66,.04) inset;
    transition:var(--transition);
  }
  .brand-logo:hover{
    transform:translateY(-3px);
    box-shadow:0 6px 12px rgba(15,35,66,.1);
  }
  .brand-logo.is-active{
    background:var(--accent-light);
    border-color:var(--accent);
    box-shadow:0 0 0 3px rgba(59, 130, 246, 0.2);
  }

  .brand-logo img{
    display:block;
    width:100%;
    height:100%;
    object-fit:contain;
  }

  .no-logo{
    width:40px;
    height:40px;
    border-radius:50%;
    display:grid;
    place-items:center;
    background:var(--accent);
    color:var(--white);
    font-weight:700;
  }
  .sr-only{
    position:absolute;
    width:1px;
    height:1px;
    padding:0;
    margin:-1px;
    overflow:hidden;
    clip:rect(0,0,0,0);
    white-space:nowrap;
    border:0;
  }

  /* ===== Pagination ===== */
  .pagination {
    margin:32px 0;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:12px;
  }
  .pagination a {
    padding:12px 20px;
    border:1px solid #e5e7eb;
    border-radius:12px;
    background:var(--white);
    color:var(--primary);
    text-decoration:none;
    font-weight:500;
    transition:var(--transition);
    display:flex;
    align-items:center;
    gap:6px;
  }
  .pagination a:hover:not(.disabled) {
    background:var(--accent);
    color:var(--white);
    border-color:var(--accent);
    transform:translateY(-2px);
    box-shadow:0 4px 12px rgba(59, 130, 246, 0.2);
  }
  .pagination a.disabled {
    pointer-events:none;
    opacity:.4;
  }
  .pagination span {
    font-size:16px;
    color:var(--gray);
    font-weight:500;
    padding:0 8px;
  }

  /* Stack sidebar/content on small screens */
  @media (max-width: 900px){ 
    .layout{
      grid-template-columns:1fr;
      gap:20px;
    } 
    .brand-panel {
      position:static;
    }
  }
  
  /* Tighter banner padding on phones */
  @media (max-width: 600px){ 
    .banner-wrap{
      padding:20px 16px 30px;
    }
  }
  
  @media (max-width:720px){ 
    .filters-grid{
      grid-template-columns:1fr;
    } 
  }
  
  @media (max-width:680px){ 
    .news-item{
      grid-template-columns:1fr;
      gap:16px;
    }
    .news-thumb{
      height:200px;
      width:100%;
    }
  }
  
  @media (max-width: 768px){
    .layout{
      padding:16px;
    }
    .search-box{
      padding:16px;
    }
    .search-box form{
      flex-wrap:wrap;
      gap:12px;
    }
    .search-box input{
      min-width:0;
      flex:1 1 100%;
    }
    .search-box button,.btn-filter{
      flex:1 1 auto;
      min-width:120px;
    }
  }
  </style>
</head>

<body style="margin:0;background:linear-gradient(to bottom, #f8fafc, #f1f5f9);font-family:system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;">
  @include('layouts.navbar')
  @php $banners = ($banners ?? $banner ?? collect()); @endphp

  @if($banners->count())
    <div class="banner-wrap">
      <button class="nav prev" type="button" aria-label="prev">
        <i class="fas fa-chevron-left"></i>
      </button>
      <div class="carousel">
        <div class="track">
          @foreach($banners as $b)
            <a class="slide" href="#" aria-label="banner">
              <img src="{{ $b->image_url }}" alt="Banner">
            </a>
          @endforeach
        </div>
      </div>
      <button class="nav next" type="button" aria-label="next">
        <i class="fas fa-chevron-right"></i>
      </button>
      <div class="dots" role="tablist" aria-label="banner dots">
        @foreach($banners as $i => $b)
          <button class="dot {{ $i===0?'is-active':'' }}" data-i="{{ $i }}" role="tab" aria-selected="{{ $i===0?'true':'false' }}"></button>
        @endforeach
      </div>
    </div>
  @else
    <div class="banner-empty"></div>
  @endif

  <div class="layout">
    <aside class="sidebar">
      <div class="brand-panel">
        <div class="brand-panel__head">
          <i class="fas fa-mobile-alt"></i>
          แบรนด์
        </div>

        <ul class="brand-grid">
          @foreach($brands as $b)
            @php
              $active = (string)request('brand') === (string)$b->ID;
              $qAll = request()->except('page'); // คงพารามิเตอร์อื่น ๆ

              // คลิกซ้ำเพื่อล้าง brand
              $href = $active
                ? route('news', array_filter(array_merge($qAll, ['brand' => null])))
                : route('news', array_merge($qAll, ['brand' => $b->ID]));
            @endphp

            <li class="brand-grid__item">
              <a href="{{ $href }}"
                 class="brand-logo {{ $active ? 'is-active' : '' }}"
                 data-brand-id="{{ $b->ID }}"
                 title="{{ $b->Brand }}"
                 aria-pressed="{{ $active ? 'true' : 'false' }}">
                @if($b->Logo_Path)
                  <img src="{{ asset('storage/'.$b->Logo_Path) }}" alt="{{ $b->Brand }}" loading="lazy">
                @else
                  <span class="no-logo">{{ mb_substr($b->Brand,0,1) }}</span>
                @endif
                <span class="sr-only">{{ $b->Brand }}</span>
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    </aside>

    <main class="content">
      <div class="search-box">
        <form method="GET" action="{{ route('news') }}">
          <input type="text" name="q" placeholder="ค้นหาข่าว..." value="{{ request('q') }}">
          <button type="submit">
            <i class="fas fa-search"></i>
            ค้นหา
          </button>

          <!-- ปุ่มเปิดตัวกรอง -->
          <button type="button" id="openFilters" class="btn-filter">
            <i class="fas fa-filter"></i>
            ตัวกรอง
          </button>

          <!-- Modal Filters -->
          <div class="modal" id="filtersModal" aria-hidden="true">
            <div class="modal__backdrop" data-close></div>
            <div class="modal__panel" role="dialog" aria-modal="true" aria-labelledby="filtersTitle">
              <div class="modal__head">
                <h3 id="filtersTitle">
                  <i class="fas fa-filter"></i>
                  ตัวกรองข่าว
                </h3>
                <button type="button" class="modal__close" title="ปิด" data-close>
                  <i class="fas fa-times"></i>
                </button>
              </div>

              <div class="modal__body">
                <div class="filters-grid">
                  <!-- แบรนด์ -->
                  <label>
                    <i class="fas fa-tag"></i>
                    แบรนด์
                    <select name="brand" id="brandSelect">
                      <option value="" {{ request()->filled('brand') ? '' : 'selected' }}>— ทั้งหมด —</option>
                      @foreach($brands as $b)
                        <option value="{{ $b->ID }}" {{ (string)request('brand')===(string)$b->ID?'selected':'' }}>
                          {{ $b->Brand }}
                        </option>
                      @endforeach
                    </select>
                  </label>

                  <!-- รุ่น -->
                  <label>
                    <i class="fas fa-mobile-alt"></i>
                    รุ่น
                    <select name="model" id="modelSelect">
                      <option value="" {{ request()->filled('model') ? '' : 'selected' }}>— ทั้งหมด —</option>
                      @foreach($models as $m)
                        <option value="{{ $m->ID }}"
                                data-brand="{{ $m->Brand_ID }}"
                                {{ (string)request('model')===(string)$m->ID?'selected':'' }}>
                          {{ $m->Model }}
                        </option>
                      @endforeach
                    </select>
                  </label>

                  <!-- ระบบปฏิบัติการ -->
                  <label>
                    <i class="fas fa-desktop"></i>
                    ระบบปฏิบัติการ
                    <select name="os" id="osSelect">
                      <option value="" {{ request()->filled('os') ? '' : 'selected' }}>— ทั้งหมด —</option>
                      @foreach($osList as $os)
                        @if($os)
                          <option value="{{ $os }}" {{ request('os')===$os?'selected':'' }}>{{ $os }}</option>
                        @endif
                      @endforeach
                    </select>
                  </label>
                </div>

                <!-- ปีที่ลงข่าว -->
                <div class="range-row" style="margin-top:20px">
                  <div class="range-label">
                    <i class="fas fa-calendar"></i>
                    ปีที่ลงข่าว 
                    <span class="range-val" data-out="nyear"></span>
                  </div>
                  <div class="dual">
                    <input type="range" min="2012" max="2030" step="1"
                           value="{{ request('news_year_from', 2012) }}" data-min="nyear">
                    <input type="range" min="2012" max="2030" step="1"
                           value="{{ request('news_year_to', 2030) }}" data-max="nyear">
                    <div class="dual__track" data-track="nyear"><div class="fill"></div></div>
                  </div>
                  <input type="hidden" name="news_year_from" value="{{ request('news_year_from') }}">
                  <input type="hidden" name="news_year_to"   value="{{ request('news_year_to') }}">
                </div>
              </div>

              <div class="modal__foot">
                <button type="button" class="link-reset" id="clearFilters" data-clear-url="{{ route('news') }}">
                  <i class="fas fa-redo"></i>
                  ล้างตัวกรอง
                </button>
                <div class="spacer"></div>
                <button type="submit" class="btn-apply" id="applyFilters">
                  <i class="fas fa-check"></i>
                  ใช้ตัวกรอง
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>

      @php
        $hasFilters = collect([
          'q','brand','model','os','news_year_from','news_year_to'
        ])->some(fn($k)=>request()->filled($k));
      @endphp

      <div id="results">
        <div class="news-list">
          @forelse($items as $n)
            @php
              $imgPath = $n->cover?->Img ?? $n->images->first()?->Img ?? null;
              $imgUrl  = $imgPath ? asset('storage/'.$imgPath) : asset('images/default.jpg');
              $intro   = \Illuminate\Support\Str::limit(strip_tags($n->Intro ?: $n->Details), 140);
            @endphp

            <a href="{{ route('news.show', $n->ID) }}" class="news-card-link">
              <article class="news-item hover-lift">
                <div class="news-thumb">
                  <img src="{{ $imgUrl }}" alt="{{ $n->Title }}">
                </div>
                <div>
                  <h2 class="news-title">{{ $n->Title }}</h2>
                  <p class="news-intro">{{ $intro }}</p>
                  <div class="news-meta">
                    <span><i class="fas fa-calendar"></i> {{ optional($n->Date)->format('d M Y H:i') }}</span>
                    @if($n->brand)  <span><i class="fas fa-tag"></i> {{ $n->brand->Brand }}</span> @endif
                    @if($n->mobile) <span><i class="fas fa-mobile-alt"></i> {{ $n->mobile->Model }}</span> @endif
                  </div>
                </div>
              </article>
            </a>
          @empty
            <div class="empty-state">
              <i class="fas fa-newspaper"></i>
              <h3>ไม่พบข่าว</h3>
              @if($hasFilters)
                <p>ลองปรับตัวกรอง หรือเริ่มใหม่ด้วยการล้างตัวกรอง</p>
                <a href="{{ route('news') }}" class="btn-ghost">
                  <i class="fas fa-redo"></i>
                  ล้างตัวกรอง
                </a>
              @else
                <p>ยังไม่มีข่าวในระบบ</p>
              @endif
            </div>
          @endforelse
        </div>
      </div><!-- /#results -->

      @if(method_exists($items, 'hasPages') && $items->hasPages())
        @php
          $prev = $items->previousPageUrl();
          $next = $items->nextPageUrl();
        @endphp
        <div class="pagination">
          <a href="{{ $prev ?: '#' }}" class="{{ $prev ? '' : 'disabled' }}">
            <i class="fas fa-chevron-left"></i>
            {{ $prev ? 'ก่อนหน้า' : 'ก่อนหน้า' }}
          </a>
          <span>
            <i class="fas fa-file"></i>
            หน้า {{ $items->currentPage() }} / {{ $items->lastPage() }}
          </span>
          <a href="{{ $next ?: '#' }}" class="{{ $next ? '' : 'disabled' }}">
            {{ $next ? 'ถัดไป' : 'ถัดไป' }}
            <i class="fas fa-chevron-right"></i>
          </a>
        </div>
      @endif
    </main>
  </div>

  <script>
  /* ===== Carousel (robust) ===== */
  (function(){
    const wrap = document.querySelector('.banner-wrap'); if(!wrap) return;
    const carousel = wrap.querySelector('.carousel');
    const track = wrap.querySelector('.track');
    const prevBtn = wrap.querySelector('.prev');
    const nextBtn = wrap.querySelector('.next');
    const dots = Array.from(wrap.querySelectorAll('.dot'));

    const realSlides = Array.from(track.children);
    if (realSlides.length <= 1) { 
      prevBtn?.setAttribute('disabled','true'); 
      nextBtn?.setAttribute('disabled','true'); 
      return; 
    }

    const head = realSlides[0].cloneNode(true);
    const tail = realSlides[realSlides.length - 1].cloneNode(true);
    track.insertBefore(tail, realSlides[0]);
    track.appendChild(head);

    let all = Array.from(track.children);
    let idx = 1, gapPx = 48, itemW = 0, centerOffset = 0;
    let isAnimating = false, timer = null;

    const readGap = () => { 
      const s = getComputedStyle(track); 
      const g = parseFloat(s.gap || s['column-gap'] || '48'); 
      gapPx = isNaN(g) ? 48 : g; 
    };
    
    const measure = () => { 
      readGap(); 
      itemW = all[idx].offsetWidth; 
      centerOffset = (carousel.clientWidth - itemW) / 2; 
      setX(); 
    };
    
    const setX = () => { 
      track.style.transform = `translateX(${centerOffset - idx * (itemW + gapPx)}px)`; 
    };
    
    const setActive = () => {
      all.forEach(el => el.classList.remove('is-active'));
      all[idx]?.classList.add('is-active');
      let real = idx - 1; 
      if (real < 0) real = realSlides.length - 1; 
      if (real >= realSlides.length) real = 0;
      dots.forEach(d => d.classList.remove('is-active')); 
      dots[real]?.classList.add('is-active');
    };

    const go = (step) => {
      if (isAnimating) return;
      isAnimating = true;
      idx += step;
      track.style.transition = 'transform .5s ease'; setX();
      clearTimeout(go._fallback); go._fallback = setTimeout(()=> handleEdgeSnap(), 600);
    };

    function handleEdgeSnap(){
      if (idx === all.length - 1){ 
        track.style.transition='none'; 
        idx = 1; 
        setX(); 
        requestAnimationFrame(()=> track.style.transition='transform .5s ease'); 
      }
      else if (idx === 0){       
        track.style.transition='none'; 
        idx = realSlides.length; 
        setX(); 
        requestAnimationFrame(()=> track.style.transition='transform .5s ease'); 
      }
      setActive(); 
      isAnimating = false;
    }

    track.style.transition='none'; measure(); requestAnimationFrame(()=> track.style.transition='transform .5s ease'); setActive();
    nextBtn?.addEventListener('click', ()=> go(1));
    prevBtn?.addEventListener('click', ()=> go(-1));
    track.addEventListener('click', (e)=>{ 
      const slide=e.target.closest('.slide'); 
      if(!slide) return; 
      const i=all.indexOf(slide); 
      if(i>-1) go(i-idx); 
    });
    
    dots.forEach((d,i)=> d.addEventListener('click', ()=> { 
      const target=i+1; 
      if(target!==idx) go(target-idx); 
    }));
    
    track.addEventListener('transitionend', handleEdgeSnap);

    function startAuto(){ 
      timer=setInterval(()=> go(1), 3500); 
    }
    
    function stopAuto(){ 
      clearInterval(timer); 
      timer=null; 
    }
    
    startAuto(); wrap.addEventListener('mouseenter', stopAuto); wrap.addEventListener('mouseleave', ()=> { 
      if(!timer) startAuto(); 
    });
    
    document.addEventListener('visibilitychange', ()=>{ 
      if(document.hidden) stopAuto(); 
      else { 
        measure(); 
        startAuto(); 
      } 
    });
    
    window.addEventListener('resize', ()=> requestAnimationFrame(measure));
    Array.from(track.querySelectorAll('img')).forEach(img=>{ 
      if(img.complete) return; 
      img.addEventListener('load', ()=> requestAnimationFrame(measure), {once:true}); 
    });
  })();

  /* ===== Filters (News): modal + year slider + brand→model sync ===== */
  (function(){
    const modal   = document.getElementById('filtersModal');
    const openBtn = document.getElementById('openFilters');
    if(!modal || !openBtn) return;

    const closeEls= modal.querySelectorAll('[data-close]');
    const applyBtn= document.getElementById('applyFilters');
    const clearBtn= document.getElementById('clearFilters');

    const brandSel= document.getElementById('brandSelect');
    const modelSel= document.getElementById('modelSelect');

    const open  = ()=> modal.setAttribute('aria-hidden','false');
    const close = ()=> modal.setAttribute('aria-hidden','true');

    openBtn.addEventListener('click', ()=>{ open(); syncModels(); });
    closeEls.forEach(el=>el.addEventListener('click', close));
    document.addEventListener('keydown', e => { if(e.key==='Escape') close(); });

    applyBtn?.addEventListener('click', ()=> close());
    clearBtn?.addEventListener('click', ()=>{
      close();
      const url = clearBtn.dataset.clearUrl || '{{ route('news') }}';
      setTimeout(()=>window.location.assign(url), 120);
    });

    // year slider label
    function setupDual(key, fmt, hiddenMinName=null, hiddenMaxName=null){
      const min   = modal.querySelector(`input[data-min="${key}"]`);
      const max   = modal.querySelector(`input[data-max="${key}"]`);
      const track = modal.querySelector(`.dual__track[data-track="${key}"]`);
      const out   = modal.querySelector(`[data-out="${key}"]`);
      const hMin  = modal.querySelector(`input[name="${hiddenMinName || (key+'_min')}"]`);
      const hMax  = modal.querySelector(`input[name="${hiddenMaxName || (key+'_max')}"]`);
      if(!min||!max||!track||!out) return;

      const fill = track.querySelector('.fill') || track.appendChild(Object.assign(document.createElement('div'),{className:'fill'}));
      const lo = parseFloat(min.min), hi = parseFloat(min.max);
      const pct = v => ((v-lo)/(hi-lo))*100;

      function render(){
        let a = parseFloat(min.value), b = parseFloat(max.value);
        if(a>b){ [a,b]=[b,a]; min.value=a; max.value=b; }
        fill.style.left  = pct(a)+'%';
        fill.style.right = (100-pct(b))+'%';
        out.textContent  = fmt(a)+' – '+fmt(b);
        if(hMin) hMin.value = a;
        if(hMax) hMax.value = b;
      }
      min.addEventListener('input', render);
      max.addEventListener('input', render);
      render();
    }
    setupDual('nyear', v=>v, 'news_year_from', 'news_year_to');

    // sync รุ่นตามแบรนด์ + กัน dropdown ค้าง
    const allModelOptions = Array.from(modelSel.options);
    const presetModel = "{{ (string)request('model') }}";

    function syncModels(){
      const bid = brandSel.value || '';
      const first = allModelOptions[0];
      const current = modelSel.value;

      modelSel.innerHTML = '';
      modelSel.appendChild(first);
      allModelOptions.slice(1).forEach(opt=>{
        if(!bid || opt.dataset.brand === bid) modelSel.appendChild(opt);
      });

      if(!presetModel){
        modelSel.value = '';
      }else{
        modelSel.value = presetModel;
        if(modelSel.value !== presetModel) modelSel.value = '';
      }

      if(!Array.from(modelSel.options).some(o=>o.value===current)){
        modelSel.value = '';
      }
    }

    brandSel.addEventListener('change', syncModels);
    syncModels();
  })();
  </script>
</body>
</html>