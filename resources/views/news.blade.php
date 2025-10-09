<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">

  <style>
  /* ===== Base / Navbar ===== */
  body{background:#f3f6fb;font-family:sans-serif;margin:0;color:#0f2342}
  header{background:#0f2342;color:#fff;display:flex;justify-content:space-between;align-items:center;padding:12px 24px}
  header h1{margin:0;font-size:1.6rem}
  header nav a{color:#fff;margin-left:14px;text-decoration:none}
  header nav a:hover{text-decoration:underline}

  /* ===== Banner (robust center-mode) ===== */
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

  /* ===== Layout ===== */
  .layout{display:grid;grid-template-columns:220px 1fr;gap:16px;padding:16px}
  .sidebar h3{margin-top:0}
  .brand-list{list-style:none;margin:0;padding:0}
  .brand-list li{margin:4px 0}
  .brand-list a{color:#0f2342;text-decoration:none}
  .brand-list a:hover{text-decoration:underline}

  .search-box{background:#fff;padding:12px;border-radius:12px;box-shadow:0 4px 12px rgba(15,35,66,.08);margin-bottom:16px}
  .search-box form{display:flex; gap:8px; align-items:center}
  .search-box input{flex:1;padding:10px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box}
  .search-box button{padding:10px 14px;border:0;border-radius:8px;background:#0f2342;color:#fff;font-weight:600;cursor:pointer}
  .search-box button:hover{filter:brightness(.95)}
  .btn-filter{padding:10px 12px;border:0;border-radius:8px;background:#fff;color:#0f2342;font-weight:600;cursor:pointer;box-shadow:0 0 0 1px #d1d5db inset}
  .btn-filter:hover{filter:brightness(.97)}

  /* ===== Modal Filters ===== */
  .modal{position:fixed;inset:0;display:none;z-index:50}
  .modal[aria-hidden="false"]{display:block}
  .modal__backdrop{position:absolute;inset:0;background:rgba(0,0,0,.45)}
  .modal__panel{position:relative;max-width:min(980px,96vw);margin:6vh auto;background:#fff;border-radius:16px;box-shadow:0 24px 60px rgba(0,0,0,.25);display:flex;flex-direction:column;overflow:hidden}
  .modal__head,.modal__foot{padding:14px 16px;border-bottom:1px solid #eef1f5;display:flex;align-items:center}
  .modal__foot{border-bottom:0;border-top:1px solid #eef1f5;gap:10px}
  .modal__body{padding:14px 16px;max-height:70vh;overflow:auto}
  .modal__head h3{margin:0;font-size:18px}
  .modal__close{border:0;background:#f3f4f6;border-radius:8px;padding:6px 10px;font-size:18px;margin-left:auto;cursor:pointer}
  .spacer{flex:1}
  .link-reset{background:none;border:none;color:#0f2342;text-decoration:none;cursor:pointer}
  .link-reset:hover{text-decoration:underline}
  .btn-apply{padding:10px 14px;border:0;border-radius:10px;background:#0f2342;color:#fff;font-weight:700;cursor:pointer}

  .filters-grid{display:grid;grid-template-columns:repeat(3,minmax(160px,1fr));gap:12px;margin-bottom:10px}
  .filters-grid label{display:flex;flex-direction:column;font-size:12px;gap:6px}
  .filters-grid input,.filters-grid select{padding:8px 10px;border:1px solid #d1d5db;border-radius:8px;font-size:14px}

  /* ===== Dual range (year) ===== */
  .range-row{display:grid;gap:6px}
  .range-label{font-size:12px;color:#374151;display:flex;align-items:center;gap:8px}
  .range-val{font-size:12px;background:#0f2342;color:#fff;border-radius:999px;padding:2px 8px}
  .dual{position:relative;height:38px;display:flex;align-items:center}
  .dual input[type="range"]{position:absolute;left:0;right:0;margin:0;height:0;appearance:none;background:transparent;pointer-events:auto}
  .dual input[type="range"]::-webkit-slider-thumb{appearance:none;width:18px;height:18px;border-radius:50%;background:#0f2342;border:2px solid #fff;box-shadow:0 2px 6px rgba(0,0,0,.25);cursor:pointer;position:relative;z-index:2}
  .dual input[type="range"]::-moz-range-thumb{width:18px;height:18px;border:none;border-radius:50%;background:#0f2342;box-shadow:0 2px 6px rgba(0,0,0,.25);cursor:pointer;position:relative;z-index:2}
  .dual__track{position:absolute;left:4px;right:4px;height:6px;background:#e5e7eb;border-radius:999px}
  .dual__track .fill{position:absolute;top:0;bottom:0;left:0;right:0;background:#0f2342;border-radius:999px}

  /* ===== News list & empty state ===== */
  .news-list{display:flex;flex-direction:column;gap:18px}
  .news-item{display:grid;grid-template-columns:160px 1fr;gap:14px;background:#fff;border-radius:12px;box-shadow:0 4px 12px rgba(15,35,66,.08);padding:12px}
  .news-thumb{width:160px;height:160px;border-radius:10px;overflow:hidden;background:#e9eef5}
  .news-thumb img{width:100%;height:100%;object-fit:cover;display:block}
  .news-title{margin:0 0 6px;font-size:18px;line-height:1.35}
  .news-title a{color:#0f2342;text-decoration:none}
  .news-title a:hover{text-decoration:underline}
  .news-intro{color:#465975;margin:0 0 8px}
  .news-meta{font-size:12px;color:#6b7280;display:flex;gap:12px;align-items:center}
  .news-card-link{display:block;text-decoration:none;color:inherit}
  .news-item{transition:transform .12s ease, box-shadow .12s ease}
  .news-card-link:hover .news-item{transform:translateY(-2px); box-shadow:0 8px 18px rgba(15,35,66,.12)}

  .empty-state{
    background:#fff;border-radius:12px;box-shadow:0 4px 12px rgba(15,35,66,.08);
    padding:24px;text-align:center;color:#374151
  }
  .empty-state h3{margin:0 0 6px;font-size:18px;color:#0f2342}
  .btn-ghost{
    display:inline-block;margin-top:10px;padding:10px 14px;
    border:1px solid #d1d5db;border-radius:8px;background:#fff;
    color:#0f2342;font-weight:600;text-decoration:none
  }
  .btn-ghost:hover{filter:brightness(.97)}

  @media (max-width:720px){ .filters-grid{grid-template-columns:1fr} }
  @media (max-width:680px){ .news-item{grid-template-columns:1fr}.news-thumb{height:180px;width:100%} }
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
      <h3>แบรนด์</h3>
      <ul class="brand-list">
        @foreach($brands as $b)
          <li>
            <a href="{{ route('news', ['brand' => $b->ID]) }}"
               style="{{ (string)request('brand')===(string)$b->ID ? 'font-weight:700;text-decoration:underline;' : '' }}">
              {{ $b->Brand }}
            </a>
          </li>
        @endforeach
      </ul>
    </aside>

    <main class="content">
      <div class="search-box">
        <form method="GET" action="{{ route('news') }}">
          <input type="text" name="q" placeholder="ค้นหาข่าว..." value="{{ request('q') }}">
          <button type="submit">ค้นหา</button>

          <!-- ปุ่มเปิดตัวกรอง -->
          <button type="button" id="openFilters" class="btn-filter">ตัวกรอง</button>

          <!-- Modal Filters -->
          <div class="modal" id="filtersModal" aria-hidden="true">
            <div class="modal__backdrop" data-close></div>
            <div class="modal__panel" role="dialog" aria-modal="true" aria-labelledby="filtersTitle">
              <div class="modal__head">
                <h3 id="filtersTitle">ตัวกรองข่าว</h3>
                <button type="button" class="modal__close" title="ปิด" data-close>×</button>
              </div>

              <div class="modal__body">
                <div class="filters-grid">
                  <!-- แบรนด์ -->
                  <label>
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
                <div class="range-row" style="margin-top:10px">
                  <div class="range-label">ปีที่ลงข่าว <span class="range-val" data-out="nyear"></span></div>
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
                <button type="button" class="link-reset" id="clearFilters" data-clear-url="{{ route('news') }}">ล้างตัวกรอง</button>
                <div class="spacer"></div>
                <button type="submit" class="btn-apply" id="applyFilters">ใช้ตัวกรอง</button>
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

      <div class="news-list">
        @forelse($items as $n)
          @php
            $imgPath = $n->cover?->Img ?? $n->images->first()?->Img ?? null;
            $imgUrl  = $imgPath ? asset('storage/'.$imgPath) : asset('images/default.jpg');
            $intro   = \Illuminate\Support\Str::limit(strip_tags($n->Intro ?: $n->Details), 140);
          @endphp

          <a href="{{ route('news.show', $n->ID) }}" class="news-card-link">
            <article class="news-item">
              <div class="news-thumb">
                <img src="{{ $imgUrl }}" alt="{{ $n->Title }}">
              </div>
              <div>
                <h2 class="news-title">{{ $n->Title }}</h2>
                <p class="news-intro">{{ $intro }}</p>
                <div class="news-meta">
                  <span>{{ optional($n->Date)->format('d M Y H:i') }}</span>
                  @if($n->brand)  <span>• {{ $n->brand->Brand }}</span> @endif
                  @if($n->mobile) <span>• {{ $n->mobile->Model }}</span> @endif
                </div>
              </div>
            </article>
          </a>
        @empty
          {{-- เดิม --}}
        @endforelse
      </div>

      @if($items->total() > 0)
        <div style="margin-top:16px">
          {{ $items->onEachSide(1)->links() }}
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
    if (realSlides.length <= 1) { prevBtn?.setAttribute('disabled','true'); nextBtn?.setAttribute('disabled','true'); return; }

    const head = realSlides[0].cloneNode(true);
    const tail = realSlides[realSlides.length - 1].cloneNode(true);
    track.insertBefore(tail, realSlides[0]);
    track.appendChild(head);

    let all = Array.from(track.children);
    let idx = 1, gapPx = 48, itemW = 0, centerOffset = 0;
    let isAnimating = false, timer = null;

    const readGap = () => { const s = getComputedStyle(track); const g = parseFloat(s.gap || s['column-gap'] || '48'); gapPx = isNaN(g) ? 48 : g; };
    const measure = () => { readGap(); itemW = all[idx].offsetWidth; centerOffset = (carousel.clientWidth - itemW) / 2; setX(); };
    const setX = () => { track.style.transform = `translateX(${centerOffset - idx * (itemW + gapPx)}px)`; };
    const setActive = () => {
      all.forEach(el => el.classList.remove('is-active')); all[idx]?.classList.add('is-active');
      let real = idx - 1; if (real < 0) real = realSlides.length - 1; if (real >= realSlides.length) real = 0;
      dots.forEach(d => d.classList.remove('is-active')); dots[real]?.classList.add('is-active');
    };

    const go = (step) => {
      if (isAnimating) return;
      isAnimating = true;
      idx += step;
      track.style.transition = 'transform .5s ease'; setX();
      clearTimeout(go._fallback); go._fallback = setTimeout(()=> handleEdgeSnap(), 600);
    };

    function handleEdgeSnap(){
      if (idx === all.length - 1){ track.style.transition='none'; idx = 1; setX(); requestAnimationFrame(()=> track.style.transition='transform .5s ease'); }
      else if (idx === 0){ track.style.transition='none'; idx = realSlides.length; setX(); requestAnimationFrame(()=> track.style.transition='transform .5s ease'); }
      setActive(); isAnimating = false;
    }

    track.style.transition='none'; measure(); requestAnimationFrame(()=> track.style.transition='transform .5s ease'); setActive();
    nextBtn?.addEventListener('click', ()=> go(1));
    prevBtn?.addEventListener('click', ()=> go(-1));
    track.addEventListener('click', (e)=>{ const slide=e.target.closest('.slide'); if(!slide) return; const i=all.indexOf(slide); if(i>-1) go(i-idx); });
    dots.forEach((d,i)=> d.addEventListener('click', ()=> { const target=i+1; if(target!==idx) go(target-idx); }));
    track.addEventListener('transitionend', handleEdgeSnap);

    function startAuto(){ timer=setInterval(()=> go(1), 3500); }
    function stopAuto(){ clearInterval(timer); timer=null; }
    startAuto(); wrap.addEventListener('mouseenter', stopAuto); wrap.addEventListener('mouseleave', ()=> { if(!timer) startAuto(); });
    document.addEventListener('visibilitychange', ()=>{ if(document.hidden) stopAuto(); else { measure(); startAuto(); } });
    window.addEventListener('resize', ()=> requestAnimationFrame(measure));
    Array.from(track.querySelectorAll('img')).forEach(img=>{ if(img.complete) return; img.addEventListener('load', ()=> requestAnimationFrame(measure), {once:true}); });
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
