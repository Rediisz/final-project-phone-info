<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>SmartSpec</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">

  <style>
  /* ===== โทนหลัก ===== */
  body{background:#f3f6fb;font-family:sans-serif;margin:0;color:#0f2342}

  header{background:#0f2342;color:#fff;display:flex;justify-content:space-between;align-items:center;padding:12px 24px}
  header h1{margin:0;font-size:1.6rem}
  header nav a{color:#fff;margin-left:14px;text-decoration:none}
  header nav a:hover{text-decoration:underline}

  /* ===== แบนเนอร์ (center-mode + infinite แบบไม่ย้อนกลับ) ===== */
  .banner-wrap{background:#2f3236;position:relative;padding:22px 64px 30px}
  .banner-empty{background:#2f3236;min-height:260px}

  .carousel{
    max-width:min(1280px,100%);
    margin:0 auto;
    overflow:hidden;                 /* ซ่อนแค่กรอบนอก */
    position:relative;
  }

  /* เพิ่มเงาจาง ๆ ขอบซ้าย/ขวาให้ดูเนียน */
  .carousel::before,
  .carousel::after{
    content:"";position:absolute;top:0;bottom:0;width:80px;z-index:2;pointer-events:none
  }
  .carousel::before{left:0;background:linear-gradient(90deg,rgba(47,50,54,1),rgba(47,50,54,0))}
  .carousel::after {right:0;background:linear-gradient(-90deg,rgba(47,50,54,1),rgba(47,50,54,0))}

  .track{
    display:flex;align-items:center;
    gap:48px;                        /* ← ระยะห่างสไลด์ (ต้องตรงกับ JS) */
    will-change:transform;
    transition:transform .5s ease;   /* นุ่มขึ้นกว่าก่อนหน้า */
    padding:10px 4px;
  }

  .slide{
    flex:0 0 auto;
    width:clamp(260px, 26vw, 420px); /* ขนาดให้เห็นประมาณ 3 ใบ + เผื่อซ้ายขวา */
    aspect-ratio:16/9;
    border-radius:18px;
    background:#1f2124;
    overflow:hidden;
    box-shadow:0 14px 32px rgba(0,0,0,.35);
    transform:scale(.88);            /* ซ้าย/ขวาเล็กลง */
    opacity:.7;
    transition:transform .35s ease, opacity .35s ease;
    cursor:pointer;
  }
  .slide.is-active{transform:scale(1);opacity:1}

  .slide img{
    width:100%;height:100%;
    object-fit:cover;                /* ฟีลโปสเตอร์แบบตัวอย่าง */
    background:#1f2124;
  }

  .nav{
    position:absolute;top:50%;transform:translateY(-50%);
    width:40px;height:40px;border-radius:999px;border:none;
    background:#fff;color:#0f2342;font-size:22px;font-weight:700;
    display:grid;place-items:center;cursor:pointer;z-index:3;
    box-shadow:0 6px 16px rgba(0,0,0,.3)
  }
  .nav.prev{left:16px} .nav.next{right:16px}
  .nav:hover{filter:brightness(.95)}

  .dots{display:flex;gap:10px;justify-content:center;margin-top:14px}
  .dot{
    width:8px;height:8px;border-radius:999px;border:none;cursor:pointer;background:#9da3af;opacity:.75
  }
  .dot.is-active{width:24px;background:#fff;opacity:1}

  /* ===== เนื้อหาหลังแบนเนอร์ ===== */
  .layout{display:grid;grid-template-columns:220px 1fr;gap:16px;padding:16px}
  .sidebar h3{margin-top:0}
  .brand-list{list-style:none;margin:0;padding:0}
  .brand-list li{margin:4px 0}
  .brand-list a{color:#0f2342;text-decoration:none}
  .brand-list a:hover{text-decoration:underline}

  .search-box{background:#fff;padding:12px;border-radius:12px;box-shadow:0 4px 12px rgba(15,35,66,.08);margin-bottom:16px}
  .mobile-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px;padding:20px 0}
  .mobile-card{background:#fff;border-radius:12px;box-shadow:0 4px 12px rgba(15,35,66,.08);text-align:center;padding:10px;min-height:200px;transition:transform .15s}
  .mobile-card:hover{transform:translateY(-2px)}
  .mobile-card img{max-width:100%;height:160px;object-fit:contain;margin-bottom:8px}
  .mobile-card h3{font-size:14px;margin:0}
  .mobile-card.placeholder{background:#e6e9ef}
  </style>
</head>
<body>
  <header>
    <h1>SmartSpec</h1>
    <nav>
      <a href="{{route('home')}}">หน้าแรก</a>
      <a href="{{route('news')}}">ข่าว</a>
      <a href="#">เปรียบเทียบ</a>
      <a href="{{ url('/login') }}">Login</a>
      <a href="{{ url('/signup') }}">Sign Up</a>
    </nav>
  </header>

  @php
    // รองรับชื่อทั้ง $banners และ $banner
    $banners = ($banners ?? $banner ?? collect());
  @endphp

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
          <li><a href="{{ url('/brand?id='.$b->ID) }}">{{ $b->Brand }}</a></li>
        @endforeach
      </ul>
    </aside>

    <main class="content">
        {{-- กล่องค้นหา (จะเปลี่ยน action เป็น /news หรือคงเดิมก็ได้) --}}
        <div class="search-box">
            <form method="GET" action="{{ url('/news') }}">
            <input type="text" name="q" placeholder="ค้นหาข่าว...">
            <button type="submit">ค้นหา</button>
            </form>
        </div>

        <style>
            /* สไตล์ลิสต์ข่าว */
            .news-list{display:flex;flex-direction:column;gap:18px}
            .news-item{display:grid;grid-template-columns:160px 1fr;gap:14px;
            background:#fff;border-radius:12px;box-shadow:0 4px 12px rgba(15,35,66,.08);padding:12px}
            .news-thumb{width:160px;height:120px;border-radius:10px;overflow:hidden;background:#e9eef5}
            .news-thumb img{width:100%;height:100%;object-fit:cover;display:block}
            .news-title{margin:0 0 6px;font-size:18px;line-height:1.35}
            .news-title a{color:#0f2342;text-decoration:none}
            .news-title a:hover{text-decoration:underline}
            .news-intro{color:#465975;margin:0 0 8px}
            .news-meta{font-size:12px;color:#6b7280;display:flex;gap:12px;align-items:center}
            @media (max-width:680px){.news-item{grid-template-columns:1fr}.news-thumb{height:180px;width:100%}}
        </style>

        <div class="news-list">
            @foreach($items as $n)
            @php
                $imgPath = $n->cover?->Img ?? $n->images->first()?->Img ?? null;
                $imgUrl  = $imgPath ? asset('storage/'.$imgPath) : asset('images/default.jpg');
                $intro   = \Illuminate\Support\Str::limit(strip_tags($n->Intro ?: $n->Details), 140);
            @endphp

            <article class="news-item">
                <a class="news-thumb" href="{{ route('news.show', $n->ID) }}">
                <img src="{{ $imgUrl }}" alt="{{ $n->Title }}">
                </a>
                <div>
                <h2 class="news-title">
                    <a href="{{ route('news.show', $n->ID) }}">{{ $n->Title }}</a>
                </h2>
                <p class="news-intro">{{ $intro }}</p>
                <div class="news-meta">
                    <span>{{ optional($n->Date)->format('d M Y H:i') }}</span>
                    @if($n->brand) <span>• {{ $n->brand->Brand }}</span> @endif
                    @if($n->mobile) <span>• {{ $n->mobile->Model }}</span> @endif
                </div>
                </div>
            </article>
            @endforeach
        </div>

        <div style="margin-top:16px">
            {{ $items->onEachSide(1)->links() }}
        </div>
        </main>
  </div>

  <script>
  /* ===== Center-mode Infinite Carousel (เดินหน้าเรื่อย ๆ แล้ววาร์ปเงียบ ๆ) ===== */
  (function(){
    const wrap = document.querySelector('.banner-wrap');
    if(!wrap) return;

    const carousel = wrap.querySelector('.carousel');
    const track    = wrap.querySelector('.track');
    const prevBtn  = wrap.querySelector('.prev');
    const nextBtn  = wrap.querySelector('.next');
    const dots     = Array.from(wrap.querySelectorAll('.dot'));

    const realSlides = Array.from(track.children);

    // ทำ clone หัว/ท้าย เพื่อให้เลื่อนต่อเนื่องแบบไม่ย้อนกลับ
    const head = realSlides[0].cloneNode(true);
    const tail = realSlides[realSlides.length-1].cloneNode(true);
    track.insertBefore(tail, realSlides[0]);
    track.appendChild(head);

    let all   = Array.from(track.children);      // รวม clone แล้ว
    let idx   = 1;                               // เริ่มหลัง tail clone (ตัวจริงสไลด์แรก)
    let gapPx = 48;                              // ต้องตรงกับ CSS .track{gap:48px}
    let itemW = all[idx].offsetWidth;
    let centerOffset = 0;

    function readGap(){
      const g = getComputedStyle(track).gap || getComputedStyle(track)['column-gap'];
      const n = parseFloat(g || '48');
      gapPx = isNaN(n) ? 48 : n;
    }
    function measure(){
      readGap();
      itemW = all[idx].offsetWidth;
      centerOffset = (carousel.clientWidth - itemW)/2;
      setX();
    }
    function setX(){
      // จัดสไลด์ index ปัจจุบันให้อยู่ "ตรงกลาง"
      track.style.transform = `translateX(${centerOffset - idx*(itemW + gapPx)}px)`;
    }

    // เริ่มต้น (ปิด transition ครั้งแรกเพื่อจัดตำแหน่ง)
    track.style.transition = 'none';
    measure();
    requestAnimationFrame(()=>track.style.transition = 'transform .5s ease');

    function setActive(){
      all.forEach(el=>el.classList.remove('is-active'));
      all[idx]?.classList.add('is-active');

      // map indexจริง -> dot
      let real = idx - 1;
      if(real < 0) real = realSlides.length - 1;
      if(real >= realSlides.length) real = 0;
      dots.forEach(d=>d.classList.remove('is-active'));
      dots[real]?.classList.add('is-active');
    }
    setActive();

    function go(step){
      idx += step;             // เดินหน้าหรือถอยหลัง
      track.style.transition = 'transform .5s ease';
      setX();
    }

    nextBtn.addEventListener('click', ()=>go(1));
    prevBtn.addEventListener('click', ()=>go(-1));

    // คลิกสไลด์ไหน ให้เลื่อนมาจัดกลางสไลด์นั้น
    track.addEventListener('click', e=>{
      const slide = e.target.closest('.slide');
      if(!slide) return;
      idx = all.indexOf(slide);
      go(0);
    });

    dots.forEach((d,i)=>d.addEventListener('click', ()=>{
      idx = i + 1; // +1 เพราะด้านหน้ามี tail clone
      go(0);
    }));

    // วาร์ป “หลังจบแอนิเมชัน” เพื่อความเนียน
    track.addEventListener('transitionend', ()=>{
      if(idx === all.length-1){      // ไป head clone (เลยหัว)
        track.style.transition = 'none';
        idx = 1;                     // วาร์ปกลับสไลด์จริงตัวแรกแบบไม่กระพริบ
        setX(); requestAnimationFrame(()=>track.style.transition = 'transform .5s ease');
      }
      if(idx === 0){                 // ไป tail clone (เลยท้าย)
        track.style.transition = 'none';
        idx = realSlides.length;     // วาร์ปไปสไลด์จริงตัวสุดท้าย
        setX(); requestAnimationFrame(()=>track.style.transition = 'transform .5s ease');
      }
      setActive();
    });

    // autoplay (หยุดเมื่อโฮเวอร์)
    let timer = setInterval(()=>go(1), 3500);
    wrap.addEventListener('mouseenter', ()=>clearInterval(timer));
    wrap.addEventListener('mouseleave', ()=>timer = setInterval(()=>go(1), 3500));

    // รีคำนวณเมื่อ resize
    window.addEventListener('resize', ()=>requestAnimationFrame(measure));
  })();
  </script>
</body>
</html>
