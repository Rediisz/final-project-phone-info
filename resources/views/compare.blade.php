<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เปรียบเทียบมือถือ | SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <style>
  /* ===== โทนหลัก / Navbar ===== */
  body{background:#f3f6fb;font-family:sans-serif;margin:0;color:#0f2342}
  header{background:#0f2342;color:#fff;display:flex;justify-content:space-between;align-items:center;padding:12px 24px}
  header h1{margin:0;font-size:1.6rem}
  header nav a{color:#fff;margin-left:14px;text-decoration:none}
  header nav a:hover{text-decoration:underline}

  /* ===== Banner ===== */
  .banner-wrap{background:#2f3236;position:relative;padding:22px 64px 30px}
  .banner-empty{background:#2f3236;min-height:260px}
  .carousel{max-width:min(1280px,100%);margin:0 auto;overflow:hidden;position:relative}
  .carousel::before,.carousel::after{content:"";position:absolute;top:0;bottom:0;width:80px;z-index:2;pointer-events:none}
  .carousel::before{left:0;background:linear-gradient(90deg,rgba(47,50,54,1),rgba(47,50,54,0))}
  .carousel::after {right:0;background:linear-gradient(-90deg,rgba(47,50,54,1),rgba(47,50,54,0))}
  .track{display:flex;align-items:center;gap:48px;will-change:transform;transition:transform .5s ease;padding:10px 4px}
  .slide{flex:0 0 auto;width:clamp(260px,26vw,420px);aspect-ratio:16/9;border-radius:18px;background:#1f2124;overflow:hidden;box-shadow:0 14px 32px rgba(0,0,0,.35);transform:scale(.88);opacity:.7;transition:transform .35s ease,opacity .35s ease;cursor:pointer}
  .slide.is-active{transform:scale(1);opacity:1}
  .slide img{width:100%;height:100%;object-fit:cover;background:#1f2124}
  .nav{position:absolute;top:50%;transform:translateY(-50%);width:40px;height:40px;border-radius:999px;border:none;background:#fff;color:#0f2342;font-size:22px;font-weight:700;display:grid;place-items:center;cursor:pointer;z-index:3;box-shadow:0 6px 16px rgba(0,0,0,.3)}
  .nav.prev{left:16px}.nav.next{right:16px}
  .nav:hover{filter:brightness(.95)}
  .dots{display:flex;gap:10px;justify-content:center;margin-top:14px}
  .dot{width:8px;height:8px;border-radius:999px;border:none;cursor:pointer;background:#9da3af;opacity:.75}
  .dot.is-active{width:24px;background:#fff;opacity:1}

  /* ===== เปรียบเทียบ 3 ช่อง ===== */
  .wrap{padding:16px}
  .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
  .slot{position:relative;background:#fff;border-radius:12px;box-shadow:0 4px 12px rgba(15,35,66,.08);padding:16px;min-height:420px}
  .slot .head{font-weight:700;margin-bottom:8px}
  .slot img{max-width:160px;display:block;margin:8px auto}
  .spec{font-size:13px;color:#333;margin:4px 0;text-align:center}
  .placeholder{height:260px;display:flex;align-items:center;justify-content:center;color:#888;border:1px dashed #e5e7eb;border-radius:10px}

  /* ===== Search Autocomplete ===== */
  .searchbox{position:relative}
  .searchbox input{width:100%;padding:10px 12px;border:1px solid #d1d5db;border-radius:10px;box-sizing:border-box;}
  .dropdown{position:absolute;left:0;right:0;top:42px;background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.12);z-index:20;max-height:360px;overflow:auto;display:none}
  .dropdown.open{display:block}
  .group-hd{font-size:12px;color:#6b7280;padding:8px 12px;border-bottom:1px solid #f1f5f9}
  .item{display:flex;gap:10px;align-items:center;padding:10px 12px;cursor:pointer}
  .item:hover{background:#f9fafb}
  .item img{width:46px;height:46px;object-fit:cover;border-radius:8px;background:#f3f4f6}
  .item .n{font-size:14px;color:#0f2342}
  .item .b{font-size:12px;color:#64748b}
  
  /* --- รายการสเปกในช่องเปรียบเทียบ --- */
  .specs-list{margin:10px auto 0; padding-left:18px; max-width:520px; text-align:left; line-height:1.6}
  .specs-list li{margin:2px 0; font-size:13px; color:#0f2342}
  .specs-list .muted{color:#6b7280}
    @media (max-width:960px){
      .grid{grid-template-columns:1fr}
    }
  </style>
</head>
<body style="margin:0;background:#f3f6fb;font-family:sans-serif;">
  @include('layouts.navbar')

{{-- Banner --}}
@php $banners = ($banners ?? collect()); @endphp
@if($banners->count())
  <div class="banner-wrap">
    <button class="nav prev" type="button" aria-label="prev">‹</button>
    <div class="carousel"><div class="track">
      @foreach($banners as $b)
        <a class="slide" href="#"><img src="{{ $b->image_url }}" alt="Banner"></a>
      @endforeach
    </div></div>
    <button class="nav next" type="button" aria-label="next">›</button>
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
  <h2 style="margin:0 0 10px">📊 เปรียบเทียบมือถือ</h2>

  <div class="grid" id="cmpGrid" data-url="{{ route('compare') }}">
    @foreach([1,2,3] as $slot)
      <div class="slot" data-slot="{{ $slot }}">
        <div class="head">COMPARE WITH</div>

        {{-- Search box + dropdown --}}
        <div class="searchbox">
          <input type="text" placeholder="Search" class="q">
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
            <li>ชิป/โปรเซสเซอร์: {{ $m->Processor ?: '—' }}</li>
            <li>RAM: {{ $m->RAM_GB ?: '—' }} <span class="muted">GB</span></li>
            <li>หน่วยความจำ (แสดงถ้ามี): {{ $m->Storage_GB ?: '—' }} <span class="muted">GB</span></li>
            <li>หน้าจอ: {{ $m->ScreenSize_in ?: '—' }}″ {{ $m->Display ?? '' }}</li>
            <li>กล้องหน้า: {{ $m->FrontCamera ?: '—' }} MP</li>
            <li>กล้องหลัง: {{ $m->BackCamera ?: '—' }} MP</li>
            <li>แบตเตอรี่: {{ $m->Battery_mAh ?: '—' }} <span class="muted">mAh</span></li>
            <li>รองรับ: {{ $net ?: '—' }}</li>
            @if($launch)
              <li>วันที่เปิดตัว: {{ $launch }}</li>
            @endif
          </ul>
        @else
          <div class="placeholder">เลือกโทรศัพท์มือถือเพื่อเปรียบเทียบ</div>
        @endif
      </div>
    @endforeach
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
