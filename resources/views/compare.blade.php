<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>เปรียบเทียบมือถือ | SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  
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

  /* ===== Navbar ให้้เหมือนหน้า Home ทุกประการ ===== */
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
  header nav a::after{
    content:"";
    position:absolute;
    width:0;
    height:2px;
    bottom:-5px;
    left:0;
    background:var(--accent);
    transition:width 0.3s ease;
  }
  header nav a:hover::after{ 
    width:100%;
  }

  body{
    background:linear-gradient(to bottom, #f8fafc, #f1f5f9);
    font-family:system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;
    margin:0;
    color:var(--primary);
    line-height:1.6;
  }

  /* ===== Banner / Compare styles ===== */
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

  .wrap{
    padding:24px;
    max-width:1200px;
    margin:0 auto;
  }
  
  .page-title {
    font-size:2.2rem;
    font-weight:800;
    margin:0 0 24px;
    color:var(--primary);
    background:var(--gradient);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
    display:flex;
    align-items:center;
    gap:12px;
  }
  .page-title i {
    color:var(--accent);
  }

  .grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
  }
  .slot{
    position:relative;
    background:var(--white);
    border-radius:var(--radius-lg);
    box-shadow:var(--shadow-sm);
    padding:20px;
    min-height:420px;
    transition:var(--transition);
    border:1px solid rgba(59, 130, 246, 0.05);
    overflow:hidden;
  }
  .slot::before {
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
  .slot:hover::before {
    transform:translateX(0);
  }
  .slot:hover{
    transform:translateY(-5px);
    box-shadow:var(--shadow);
    border-color:rgba(59, 130, 246, 0.2);
  }
  .slot .head{
    font-weight:700;
    margin-bottom:12px;
    font-size:1.1rem;
    color:var(--primary);
    display:flex;
    align-items:center;
    gap:8px;
  }
  .slot .head i {
    color:var(--accent);
  }
  .slot img{
    max-width:160px;
    display:block;
    margin:12px auto;
    border-radius:12px;
    box-shadow:0 4px 8px rgba(0,0,0,.1);
    transition:var(--transition);
  }
  .slot img:hover{
    transform:scale(1.05);
  }
  .spec{
    font-size:13px;
    color:var(--dark);
    margin:4px 0;
    text-align:center;
  }
  .placeholder{
    height:260px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:var(--gray);
    border:1px dashed #e5e7eb;
    border-radius:10px;
    background:var(--light-gray);
  }

  .searchbox{
    position:relative;
    margin-bottom:16px;
  }
  .searchbox input{
    width:100%;
    padding:12px 16px;
    border:1px solid #e5e7eb;
    border-radius:12px;
    font-size:14px;
    box-sizing:border-box;
    transition:var(--transition);
    background:var(--light-gray);
  }
  .searchbox input:focus{
    outline:none;
    border-color:var(--accent);
    box-shadow:0 0 0 3px rgba(59, 130, 246, 0.1);
    background:var(--white);
  }
  .dropdown{
    position:absolute;
    left:0;
    right:0;
    top:100%;
    background:var(--white);
    border:1px solid #e5e7eb;
    border-radius:12px;
    box-shadow:var(--shadow);
    z-index:20;
    max-height:360px;
    overflow:auto;
    display:none;
  }
  .dropdown.open{
    display:block;
  }
  .group-hd{
    font-size:12px;
    color:var(--gray);
    padding:12px 16px;
    border-bottom:1px solid var(--light-gray);
    background:var(--light-gray);
  }
  .item{
    display:flex;
    gap:12px;
    align-items:center;
    padding:12px 16px;
    cursor:pointer;
    transition:var(--transition);
  }
  .item:hover{
    background:var(--light-gray);
  }
  .item img{
    width:46px;
    height:46px;
    object-fit:cover;
    border-radius:8px;
    background:var(--light-gray);
  }
  .item .n{
    font-size:14px;
    color:var(--primary);
    font-weight:500;
  }
  .item .b{
    font-size:12px;
    color:var(--gray);
  }

  .specs-list{
    margin:16px auto 0;
    padding-left:18px;
    max-width:520px;
    text-align:left;
    line-height:1.6;
  }
  .specs-list li{
    margin:4px 0;
    font-size:13px;
    color:var(--dark);
  }
  .specs-list .muted{
    color:var(--gray);
  }

  /* Mobile Comparison View */
  @media (max-width:960px){
    .compare-container{
      position:relative;
      overflow:hidden;
      margin-top:24px;
      background:var(--white);
      border-radius:var(--radius-lg);
      box-shadow:var(--shadow);
    }
    .compare-tabs{
      display:flex;
      background:var(--white);
      border-radius:var(--radius-lg) var(--radius-lg) 0 0;
      box-shadow:var(--shadow-sm);
      overflow-x:auto;
      scrollbar-width:none;
      -ms-overflow-style:none;
    }
    .compare-tabs::-webkit-scrollbar{
      display:none;
    }
    .compare-tab{
      flex:1;
      min-width:120px;
      padding:16px 12px;
      text-align:center;
      font-weight:600;
      color:var(--gray);
      border-bottom:3px solid transparent;
      cursor:pointer;
      transition:var(--transition);
      white-space:nowrap;
      overflow:hidden;
      text-overflow:ellipsis;
      position:relative;
    }
    .compare-tab.active{
      color:var(--primary);
      border-bottom-color:var(--accent);
    }
    .compare-tab.active::after {
      content:"";
      position:absolute;
      bottom:0;
      left:0;
      width:100%;
      height:3px;
      background:var(--accent);
    }
    .compare-slider{
      display:flex;
      transition:transform .3s ease;
      will-change:transform;
    }
    .compare-slide{
      width:100%;
      flex-shrink:0;
      padding:0 16px;
    }
    .compare-slide .slot{
      min-height:auto;
      margin:0;
    }
    .compare-slide .placeholder{
      min-height:300px;
    }
    .compare-nav{
      position:absolute;
      top:50%;
      transform:translateY(-50%);
      width:40px;
      height:40px;
      border-radius:50%;
      background:var(--white);
      border:1px solid var(--light-gray);
      color:var(--primary);
      font-size:18px;
      font-weight:bold;
      display:flex;
      align-items:center;
      justify-content:center;
      cursor:pointer;
      z-index:10;
      box-shadow:var(--shadow-sm);
      transition:var(--transition);
    }
    .compare-nav:hover{
      background:var(--accent);
      color:var(--white);
      transform:translateY(-50%) scale(1.1);
    }
    .compare-nav.prev{
      left:12px;
    }
    .compare-nav.next{
      right:12px;
    }
    .compare-nav.disabled{
      opacity:.5;
      cursor:not-allowed;
    }
    .compare-nav.disabled:hover{
      background:var(--white);
      color:var(--primary);
      transform:translateY(-50%);
    }
    .compare-indicator{
      display:flex;
      justify-content:center;
      gap:8px;
      margin-top:16px;
    }
    .compare-dot{
      width:8px;
      height:8px;
      border-radius:50%;
      background:var(--light-gray);
      transition:var(--transition);
    }
    .compare-dot.active{
      width:24px;
      border-radius:4px;
      background:var(--accent);
    }
    .grid{
      display:none;
    }
  }

  @media (max-width:600px){
    .wrap{
      padding:16px;
    }
    .page-title {
      font-size:1.8rem;
    }
    .compare-tab{
      min-width:100px;
      padding:12px 8px;
      font-size:14px;
    }
  }
  </style>
</head>
<body>
  @include('layouts.navbar')

{{-- Banner --}}
@php $banners = ($banners ?? collect()); @endphp
@if($banners->count())
  <div class="banner-wrap">
    <button class="nav prev" type="button" aria-label="prev">
      <i class="fas fa-chevron-left"></i>
    </button>
    <div class="carousel">
      <div class="track">
        @foreach($banners as $b)
          <a class="slide" href="#">
            <img src="{{ $b->image_url }}" alt="Banner">
          </a>
        @endforeach
      </div>
    </div>
    <button class="nav next" type="button" aria-label="next">
      <i class="fas fa-chevron-right"></i>
    </button>
    <div class="dots">
      @foreach($banners as $i=>$b)
        <button class="dot {{ $i===0?'is-active':'' }}"></button>
      @endforeach
    </div>
  </div>
@else
  <div class="banner-empty"></div>
@endif

<div class="wrap">
  <h2 class="page-title">
    <i class="fas fa-mobile-alt"></i>
    เปรียบเทียบมือถือ
  </h2>

  <!-- Desktop Grid View -->
  <div class="grid" id="cmpGrid" data-url="{{ route('compare') }}">
    @foreach([1,2,3] as $slot)
      <div class="slot hover-lift" data-slot="{{ $slot }}">
        <div class="head">
          <i class="fas fa-plus-circle"></i>
          COMPARE WITH
        </div>

        {{-- Search box + dropdown --}}
        <div class="searchbox">
          <input type="text" placeholder="ค้นหามือถือ..." class="q">
          <div class="dropdown">
            <div class="group-hd">LAST VISITED</div>
            <div class="list"></div>
          </div>
        </div>

        {{-- Selected mobile --}}
        @if(!empty($mobiles[$slot]))
          @php
            $m   = $mobiles[$slot];
            $img = $m->coverImage?->Img ?? ($m->images->first()?->Img ?? null);
            $url = $img ? asset('storage/'.$img) : asset('images/default.jpg');

            // network/รองรับ
            $net = $m->Network ?? $m->Networks ?? $m->network ?? null;

            // วันเปิดตัว (ถ้ามี)
            $launch = null;
            try {
              if(!empty($m->LaunchDate)){
                $launch = \Illuminate\Support\Carbon::parse($m->LaunchDate)->format('d M Y');
              }
            } catch (\Throwable $e) {}
          @endphp

          <img src="{{ $url }}" alt="{{ $m->Model }}">
          <div class="spec" style="font-weight:700">{{ $m->brand?->Brand }} - {{ $m->Model }}</div>

          {{-- สเปกเต็ม --}}
          <ul class="specs-list">
            <li><i class="fas fa-microchip"></i> ชิป/โปรเซสเซอร์: {{ $m->Processor ?: '—' }}</li>
            <li><i class="fas fa-memory"></i> RAM: {{ $m->RAM_GB ?: '—' }} <span class="muted">GB</span></li>
            <li><i class="fas fa-hdd"></i> หน่วยความจำ (แสดงถ้ามี): {{ $m->Storage_GB ?: '—' }} <span class="muted">GB</span></li>
            <li><i class="fas fa-desktop"></i> หน้าจอ: {{ $m->ScreenSize_in ?: '—' }}″ {{ $m->Display ?? '' }}</li>
            <li><i class="fas fa-camera"></i> กล้องหน้า: {{ $m->FrontCamera ?: '—' }} MP</li>
            <li><i class="fas fa-camera"></i> กล้องหลัง: {{ $m->BackCamera ?: '—' }} MP</li>
            <li><i class="fas fa-battery-full"></i> แบตเตอรี่: {{ $m->Battery_mAh ?: '—' }} <span class="muted">mAh</span></li>
            <li><i class="fas fa-wifi"></i> รองรับ: {{ $net ?: '—' }}</li>
            @if($launch)
              <li><i class="fas fa-calendar"></i> วันที่เปิดตัว: {{ $launch }}</li>
            @endif
          </ul>
          @php
            $fmt = [
              'val' => fn($v, $suffix = '') => (isset($v) && $v !== '') ? (is_numeric($v) ? rtrim(rtrim((string)$v,'0'),'.') : $v) . $suffix : '- ',
              'yn'  => fn($v) => is_null($v) ? '- ' : ($v ? 'มี' : 'ไม่มี'),
            ];
          @endphp

          <ul class="specs-list">
            <li><i class="fas fa-tag"></i> Series: {{ $fmt['val']($m->Series) }}</li>
            <li><i class="fas fa-tag"></i> Variant: {{ $fmt['val']($m->Variant) }}</li>
            <li><i class="fas fa-palette"></i> Colors: {{ $fmt['val']($m->ColorOptions) }}</li>
            <li><i class="fas fa-cube"></i> Material: {{ $fmt['val']($m->Material) }}</li>
            <li><i class="fas fa-ruler"></i> Dimensions: {{ $fmt['val']($m->Dimensions) }}</li>
            <li><i class="fas fa-weight"></i> Weight: {{ $fmt['val']($m->Weight_g,' g') }}</li>

            <li><i class="fas fa-desktop"></i> Display type: {{ $fmt['val']($m->Display_Type) }}</li>
            <li><i class="fas fa-tv"></i> Resolution: {{ $fmt['val']($m->Display_Resolution) }}</li>
            <li><i class="fas fa-sync"></i> Refresh rate: {{ $fmt['val']($m->Display_RefreshRate,' Hz') }}</li>
            <li><i class="fas fa-sun"></i> Brightness: {{ $fmt['val']($m->Display_Brightness) }}</li>
            <li><i class="fas fa-shield-alt"></i> Protection: {{ $fmt['val']($m->Display_Protection) }}</li>

            <li><i class="fas fa-memory"></i> RAM type: {{ $fmt['val']($m->RAM_Type) }}</li>
            <li><i class="fas fa-hdd"></i> Storage type: {{ $fmt['val']($m->Storage_Type) }}</li>
            <li><i class="fas fa-expand-arrows-alt"></i> Expandable: {{ $fmt['yn']($m->Expandable) }}</li>

            <li><i class="fas fa-desktop"></i> OS: {{ $fmt['val']($m->OS) }}</li>
            <li><i class="fas fa-paint-brush"></i> UI skin: {{ $fmt['val']($m->UI_Skin) }}</li>
            <li><i class="fas fa-code-branch"></i> OS version: {{ $fmt['val']($m->OS_Version) }}</li>
            <li><i class="fas fa-clock"></i> OS updates: {{ $fmt['val']($m->OS_Updates_Years,' yrs') }}</li>

            <li><i class="fas fa-wifi"></i> Wi‑Fi: {{ $fmt['val']($m->Wifi_Std) }}</li>
            <li><i class="fas fa-bluetooth"></i> Bluetooth: {{ $fmt['val']($m->Bluetooth) }}</li>
            <li><i class="fas fa-nfc"></i> NFC: {{ $fmt['yn']($m->NFC) }}</li>
            <li><i class="fas fa-map-marker-alt"></i> GPS: {{ $fmt['val']($m->GPS) }}</li>
            <li><i class="fas fa-infrared"></i> Infrared: {{ $fmt['yn']($m->Infrared) }}</li>
            <li><i class="fas fa-usb"></i> USB: {{ $fmt['val']($m->USB_Type) }}</li>
li><i class="fas fa-sim-card"></i> SIM: {{ $fmt['val']($m->Sim_Type) }}</li>
            <li><i class="fas fa-sim-card"></i> eSIM: {{ $fmt['yn']($m->eSIM) }}</li>
            <li><i class="fas fa-headphones"></i> 3.5mm jack: {{ $fmt['yn']($m->Jack35) }}</li>
            <li><i class="fas fa-volume-up"></i> Stereo speakers: {{ $fmt['yn']($m->Stereo_Speakers) }}</li>
            <li><i class="fas fa-music"></i> Dolby Atmos: {{ $fmt['yn']($m->Dolby_Atmos) }}</li>

            <li><i class="fas fa-fingerprint"></i> Fingerprint: {{ $fmt['val']($m->Fingerprint_Type) }}</li>
            <li><i class="fas fa-user-check"></i> Face unlock: {{ $fmt['yn']($m->Face_Unlock) }}</li>
            <li><i class="fas fa-camera"></i> Front cam features: {{ $fmt['val']($m->FrontCamera_Features) }}</li>
            <li><i class="fas fa-camera"></i> Rear cam features: {{ $fmt['val']($m->RearCamera_Features) }}</li>
            <li><i class="fas fa-video"></i> Video recording: {{ $fmt['val']($m->Video_Recording) }}</li>

            <li><i class="fas fa-battery-full"></i> Battery type: {{ $fmt['val']($m->Battery_Type) }}</li>
            <li><i class="fas fa-bolt"></i> Charge (wired): {{ $fmt['val']($m->Charging_Wired_Watt,' W') }}</li>
            <li><i class="fas fa-bolt"></i> Charge (wireless): {{ $fmt['val']($m->Charging_Wireless_Watt,' W') }}</li>
            <li><i class="fas fa-battery-full"></i> Reverse charge: {{ $fmt['val']($m->Charging_Reverse_Watt,' W') }}</li>
          </ul>
        @else
          <div class="placeholder">
            <i class="fas fa-mobile-alt" style="font-size:48px;margin-bottom:16px;color:var(--gray);"></i>
            <p>เลือกโทรศัพท์มือถือเพื่อเปรียบเทียบ</p>
          </div>
        @endif
      </div>
    @endforeach
  </div>

  <!-- Mobile Comparison View -->
  <div class="compare-container" id="mobileCompare" style="display: none;">
    <div class="compare-tabs" id="compareTabs">
      <!-- Tabs will be dynamically generated -->
    </div>
    
    <div class="compare-slider" id="compareSlider">
      <!-- Slides will be dynamically generated -->
    </div>
    
    <button class="compare-nav prev" id="comparePrev">
      <i class="fas fa-chevron-left"></i>
    </button>
    <button class="compare-nav next" id="compareNext">
      <i class="fas fa-chevron-right"></i>
    </button>
    
    <div class="compare-indicator" id="compareIndicator">
      <!-- Dots will be dynamically generated -->
    </div>
  </div>
</div>

<script>
/* ===== Banner (robust, กันค้าง/หาย) ===== */
(function(){
  const wrap = document.querySelector('.banner-wrap'); if(!wrap) return;
  const carousel = wrap.querySelector('.carousel');
  const track    = wrap.querySelector('.track');
  const prevBtn  = wrap.querySelector('.prev');
  const nextBtn  = wrap.querySelector('.next');
  const dots     = Array.from(wrap.querySelectorAll('.dot'));

  const realSlides = Array.from(track.children);
  if (realSlides.length <= 1) { // สไลด์เดียว: ปิดปุ่ม/ไม่ต้องวน
    prevBtn?.setAttribute('disabled','true');
    nextBtn?.setAttribute('disabled','true');
    return;
  }

  // clone หัว/ท้ายเพื่อวนต่อเนื่อง
  const head = realSlides[0].cloneNode(true);
  const tail = realSlides[realSlides.length-1].cloneNode(true);
  track.insertBefore(tail, realSlides[0]);
  track.appendChild(head);

  let all = Array.from(track.children);
  let idx = 1;                 // เริ่มหลัง tail clone (ตัวจริงสไลด์แรก)
  let gapPx = 48;              // ต้องตรงกับ CSS .track{gap}
  let itemW = 0;
  let centerOffset = 0;
  let isAnimating = false;
  let timer = null;

  const readGap = () => {
    const s = getComputedStyle(track);
    const g = parseFloat(s.gap || s['column-gap'] || '48');
    gapPx = isNaN(g) ? 48 : g;
  };
  const measure = () => {
    readGap();
    itemW = all[idx].offsetWidth;
    centerOffset = (carousel.clientWidth - itemW)/2;
    setX();
  };
  const setX = () => {
    track.style.transform = `translateX(${centerOffset - idx*(itemW + gapPx)}px)`;
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
    track.style.transition = 'transform .5s ease';
    setX();
    clearTimeout(go._fallback);
    go._fallback = setTimeout(handleEdgeSnap, 600); // กันเคส transitionend ไม่ยิง
  };

  function handleEdgeSnap(){
    if (idx === all.length - 1){           // ไป head clone
      track.style.transition = 'none';
      idx = 1;                             // วาร์ปกลับสไลด์จริงตัวแรก
      setX();
      requestAnimationFrame(()=> track.style.transition = 'transform .5s ease');
    } else if (idx === 0){                 // ไป tail clone
      track.style.transition = 'none';
      idx = realSlides.length;             // วาร์ปไปสไลด์จริงตัวสุดท้าย
      setX();
      requestAnimationFrame(()=> track.style.transition = 'transform .5s ease');
    }
    setActive();
    isAnimating = false;
  }

  // เริ่มต้น
  track.style.transition = 'none';
  measure();
  requestAnimationFrame(()=> track.style.transition = 'transform .5s ease');
  setActive();

  nextBtn?.addEventListener('click', ()=> go(1));
  prevBtn?.addEventListener('click', ()=> go(-1));
  track.addEventListener('click', e=>{
    const slide = e.target.closest('.slide'); if(!slide) return;
    const i = all.indexOf(slide);
    if (i > -1) go(i - idx);
  });
  dots.forEach((d,i)=> d.addEventListener('click', ()=> {
    const target = i + 1;
    if (target !== idx) go(target - idx);
  }));
  track.addEventListener('transitionend', handleEdgeSnap);

  // autoplay + หยุดเมื่อโฮเวอร์/แท็บซ่อน
  function startAuto(){ timer = setInterval(()=> go(1), 3500); }
  function stopAuto(){ clearInterval(timer); timer = null; }
  startAuto();
  wrap.addEventListener('mouseenter', stopAuto);
  wrap.addEventListener('mouseleave', ()=> { if(!timer) startAuto(); });
  document.addEventListener('visibilitychange', ()=> {
    if (document.hidden) stopAuto(); else { measure(); startAuto(); }
  });

  // รีวัดเมื่อ resize/รูปแบนเนอร์โหลด
  window.addEventListener('resize', ()=> requestAnimationFrame(measure));
  Array.from(track.querySelectorAll('img')).forEach(img=>{
    if (img.complete) return;
    img.addEventListener('load', ()=> requestAnimationFrame(measure), {once:true});
  });
})();

/* ===== Mobile Comparison View ===== */
(function(){
  // Check if mobile view should be enabled
  function isMobileView() {
    return window.innerWidth <= 960;
  }
  
  // Initialize mobile comparison view
  function initMobileCompare() {
    const desktopGrid = document.getElementById('cmpGrid');
    const mobileContainer = document.getElementById('mobileCompare');
    const tabsContainer = document.getElementById('compareTabs');
    const sliderContainer = document.getElementById('compareSlider');
    const indicatorContainer = document.getElementById('compareIndicator');
    const prevBtn = document.getElementById('comparePrev');
    const nextBtn = document.getElementById('compareNext');
    
    if (!desktopGrid || !mobileContainer) return;
    
    // Get all slots from desktop view
    const slots = Array.from(desktopGrid.querySelectorAll('.slot'));
    if (slots.length === 0) return;
    
    // Clear containers
    tabsContainer.innerHTML = '';
    sliderContainer.innerHTML = '';
    indicatorContainer.innerHTML = '';
    
    let currentIndex = 0;
    
    // Create tabs and slides
    slots.forEach((slot, index) => {
      // Get slot number and mobile name
      const slotNum = slot.getAttribute('data-slot');
      const mobileImg = slot.querySelector('img');
      const mobileSpec = slot.querySelector('.spec');
      const mobileName = mobileSpec ? mobileSpec.textContent : `ช่อง ${slotNum}`;
      
      // Create tab
      const tab = document.createElement('div');
      tab.className = 'compare-tab';
      if (index === 0) tab.classList.add('active');
      tab.textContent = mobileName;
      tab.addEventListener('click', () => goToSlide(index));
      tabsContainer.appendChild(tab);
      
      // Create slide
      const slide = document.createElement('div');
      slide.className = 'compare-slide';
      
      // Clone the slot content
      const slotClone = slot.cloneNode(true);
      slide.appendChild(slotClone);
      sliderContainer.appendChild(slide);
      
      // Create indicator dot
      const dot = document.createElement('div');
      dot.className = 'compare-dot';
      if (index === 0) dot.classList.add('active');
      indicatorContainer.appendChild(dot);
    });
    
    // Function to go to a specific slide
    function goToSlide(index) {
      if (index < 0 || index >= slots.length) return;
      
      currentIndex = index;
      
      // Update slider position
      sliderContainer.style.transform = `translateX(-${index * 100}%)`;
      
      // Update tabs
      document.querySelectorAll('.compare-tab').forEach((tab, i) => {
        tab.classList.toggle('active', i === index);
      });
      
      // Update indicators
      document.querySelectorAll('.compare-dot').forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
      });
      
      // Update navigation buttons
      prevBtn.classList.toggle('disabled', index === 0);
      nextBtn.classList.toggle('disabled', index === slots.length - 1);
    }
    
    // Add navigation button events
    prevBtn.addEventListener('click', () => {
      if (currentIndex > 0) goToSlide(currentIndex - 1);
    });
    
    nextBtn.addEventListener('click', () => {
      if (currentIndex < slots.length - 1) goToSlide(currentIndex + 1);
    });
    
    // Add touch/swipe support
    let startX = 0;
    let currentX = 0;
    let isDragging = false;
    
    sliderContainer.addEventListener('touchstart', (e) => {
      startX = e.touches[0].clientX;
      isDragging = true;
    });
    
    sliderContainer.addEventListener('touchmove', (e) => {
      if (!isDragging) return;
      currentX = e.touches[0].clientX;
    });
    
    sliderContainer.addEventListener('touchend', () => {
      if (!isDragging) return;
      isDragging = false;
      
      const diff = startX - currentX;
      const threshold = 50; // Minimum swipe distance
      
      if (diff > threshold && currentIndex < slots.length - 1) {
        goToSlide(currentIndex + 1);
      } else if (diff < -threshold && currentIndex > 0) {
        goToSlide(currentIndex - 1);
      }
    });
    
    // Initialize first slide
    goToSlide(0);
  }
  
  // Toggle between desktop and mobile views
  function toggleCompareView() {
    const desktopGrid = document.getElementById('cmpGrid');
    const mobileContainer = document.getElementById('mobileCompare');
    
    if (isMobileView()) {
      desktopGrid.style.display = 'none';
      mobileContainer.style.display = 'block';
      initMobileCompare();
    } else {
      desktopGrid.style.display = 'grid';
      mobileContainer.style.display = 'none';
    }
  }
  
  // Initial setup
  toggleCompareView();
  
  // Update on window resize
  window.addEventListener('resize', toggleCompareView);
})();

/* ===== Autocomplete + LAST VISITED ===== */
(function(){
  const grid = document.getElementById('cmpGrid');
  const baseUrl = grid.getAttribute('data-url'); // route('compare')
  const api = @json(route('mobiles.search'));

  // อ่านพารามิเตอร์ปัจจุบัน
  const params = new URLSearchParams(location.search);
  const sel = {1:params.get('m1'), 2:params.get('m2'), 3:params.get('m3')};

  // localStorage key
  const LS_KEY = 'smartspec:lastVisited';

  function getLastVisited(){
    try{ return JSON.parse(localStorage.getItem(LS_KEY)||'[]'); }catch(e){ return []; }
  }
  function pushLastVisited(item){
    let list = getLastVisited().filter(x=>x.id!==item.id);
    list.unshift(item);
    list = list.slice(0,10);
    localStorage.setItem(LS_KEY, JSON.stringify(list));
  }

  function buildItemHTML(it){
    return `<div class="item" data-id="${it.id}" data-name="${it.name}" data-brand="${it.brand}" data-img="${it.img}">
              <img src="${it.img}" alt="">
              <div>
                <div class="n">${it.name}</div>
                <div class="b">${it.brand??''}</div>
              </div>
            </div>`;
  }

  function fillList(container, items){
    container.innerHTML = items.map(buildItemHTML).join('') || `<div class="item" style="pointer-events:none"><div class="b">ไม่พบผลลัพธ์</div></div>`;
  }

  // ติดตั้งให้ทั้ง 3 ช่อง
  grid.querySelectorAll('.slot').forEach(slot=>{
    const slotNo = slot.getAttribute('data-slot');
    const input  = slot.querySelector('.q');
    const dd     = slot.querySelector('.dropdown');
    const list   = slot.querySelector('.list');

    // เปิด dropdown พร้อมโชว์ last visited
    input.addEventListener('focus', ()=>{
      const last = getLastVisited();
      if (last.length){
        dd.querySelector('.group-hd').style.display = 'block';
        dd.querySelector('.group-hd').textContent = 'LAST VISITED';
        fillList(list, last);
      }else{
        dd.querySelector('.group-hd').style.display = 'none';
        list.innerHTML = '';
      }
      dd.classList.add('open');
    });

    // พิมพ์หา (debounce)
    let t=null;
    input.addEventListener('input', ()=>{
      clearTimeout(t);
      const q=input.value.trim();
      t=setTimeout(async ()=>{
        const url = api + '?q=' + encodeURIComponent(q);
        try{
          const res = await fetch(url);
          const js  = await res.json();
          dd.querySelector('.group-hd').textContent = q ? 'RESULTS' : 'LAST VISITED';
          dd.querySelector('.group-hd').style.display = 'block';
          fillList(list, js.data || []);
          dd.classList.add('open');
        }catch(e){ /* ignore */ }
      }, 180);
    });

    // เลือกผลลัพธ์
    dd.addEventListener('click', e=>{
      const it = e.target.closest('.item'); if(!it) return;
      const item = { id: parseInt(it.dataset.id), name: it.dataset.name, brand: it.dataset.brand, img: it.dataset.img };
      pushLastVisited(item);

      // อัปเดตพารามิเตอร์ แล้ว redirect
      sel[slotNo] = item.id;
      const p = new URLSearchParams();
      if(sel[1]) p.set('m1', sel[1]);
      if(sel[2]) p.set('m2', sel[2]);
      if(sel[3]) p.set('m3', sel[3]);
      location.href = baseUrl + (p.toString()?('?'+p.toString()):'');
    });

    // ปิด dropdown เมื่อคลิกนอก
    document.addEventListener('click',(e)=>{
      if(!slot.contains(e.target)){ dd.classList.remove('open'); }
    });
  });
})();
</script>
</body>
</html>