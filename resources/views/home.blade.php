<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
  <script src="{{ asset('js/brand-ajax.js') }}" defer></script>

  <style>
  *{box-sizing:border-box}
  body{background:#f3f6fb;font-family:system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;margin:0;color:#0f2342;line-height:1.6}
  header{background:#0f2342;color:#fff;display:flex;justify-content:space-between;align-items:center;padding:12px 24px}
  header h1{margin:0;font-size:1.6rem;font-weight:700}
  header nav a{color:#fff;margin-left:14px;text-decoration:none;transition:opacity .2s ease}
  header nav a:hover{text-decoration:underline;opacity:.85}

  .banner-wrap{background:#2f3236;position:relative;padding:22px 64px 30px}
  .banner-empty{background:#2f3236;min-height:260px}
  .carousel{max-width:min(1280px,100%);margin:0 auto;overflow:hidden;position:relative}
  .carousel::before,.carousel::after{content:"";position:absolute;top:0;bottom:0;width:80px;z-index:2;pointer-events:none}
  .carousel::before{left:0;background:linear-gradient(90deg,rgba(47,50,54,1),rgba(47,50,54,0))}
  .carousel::after {right:0;background:linear-gradient(-90deg,rgba(47,50,54,1),rgba(47,50,54,0))}
  .track{display:flex;align-items:center;gap:48px;will-change:transform;transition:transform .5s ease;padding:10px 4px}
  .slide{flex:0 0 auto;width:clamp(260px, 26vw, 420px);aspect-ratio:16/9;border-radius:18px;background:#1f2124;overflow:hidden;box-shadow:0 14px 32px rgba(0,0,0,.35);transform:scale(.88);opacity:.7;transition:transform .35s ease, opacity .35s ease;cursor:pointer}
  .slide.is-active{transform:scale(1);opacity:1}
  .slide img{width:100%;height:100%;object-fit:cover;background:#1f2124}
  .nav{position:absolute;top:50%;transform:translateY(-50%);width:40px;height:40px;border-radius:999px;border:none;background:#fff;color:#0f2342;font-size:22px;font-weight:700;display:grid;place-items:center;cursor:pointer;z-index:3;box-shadow:0 6px 16px rgba(0,0,0,.3)}
  .nav.prev{left:16px} .nav.next{right:16px}
  .nav:hover{filter:brightness(.95)}
  .dots{display:flex;gap:10px;justify-content:center;margin-top:14px}
  .dot{width:8px;height:8px;border-radius:999px;border:none;cursor:pointer;background:#9da3af;opacity:.75}
  .dot.is-active{width:24px;background:#fff;opacity:1}

  .layout{display:grid;grid-template-columns:220px 1fr;gap:16px;padding:16px}
  .sidebar h3{margin-top:0}
  .brand-list{list-style:none;margin:0;padding:0}
  .brand-list li{margin:4px 0}
  .brand-list a{color:#0f2342;text-decoration:none}
  .brand-list a:hover{text-decoration:underline}

  .search-box{background:#fff;padding:16px;border-radius:16px;box-shadow:0 2px 8px rgba(15,35,66,.06);margin-bottom:20px;border:1px solid #e8eef5}
  .search-box form{display:flex; gap:10px; align-items:center}
  .search-box input{flex:1;padding:12px 16px;border:1px solid #d1d5db;border-radius:10px;font-size:14px;font-family:inherit;transition:border-color .2s ease,box-shadow .2s ease}
  .search-box input:focus{outline:none;border-color:#0f2342;box-shadow:0 0 0 3px rgba(15,35,66,.08)}
  .search-box button{padding:12px 20px;border:0;border-radius:10px;background:#0f2342;color:#fff;font-weight:600;cursor:pointer;transition:all .2s ease;font-size:14px}
  .search-box button:hover{background:#0a1a2e;transform:translateY(-1px);box-shadow:0 4px 12px rgba(15,35,66,.15)}
  .search-box button:active{transform:translateY(0)}

  .mobile-grid{display:grid;grid-template-columns:repeat(8,1fr);gap:20px;padding:24px 0}
  @media (max-width: 1200px){ .mobile-grid{grid-template-columns:repeat(4,1fr);gap:16px} }
  @media (max-width: 720px){  .mobile-grid{grid-template-columns:repeat(2,1fr);gap:12px} }
  .mobile-card{background:#fff;border-radius:16px;box-shadow:0 2px 8px rgba(15,35,66,.08);text-align:center;padding:16px;min-height:220px;transition:all .25s ease;border:1px solid transparent}
  .mobile-card:hover{transform:translateY(-4px);box-shadow:0 8px 24px rgba(15,35,66,.12);border-color:#e8eef5}
  .mobile-card img{max-width:100%;height:140px;object-fit:contain;margin-bottom:12px;transition:transform .25s ease}
  .mobile-card:hover img{transform:scale(1.05)}
  .mobile-card h3{font-size:14px;margin:0;font-weight:600;color:#0f2342;line-height:1.4}
  .mobile-card-link{display:block;text-decoration:none;color:inherit;border-radius:16px}
  .mobile-card-link:focus-visible{outline:3px solid #0f2342;outline-offset:2px}

  /* empty-state (ใหม่) */
  .empty-state{
    grid-column:1 / -1;background:#fff;border-radius:12px;
    box-shadow:0 4px 12px rgba(15,35,66,.08);
    padding:24px;text-align:center;color:#374151
  }
  .empty-state h3{margin:0 0 6px;font-size:18px;color:#0f2342}
  .empty-state .btn-ghost{
    display:inline-block;margin-top:10px;padding:10px 14px;
    border:1px solid #d1d5db;border-radius:8px;background:#fff;
    color:#0f2342;font-weight:600;text-decoration:none
  }
  .empty-state .btn-ghost:hover{filter:brightness(.97)}

  .btn-filter{padding:12px 16px;border:1px solid #d1d5db;border-radius:10px;background:#fff;color:#0f2342;font-weight:600;cursor:pointer;transition:all .2s ease;font-size:14px}
  .btn-filter:hover{background:#f9fafb;border-color:#0f2342;transform:translateY(-1px);box-shadow:0 2px 8px rgba(15,35,66,.1)}

  .modal{position:fixed;inset:0;display:none;z-index:50}
  .modal[aria-hidden="false"]{display:block}
  .modal__backdrop{position:absolute;inset:0;background:rgba(0,0,0,.45)}
  .modal__panel{position:relative;max-width:min(980px,96vw);margin:6vh auto;background:#fff;border-radius:16px;box-shadow:0 24px 60px rgba(0,0,0,.25);display:flex;flex-direction:column;overflow:hidden}
  .modal__head,.modal__foot{padding:14px 16px; border-bottom:1px solid #eef1f; display:flex; align-items:center;}
  .modal__foot{border-bottom:0;border-top:1px solid #eef1f5;display:flex;align-items:center;gap:10px}
  .modal__body{padding:14px 16px;max-height:70vh;overflow:auto}
  .modal__head h3{margin:0;font-size:18px}
  .modal__close{border:0;background:#f3f4f6;border-radius:8px;padding:6px 10px;font-size:18px;margin-left:auto;cursor:pointer}
  .spacer{flex:1}
  .link-reset{color:#0f2342;text-decoration:none}
  .link-reset:hover{text-decoration:underline}
  .btn-apply{padding:10px 14px;border:0;border-radius:10px;background:#0f2342;color:#fff;font-weight:700;cursor:pointer}

  .filters-grid{display:grid;grid-template-columns:repeat(3,minmax(160px,1fr));gap:12px;margin-bottom:10px}
  .filters-grid label{display:flex;flex-direction:column;font-size:12px;gap:6px}
  .filters-grid input,.filters-grid select{padding:8px 10px;border:1px solid #d1d5db;border-radius:8px;font-size:14px}
  .check-inline{display:inline-flex;align-items:center;gap:4px;margin-top:6px;font-size:13px}
  .filters-grid .row-full { grid-column: 1 / -1; }

  .range-wrap{display:grid;gap:14px}
  .range-row{display:grid;gap:6px}
  .range-label{font-size:12px;color:#374151;display:flex;align-items:center;gap:8px}
  .range-val{font-size:12px;background:#0f2342;color:#fff;border-radius:999px;padding:2px 8px}
  .dual{position:relative;height:38px;display:flex;align-items:center}
  .dual input[type="range"]{position:absolute;left:0;right:0;margin:0;height:0;appearance:none;background:transparent;pointer-events:auto}
  .dual input[type="range"]::-webkit-slider-thumb{appearance:none;width:18px;height:18px;border-radius:50%;background:#0f2342;border:2px solid #fff;box-shadow:0 2px 6px rgba(0,0,0,.25);cursor:pointer;position:relative;z-index:2}
  .dual input[type="range"]::-moz-range-thumb{width:18px;height:18px;border:none;border-radius:50%;background:#0f2342;box-shadow:0 2px 6px rgba(0,0,0,.25);cursor:pointer;position:relative;z-index:2}
  .dual__track{position:absolute;left:4px;right:4px;height:6px;background:#e5e7eb;border-radius:999px}
  .dual__track .fill{position:absolute;top:0;bottom:0;left:0;right:0;background:#0f2342;border-radius:999px}
  /* ===== Brand panel (เหมือน home.blade) ===== */
  /* กล่องครอบ */
  .brand-panel{
    background:#fff; border:1px solid #e5e7eb; border-radius:14px;
    padding:12px; box-shadow:0 2px 10px rgba(15,35,66,.05);
  }
  .brand-panel__head{ font-weight:700; margin:0 0 10px; color:#0f2342 }

  /* กริดโลโก้ */
  .brand-grid{
    list-style:none; margin:0; padding:0;
    display:grid; grid-template-columns:repeat(2,1fr); gap:10px;
  }
  @media (max-width: 760px){
    .brand-grid{ grid-template-columns:repeat(3,1fr); }
  }
  .brand-grid__item{ margin:0; padding:0 }

  /* ไทล์โลโก้ */
  .brand-logo{
    display:flex; align-items:center; justify-content:center;
    height:64px; border-radius:12px;
    background:#f8fafc; border:1px solid #e5e7eb;
    text-decoration:none; overflow:hidden; padding:8px;
    box-shadow:0 1px 3px rgba(15,35,66,.04) inset;
  }
  .brand-logo:hover{ filter:brightness(.98) }
  .brand-logo.is-active{
    background:#fff; border-color:#0f2342;
    box-shadow:0 0 0 3px rgba(15,35,66,.12);
  }

  /* รูปโลโก้ให้อยู่กลางพอดีและไม่ล้น */
  .brand-logo img{
    display:block; width:100%; height:100%;
    object-fit:contain;
  }

  /* กรณีไม่มีโลโก้ */
  .no-logo{
    width:40px; height:40px; border-radius:50%;
    display:grid; place-items:center;
    background:#eef2f7; color:#0f2342; font-weight:700;
  }

  /* ซ่อนข้อความเพื่อการเข้าถึง */
  .sr-only{
    position:absolute; width:1px; height:1px; padding:0; margin:-1px;
    overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0;
  }


  /* Stack layout on small screens */
  @media (max-width: 900px){ .layout{grid-template-columns:1fr} }
  /* Tighter banner padding on phones */
  @media (max-width: 600px){ .banner-wrap{padding:16px} }
  @media (max-width: 720px){ .filters-grid{grid-template-columns:1fr} }
  </style>
</head>
<body style="margin:0;background:#f3f6fb;font-family:sans-serif;">
  @include('layouts.navbar')

  @php $banners = ($banners ?? $banner ?? collect()); @endphp

  @if($banners->count())
    <div class="banner-wrap">
      <button class="nav prev" type="button" aria-label="prev">‹</button>
      <div class="carousel">
        <div class="track">
          @foreach($banners as $b)
            <a class="slide" href="#" aria-label="banner">
              <img src="{{ $b->image_url }}" alt="Banner">
            </a>
          @endforeach
        </div>
      </div>
      <button class="nav next" type="button" aria-label="next">›</button>
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
        <div class="brand-panel__head">แบรนด์</div>

        <ul class="brand-grid">
          @foreach($brands as $b)
            @php
              // สถานะถูกเลือก?
              $active = (string)request('brand') === (string)$b->ID;

              // เก็บพารามิเตอร์ตัวกรองเดิมทั้งหมด (ยกเว้น page)
              $qAll = request()->except('page');

              // ถ้ากดซ้ำที่แบรนด์เดิม → ล้าง brand ออก
              $href = $active
                ? route('home', array_filter(array_merge($qAll, ['brand' => null])))
                : route('home', array_merge($qAll, ['brand' => $b->ID]));
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
        <form method="GET" action="{{ route('search') }}">
          <input type="text" name="q" placeholder="ค้นหามือถือ..." value="{{ request('q') }}">
          <button type="submit">ค้นหา</button>

          <button type="button" id="openFilters" class="btn-filter">ตัวกรอง</button>
          <input type="hidden" name="filters" id="filtersFlag" value="">

          <!-- Modal -->
          <div class="modal" id="filtersModal" aria-hidden="true">
            <div class="modal__backdrop" data-close></div>
            <div class="modal__panel" role="dialog" aria-modal="true" aria-labelledby="filtersTitle">
              <div class="modal__head">
                <h3 id="filtersTitle">ตัวกรองทั้งหมด</h3>
                <button type="button" class="modal__close" title="ปิด" data-close>×</button>
              </div>

              <div class="modal__body">
                <div class="filters-grid">
                  <label>
                    แบรนด์
                    <select name="brand">
                      <option value="">— ทั้งหมด —</option>
                      @foreach($brands as $b)
                        <option value="{{ $b->ID }}" {{ (string)request('brand')===(string)$b->ID?'selected':'' }}>
                          {{ $b->Brand }}
                        </option>
                      @endforeach
                    </select>
                  </label>

                  <label>
                    ระบบปฏิบัติการ
                    <select name="os">
                      <option value="">— ทั้งหมด —</option>
                      @foreach(($osList ?? []) as $os)
                        @if($os)
                          <option value="{{ $os }}" {{ request('os')===$os?'selected':'' }}>{{ $os }}</option>
                        @endif
                      @endforeach
                    </select>
                  </label>

                  <label>
                    ชิป/โปรเซสเซอร์
                    <select name="cpu">
                      <option value="">— ทั้งหมด —</option>
                      @foreach(($cpuList ?? []) as $cpu)
                        @if($cpu)
                          <option value="{{ $cpu }}" {{ request('cpu')===$cpu?'selected':'' }}>{{ $cpu }}</option>
                        @endif
                      @endforeach
                    </select>
                  </label>
                </div>
                <label class="check-inline row-full" style="margin-top:5px ; margin-bottom:15px">
                  <input type="checkbox" name="has5g" value="1" {{ request('has5g')?'checked':'' }}>
                  รองรับ 5G
                </label>

                <div class="range-wrap">
                  <div class="range-row">
                    <div class="range-label">RAM (GB) <span class="range-val" data-out="ram"></span></div>
                    <div class="dual">
                      <input type="range" min="0" max="24" step="1" value="{{ request('ram_min', 0) }}"  data-min="ram">
                      <input type="range" min="0" max="24" step="1" value="{{ request('ram_max', 24) }}" data-max="ram">
                      <div class="dual__track" data-track="ram"><div class="fill"></div></div>
                    </div>
                    <input type="hidden" name="ram_min" value="{{ request('ram_min') }}">
                    <input type="hidden" name="ram_max" value="{{ request('ram_max') }}">
                  </div>

                  <div class="range-row">
                    <div class="range-label">ขนาดจอ (นิ้ว) <span class="range-val" data-out="screen"></span></div>
                    <div class="dual">
                      <input type="range" min="4.0" max="7.5" step="0.1" value="{{ request('screen_min', 4.0) }}" data-min="screen">
                      <input type="range" min="4.0" max="7.5" step="0.1" value="{{ request('screen_max', 7.5) }}" data-max="screen">
                      <div class="dual__track" data-track="screen"><div class="fill"></div></div>
                    </div>
                    <input type="hidden" name="screen_min" value="{{ request('screen_min') }}">
                    <input type="hidden" name="screen_max" value="{{ request('screen_max') }}">
                  </div>

                  <div class="range-row">
                    <div class="range-label">กล้องหลัง (MP) <span class="range-val" data-out="rear"></span></div>
                    <div class="dual">
                      <input type="range" min="0" max="200" step="1" value="{{ request('rear_mp_min', 0) }}" data-min="rear">
                      <input type="range" min="0" max="200" step="1" value="{{ request('rear_mp_max', 200) }}" data-max="rear">
                      <div class="dual__track" data-track="rear"><div class="fill"></div></div>
                    </div>
                    <input type="hidden" name="rear_mp_min" value="{{ request('rear_mp_min') }}">
                    <input type="hidden" name="rear_mp_max" value="{{ request('rear_mp_max') }}">
                  </div>

                  <div class="range-row">
                    <div class="range-label">กล้องหน้า (MP) <span class="range-val" data-out="front"></span></div>
                    <div class="dual">
                      <input type="range" min="0" max="60" step="1" value="{{ request('front_mp_min', 0) }}" data-min="front">
                      <input type="range" min="0" max="60" step="1" value="{{ request('front_mp_max', 60) }}" data-max="front">
                      <div class="dual__track" data-track="front"><div class="fill"></div></div>
                    </div>
                    <input type="hidden" name="front_mp_min" value="{{ request('front_mp_min') }}">
                    <input type="hidden" name="front_mp_max" value="{{ request('front_mp_max') }}">
                  </div>

                  <div class="range-row">
                    <div class="range-label">แบตเตอรี่ (mAh) <span class="range-val" data-out="bat"></span></div>
                    <div class="dual">
                      <input type="range" min="1000" max="7000" step="100" value="{{ request('battery_min', 1000) }}" data-min="bat">
                      <input type="range" min="1000" max="7000" step="100" value="{{ request('battery_max', 7000) }}" data-max="bat">
                      <div class="dual__track" data-track="bat"><div class="fill"></div></div>
                    </div>
                    <input type="hidden" name="battery_min" value="{{ request('battery_min') }}">
                    <input type="hidden" name="battery_max" value="{{ request('battery_max') }}">
                  </div>

                  <div class="range-row">
                    <div class="range-label">ราคา (บาท) <span class="range-val" data-out="price"></span></div>
                    <div class="dual">
                      <input type="range" min="0" max="80000" step="500" value="{{ request('price_min', 0) }}" data-min="price">
                      <input type="range" min="0" max="80000" step="500" value="{{ request('price_max', 80000) }}" data-max="price">
                      <div class="dual__track" data-track="price"><div class="fill"></div></div>
                    </div>
                    <input type="hidden" name="price_min" value="{{ request('price_min') }}">
                    <input type="hidden" name="price_max" value="{{ request('price_max') }}">
                  </div>

                  <div class="range-row">
                    <div class="range-label">ปีเปิดตัว <span class="range-val" data-out="year"></span></div>
                    <div class="dual">
                      <input type="range" min="2012" max="2030" step="1" value="{{ request('year_from', 2012) }}" data-min="year">
                      <input type="range" min="2012" max="2030" step="1" value="{{ request('year_to', 2030) }}" data-max="year">
                      <div class="dual__track" data-track="year"><div class="fill"></div></div>
                    </div>
                    <input type="hidden" name="year_from" value="{{ request('year_from') }}">
                    <input type="hidden" name="year_to" value="{{ request('year_to') }}">
                  </div>

                </div>
              </div>

              <div class="modal__foot">
              <button type="button" class="link-reset" id="clearFilters"
                      data-clear-url="{{ route('home') }}">
                  ล้างตัวกรอง
                </button>
                <div class="spacer"></div>
                <button type="submit" class="btn-apply" id="applyFilters">ใช้ตัวกรอง</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      @php
        $hasFilters = collect([
          'q','brand','os','cpu',
          'ram_min','ram_max','screen_min','screen_max',
          'rear_mp_min','rear_mp_max','front_mp_min','front_mp_max',
          'battery_min','battery_max','price_min','price_max',
          'year_from','year_to','has5g'
        ])->some(fn($k)=>request()->filled($k));
      @endphp

      <div id="results">
      <div class="mobile-grid">
        @forelse($mobiles as $m)
          @php
            $imgPath = $m->coverImage?->Img ?? $m->images->first()?->Img ?? null;
            $imgUrl  = $imgPath ? asset('storage/'.$imgPath) : asset('images/default.jpg');
          @endphp
          <a href="{{ route('mobile.show', $m->ID) }}" class="mobile-card-link">
            <div class="mobile-card hover-lift">
              <img src="{{ $imgUrl }}" alt="{{ $m->Model }}">
              <h3>{{ $m->Model }}</h3>
            </div>
          </a>
        @empty
          <div class="empty-state">
            <h3>ไม่พบผลลัพธ์</h3>
            @if($hasFilters)
              <p>ลองปรับตัวกรอง หรือเริ่มใหม่ด้วยการล้างตัวกรอง</p>
              <a href="{{ route('home') }}" class="btn-ghost">ล้างตัวกรอง</a>
            @else
              <p>ยังไม่มีข้อมูลมือถือในระบบ</p>
            @endif
          </div>
        @endforelse
      </div>
      </div><!-- /#results -->

      @if(method_exists($mobiles, 'hasPages') && $mobiles->hasPages())
        @php
          $prev = $mobiles->previousPageUrl();
          $next = $mobiles->nextPageUrl();
        @endphp
        <div style="margin:24px 0;display:flex;justify-content:center;align-items:center;gap:12px">
          <a href="{{ $prev ?: '#' }}" style="padding:10px 16px;border:1px solid #d1d5db;border-radius:10px;background:#fff;color:#0f2342;text-decoration:none;font-weight:500;transition:all .2s ease;{{ $prev ? '' : 'pointer-events:none;opacity:.4' }}{{ $prev ? ';cursor:pointer' : '' }}">{{ $prev ? '‹ ก่อนหน้า' : 'ก่อนหน้า' }}</a>
          @if(method_exists($mobiles,'currentPage'))
            <span style="font-size:15px;color:#64748b;font-weight:500;padding:0 8px">หน้า {{ $mobiles->currentPage() }} @if(method_exists($mobiles,'lastPage')) / {{ $mobiles->lastPage() }} @endif</span>
          @endif
          <a href="{{ $next ?: '#' }}" style="padding:10px 16px;border:1px solid #d1d5db;border-radius:10px;background:#fff;color:#0f2342;text-decoration:none;font-weight:500;transition:all .2s ease;{{ $next ? '' : 'pointer-events:none;opacity:.4' }}{{ $next ? ';cursor:pointer' : '' }}">{{ $next ? 'ถัดไป ›' : 'ถัดไป' }}</a>
        </div>
      @endif
    </main>
  </div>

  <script>
  /* Carousel (robust) */
  (function(){
    const wrap = document.querySelector('.banner-wrap'); if(!wrap) return;
    const carousel = wrap.querySelector('.carousel');
    const track = wrap.querySelector('.track');
    const prevBtn = wrap.querySelector('.prev');
    const nextBtn = wrap.querySelector('.next');
    const dots = Array.from(wrap.querySelectorAll('.dot'));

    const realSlides = Array.from(track.children);
    if (realSlides.length <= 1) { prevBtn?.setAttribute('disabled','true'); nextBtn?.setAttribute('disabled','true'); return; }

    const head = realSlides[0].cloneNode(true);
    const tail = realSlides[realSlides.length - 1].cloneNode(true);
    track.insertBefore(tail, realSlides[0]);
    track.appendChild(head);

    let all = Array.from(track.children);
    let idx = 1;
    let gapPx = 48;
    let itemW = 0;
    let centerOffset = 0;
    let isAnimating = false;
    let timer = null;

    const readGap = () => { const s = getComputedStyle(track); const g = parseFloat(s.gap || s['column-gap'] || '48'); gapPx = isNaN(g) ? 48 : g; };
    const measure = () => { readGap(); itemW = all[idx].offsetWidth; centerOffset = (carousel.clientWidth - itemW) / 2; setX(); };
    const setX = () => { track.style.transform = `translateX(${centerOffset - idx * (itemW + gapPx)}px)`; };
    const setActive = () => {
      all.forEach(el => el.classList.remove('is-active'));
      all[idx]?.classList.add('is-active');
      let real = idx - 1; if (real < 0) real = realSlides.length - 1; if (real >= realSlides.length) real = 0;
      dots.forEach(d => d.classList.remove('is-active')); dots[real]?.classList.add('is-active');
    };

    const go = (step) => {
      if (isAnimating) return;
      isAnimating = true;
      idx += step;
      track.style.transition = 'transform .5s ease';
      setX();
      clearTimeout(go._fallback);
      go._fallback = setTimeout(()=> handleEdgeSnap(), 600);
    };

    function handleEdgeSnap(){
      if (idx === all.length - 1) { track.style.transition = 'none'; idx = 1; setX(); requestAnimationFrame(()=> track.style.transition = 'transform .5s ease'); }
      else if (idx === 0)       { track.style.transition = 'none'; idx = realSlides.length; setX(); requestAnimationFrame(()=> track.style.transition = 'transform .5s ease'); }
      setActive(); isAnimating = false;
    }

    track.style.transition = 'none';
    measure();
    requestAnimationFrame(()=> track.style.transition = 'transform .5s ease');
    setActive();

    nextBtn?.addEventListener('click', ()=> go(1));
    prevBtn?.addEventListener('click', ()=> go(-1));

    track.addEventListener('click', (e)=>{ const slide = e.target.closest('.slide'); if(!slide) return; const i = all.indexOf(slide); if (i > -1) go(i - idx); });
    dots.forEach((d,i)=> d.addEventListener('click', ()=> { const target = i + 1; if (target !== idx) go(target - idx); }));
    track.addEventListener('transitionend', handleEdgeSnap);

    function startAuto(){ timer = setInterval(()=> go(1), 3500); }
    function stopAuto(){ clearInterval(timer); timer = null; }
    startAuto();
    wrap.addEventListener('mouseenter', stopAuto);
    wrap.addEventListener('mouseleave', ()=> { if(!timer) startAuto(); });
    document.addEventListener('visibilitychange', ()=>{ if (document.hidden) stopAuto(); else { measure(); startAuto(); } });
    window.addEventListener('resize', ()=> requestAnimationFrame(measure));
    Array.from(track.querySelectorAll('img')).forEach(img=>{ if(img.complete) return; img.addEventListener('load', ()=> requestAnimationFrame(measure), {once:true}); });
  })();

  /* Modal + Sliders */
  (function(){
    const modal   = document.getElementById('filtersModal');
    const openBtn = document.getElementById('openFilters');
    const closeEls= modal.querySelectorAll('[data-close]');
    const applyBtn= document.getElementById('applyFilters');

    const open  = ()=> modal.setAttribute('aria-hidden','false');
    const close = ()=> modal.setAttribute('aria-hidden','true');

    openBtn?.addEventListener('click', open);
    closeEls.forEach(el=>el.addEventListener('click', close));
    document.addEventListener('keydown', e => { if(e.key==='Escape') close(); });

    applyBtn?.addEventListener('click', () => { close(); });

    const clearBtn = document.getElementById('clearFilters');
    clearBtn?.addEventListener('click', () => {
      close();
      const url = clearBtn.dataset.clearUrl || '{{ route('search') }}';
      setTimeout(()=> { window.location.assign(url); }, 120);
    });

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

    const fmt = {
      price:v=>Number(v).toLocaleString()+' บาท',
      bat:  v=>Number(v).toLocaleString()+' mAh',
      rear: v=>v+' MP',
      front:v=>v+' MP',
      screen:v=>Number(v).toFixed(1)+'"',
      ram:  v=>v+' GB',
      year: v=>v
    };

    setupDual('ram',    fmt.ram);
    setupDual('screen', fmt.screen);
    setupDual('price',  fmt.price);
    setupDual('rear',   fmt.rear,  'rear_mp_min','rear_mp_max');
    setupDual('front',  fmt.front, 'front_mp_min','front_mp_max');
    setupDual('bat',    fmt.bat,   'battery_min','battery_max');
    setupDual('year',   fmt.year,  'year_from','year_to');
  })();
  </script>
</body>
</html>
