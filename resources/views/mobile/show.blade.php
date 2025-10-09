<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>{{ $mobile->Model }} | SmartSpec</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">

  <style>
  body{background:#f3f6fb;font-family:sans-serif;margin:0;color:#0f2342}
  header{background:#0f2342;color:#fff;display:flex;justify-content:space-between;align-items:center;padding:12px 24px}
  header h1{margin:0;font-size:1.6rem}
  header nav a{color:#fff;margin-left:14px;text-decoration:none}
  header nav a:hover{text-decoration:underline}

  .wrap{max-width:1100px;margin:24px auto;padding:0 16px}
  .crumb{font-size:.9rem;color:#64748b;margin-bottom:10px}
  .crumb a{color:#0f2342;text-decoration:none}
  .crumb a:hover{text-decoration:underline}

  .grid{display:grid;grid-template-columns:480px 1fr;gap:28px}
  @media (max-width:960px){ .grid{grid-template-columns:1fr} }

  .card{background:#fff;border-radius:16px;box-shadow:0 4px 12px rgba(15,35,66,.08)}
  .card .hd{padding:14px 18px;border-bottom:1px solid #e8eef5;font-weight:700}
  .card .bd{padding:18px 20px}

  /* ==== รูปหลัก ==== */
  .hero{aspect-ratio:1/1;display:flex;align-items:center;justify-content:center;background:#ffff;border-radius:14px;overflow:hidden;cursor:pointer;transition:transform .2s}
  .hero img{max-width:100%;max-height:100%;object-fit:contain;transition:transform .25s ease}
  .hero:hover img{transform:scale(1.05)}

  /* ==== แถวรูปย่อย ==== */
  .thumbs{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px;justify-content:center}
  .thumbs img{
    width:80px;height:80px;object-fit:cover;border-radius:12px;
    box-shadow:0 2px 6px rgba(0,0,0,.08);cursor:pointer;
    border:2px solid transparent;transition:transform .2s, border .2s;
  }
  .thumbs img:hover{transform:translateY(-3px);border-color:#0f2342}
  .thumbs img.is-active{border-color:#0f2342;box-shadow:0 0 0 2px #0f2342 inset;}
    /* ==== แถวรูปย่อยแบบ 4 ต่อหน้า + ปุ่มเลื่อน ==== */
  .thumbs-wrap{position:relative;margin-top:14px}
  .thumbs-viewport{
    overflow:hidden;
    /* กว้างพอดี 4 ช่อง: 4*80 + 3*10 = 350px (เผื่อ responsive ใช้ max-content ด้วย) */
    width:350px; margin:0 auto;
  }
  .thumbs-track{
    display:flex; gap:10px;
    will-change:transform; transition:transform .35s ease;
  }
  .thumbs-item{
    width:80px; height:80px; flex:0 0 auto;
    border-radius:12px; object-fit:cover; cursor:pointer;
    border:2px solid transparent; box-shadow:0 2px 6px rgba(0,0,0,.08);
    transition:transform .2s, border .2s;
    background:#fff;
  }
    /* กรอบรูปที่ถูกเลือก */
    .thumbs-item.is-active{
    border-color:#0f2342;
    box-shadow:0 0 0 2px #0f2342 inset;
    }
  .t-nav{
    position:absolute; top:50%; transform:translateY(-50%);
    width:36px; height:36px; border-radius:999px; border:0;
    background:#fff; color:#0f2342; font-weight:700; font-size:18px;
    box-shadow:0 6px 16px rgba(0,0,0,.15); cursor:pointer;
  }
  .t-nav[disabled]{opacity:.4; cursor:not-allowed}
  .t-prev{left:-10px} .t-next{right:-10px}

  /* เฟดโชว์ว่ามีรูปต่อ */
  .t-fade{position:absolute; top:0; bottom:0; width:26px; pointer-events:none}
  .t-left{left:0; background:linear-gradient(90deg,#fff,rgba(255,255,255,0))}
  .t-right{right:0; background:linear-gradient(270deg,#fff,rgba(255,255,255,0))}
  .title{margin:0 0 4px 0;font-size:1.6rem}
  .meta{color:#64748b;margin-bottom:14px}

  .specs{line-height:1.9;margin:0;padding-left:18px}
  .specs li{margin:2px 0}

  .pill{display:inline-block;background:#0f2342;color:#fff;border-radius:999px;padding:2px 10px;font-size:.78rem;font-weight:700}
  </style>
</head>
<body>
  @include('layouts.navbar')

  <div class="wrap">

    <div class="crumb">
      <a href="{{ route('home') }}">หน้าแรก</a> ·
      <a href="{{ route('home') }}">มือถือ</a> ·
      <span>{{ $mobile->Model }}</span>
    </div>

    <div class="grid">
      {{-- ซ้าย: รูป --}}
      <div class="card">
        <div class="bd" style="text-align:center">
          @php
            $imgPath = $mobile->coverImage?->Img ?? $mobile->images->first()?->Img ?? null;
            $imgUrl  = $imgPath ? asset('storage/'.$imgPath) : asset('images/default.jpg');
          @endphp
          <div class="hero" id="mainImageWrap">
            <img id="mainImage" src="{{ $imgUrl }}" alt="{{ $mobile->Model }}">
          </div>

          @if($mobile->images && $mobile->images->count() > 0)
            @php $thumbs = $mobile->images; @endphp
            <div class="thumbs-wrap" data-per-page="4">
                <button class="t-nav t-prev" type="button" aria-label="prev" disabled>‹</button>

                <div class="thumbs-viewport">
                <div class="thumbs-track" id="thumbTrack">
                    @foreach($thumbs as $img)
                    <img
                        src="{{ asset('storage/'.$img->Img) }}"
                        alt="thumb"
                        class="thumbs-item"
                    >
                    @endforeach
                </div>
                </div>

                <button class="t-nav t-next" type="button" aria-label="next">›</button>

                {{-- เฟดซ้าย/ขวา บอกว่ามีรูปต่อ --}}
                <div class="t-fade t-left"  style="display:none"></div>
                <div class="t-fade t-right" style="{{ $thumbs->count() > 4 ? '' : 'display:none' }}"></div>
            </div>
            @endif
        </div>
      </div>

      {{-- ขวา: ข้อมูล --}}
      <div>
        <h1 class="title">{{ $mobile->Model }}</h1>
        <div class="meta">
          แบรนด์: <strong>{{ $mobile->brand->Brand ?? '-' }}</strong>
          @if(!empty($mobile->OS))
            &nbsp;·&nbsp;<span class="pill">{{ $mobile->OS }}</span>
          @endif
        </div>

        <div class="card">
          <div class="hd">สเปกหลัก</div>
          <div class="bd">
            <ul class="specs">
              <li>ชิป/โปรเซสเซอร์: {{ $mobile->Processor ?? '-' }}</li>
              <li>RAM: {{ $mobile->RAM_GB ?? '-' }} GB</li>
              <li>หน่วยความจำ (แสดงถ้ามี): {{ $mobile->Storage_GB ?? '-' }} GB</li>
              <li>หน้าจอ: {{ $mobile->ScreenSize_in ?? '-' }}″  {{ $mobile->Display ?? '' }}</li>
              <li>กล้องหน้า: {{ $mobile->FrontCamera ?? '-' }} MP</li>
              <li>กล้องหลัง: {{ $mobile->BackCamera ?? '-' }} MP</li>
              <li>แบตเตอรี่: {{ $mobile->Battery_mAh ?? '-' }} mAh</li>
              <li>รองรับ: {{ $mobile->Network ?? '-' }}</li>
              @if(!empty($mobile->LaunchDate))
                <li>วันที่เปิดตัว: {{ \Illuminate\Support\Carbon::parse($mobile->LaunchDate)->format('d M Y') }}</li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>
    @include('components.comments', ['model' => $mobile, 'type' => 'mobile'])
  </div>


  <script>
  /* ===== เปลี่ยนภาพหลักเมื่อคลิกรูปย่อย + แสดงกรอบ active ===== */
(function(){
  const mainImg = document.getElementById('mainImage');
  const track   = document.getElementById('thumbTrack');
  if(!mainImg || !track) return;

  const thumbs = Array.from(track.querySelectorAll('.thumbs-item'));
  if(!thumbs.length) return;

  // ให้รูปแรกเป็น active
  let currentIndex = 0;
  thumbs[currentIndex].classList.add('is-active');

  thumbs.forEach((t, i) => {
    t.addEventListener('click', () => {
      thumbs.forEach(x => x.classList.remove('is-active'));
      t.classList.add('is-active');
      currentIndex = i;
      mainImg.src = t.src;
    });
  });
})();

/* ===== ระบบเลื่อนแถวรูปย่อยทีละหน้า (4 รูป) ===== */
(function(){
  const wrap = document.querySelector('.thumbs-wrap');
  if(!wrap) return;

  const perPage  = parseInt(wrap.dataset.perPage || '4', 10);
  const viewport = wrap.querySelector('.thumbs-viewport');
  const track    = wrap.querySelector('.thumbs-track');
  const prevBtn  = wrap.querySelector('.t-prev');
  const nextBtn  = wrap.querySelector('.t-next');
  const fadeL    = wrap.querySelector('.t-left');
  const fadeR    = wrap.querySelector('.t-right');
  const items    = Array.from(track.querySelectorAll('.thumbs-item'));

  const gap = 10, w = 80;
  let page = 0;
  const pages = Math.max(1, Math.ceil(items.length / perPage));

  function update(){
    const x = -(page * (perPage * w + (perPage - 1) * gap));
    track.style.transform = `translateX(${x}px)`;
    prevBtn.disabled = (page === 0);
    nextBtn.disabled = (page >= pages - 1);
    fadeL.style.display = page > 0 ? '' : 'none';
    fadeR.style.display = page < pages - 1 ? '' : 'none';
  }

  prevBtn.addEventListener('click', () => { if(page > 0){ page--; update(); } });
  nextBtn.addEventListener('click', () => { if(page < pages - 1){ page++; update(); } });

  // รองรับจอเล็ก: ลดเหลือ 3 รูป/หน้าอัตโนมัติ
  const mq = window.matchMedia('(max-width: 420px)');
  function resizeBehavior(){
    const dynamicPer = mq.matches ? 3 : perPage;
    viewport.style.width = (dynamicPer*w + (dynamicPer-1)*gap) + 'px';
    update();
  }
  resizeBehavior();
  window.addEventListener('resize', resizeBehavior);

  update();
})();
  </script>
</body>
</html>
