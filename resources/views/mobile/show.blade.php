{{-- resources/views/mobile/show.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>{{ $mobile->FullName ?? $mobile->Model }} | SmartSpec</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">

  <style>
    :root{
      --ink:#0f2342;--muted:#6b7b93;--bg:#f4f6fb;--card:#fff;--line:#eef2f7;
      --shadow:0 6px 18px rgba(15,35,66,.08);--radius:16px;
      --brand:#0f2342;--chip:#0f2342;
    }
    *{box-sizing:border-box}
    body{margin:0;background:var(--bg);color:var(--ink);font-family:system-ui,-apple-system,Segoe UI,Roboto,Inter,Arial,sans-serif}
    a{color:var(--ink)}
    .page{max-width:1180px;margin:20px auto;padding:0 16px}
    .crumb{color:var(--muted);margin:8px 0 16px;font-size:.95rem}
    .crumb a{text-decoration:none}
    .crumb a:hover{text-decoration:underline}

    /* Header grid: left image / right summary */
    .head{display:grid;grid-template-columns:420px 1fr;gap:24px}
    @media(max-width:980px){.head{grid-template-columns:1fr}}

    .card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow)}
    .card .bd{padding:18px 20px}

    .hero{aspect-ratio:1/1;background:#fff;border-radius:14px;display:flex;align-items:center;justify-content:center;overflow:hidden}
    .hero img{max-width:100%;max-height:100%;object-fit:contain;transition:transform .25s ease}
    .hero:hover img{transform:scale(1.03)}

    /* thumbs */
    .thumbs-wrap{position:relative;margin-top:12px}
    .thumbs-viewport{overflow:hidden;width:350px;margin:0 auto}
    .thumbs-track{display:flex;gap:10px;transition:transform .35s ease}
    .thumbs-item{width:80px;height:80px;object-fit:cover;border-radius:12px;border:2px solid transparent;box-shadow:0 2px 6px rgba(0,0,0,.08);cursor:pointer;background:#fff}
    .thumbs-item:hover{transform:translateY(-2px)}
    .thumbs-item.is-active{border-color:var(--brand);box-shadow:0 0 0 2px var(--brand) inset}
    .t-nav{position:absolute;top:50%;transform:translateY(-50%);width:36px;height:36px;border-radius:999px;border:0;background:#fff;color:var(--brand);font-weight:700;font-size:18px;box-shadow:0 6px 16px rgba(0,0,0,.15);cursor:pointer}
    .t-nav[disabled]{opacity:.4;cursor:not-allowed}
    .t-prev{left:-10px}.t-next{right:-10px}
    .t-fade{position:absolute;top:0;bottom:0;width:26px;pointer-events:none}
    .t-left{left:0;background:linear-gradient(90deg,#fff,rgba(255,255,255,0))}
    .t-right{right:0;background:linear-gradient(270deg,#fff,rgba(255,255,255,0))}

    .title{margin:0;font-size:1.75rem;line-height:1.25}
    .meta{color:var(--muted);margin-top:6px}
    .chip{display:inline-block;background:var(--chip);color:#fff;border-radius:999px;padding:2px 10px;font-size:.78rem;margin-left:8px}

    /* highlight grid */
    .kpis{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}
    @media(max-width:520px){.kpis{grid-template-columns:1fr}}
    .kpis div{background:#f8fbff;border:1px solid var(--line);padding:10px 12px;border-radius:12px}
    .kpis b{font-weight:700}

    /* spec sections 2-column balanced */
    .spec-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:18px}
    @media(max-width:920px){.spec-grid{grid-template-columns:1fr}}
    .sec{border-radius:16px;background:#fff;box-shadow:var(--shadow)}
    .sec h3{margin:0;padding:12px 16px;border-bottom:1px solid var(--line);font-size:1.05rem}
    .spec{width:100%;border-collapse:collapse}
    .spec th,.spec td{padding:10px 14px;border-bottom:1px solid #f1f5fa;vertical-align:top}
    .spec th{width:36%;font-weight:600;color:#385072;background:#fbfdff}
    .spec tr:last-child th,.spec tr:last-child td{border-bottom:0}
  </style>
</head>
<body>
  @include('layouts.navbar')

  <div class="page">

    <div class="crumb">
      <a href="{{ route('home') }}">หน้าแรก</a> ·
      <a href="{{ route('home') }}">มือถือ</a> ·
      <span>{{ $mobile->Model }}</span>
    </div>

    @php
      // helpers
      $yn = function($v){
        if ($v === null) return '-';
        $s = is_bool($v) ? ($v ? '1' : '0') : trim((string)$v);
        if ($s === '') return '-';
        $s = strtolower($s);
        if (in_array($s, ['1','true','yes','y'])) return 'มี';
        if (in_array($s, ['0','false','no','n']))  return 'ไม่มี';
        return ucfirst($s); // ถ้าเป็นคำอธิบายอื่นให้แสดงตามนั้น
      };
      $val  = fn($v,$suf='') => (isset($v) && $v!=='') ? (is_numeric($v)?rtrim(rtrim((string)$v),'.'):$v).$suf : '-';
      $date = fn($d)=> empty($d) ? '-' : \Illuminate\Support\Carbon::parse($d)->format('d M Y');

      // map sections -> fields
      $sections = [
        'ข้อมูลทั่วไป' => [
          'แบรนด์' => $mobile->brand->Brand ?? '-',
          'รุ่น (Model)' => $val($mobile->Model),
          'ชื่อเต็ม' => $val($mobile->FullName),
          'ซีรีส์' => $val($mobile->Series),
          'รุ่นย่อย' => $val($mobile->Variant),
          'สีที่มี' => $val($mobile->ColorOptions),
          'ขนาดตัวเครื่อง' => $val($mobile->Dimensions),
          'น้ำหนัก' => $val($mobile->Weight_g,' กรัม'),
          'วัสดุ' => $val($mobile->Material),
          'กันน้ำ/ฝุ่น (IP)' => $val($mobile->IP_Rating),
          'วันเปิดตัว' => $date($mobile->LaunchDate),
          'สถานะจำหน่าย' => $val($mobile->Availability),
          'ราคาเปิดตัว' => ($mobile->LaunchPrice!==null? number_format($mobile->LaunchPrice).' '.($mobile->Currency ?? 'THB') : '-'),
          'ราคาปัจจุบัน' => ($mobile->Price!==null? number_format($mobile->Price).' '.($mobile->Currency ?? 'THB') : '-'),
        ],
        'จอภาพ (Display)' => [
          'ขนาด' => $val($mobile->ScreenSize_in,'"'),
          'ข้อมูลจอ' => $val($mobile->Display),
          'ชนิดจอ' => $val($mobile->Display_Type),
          'ความละเอียด' => $val($mobile->Display_Resolution),
          'รีเฟรชเรต' => $val($mobile->Display_RefreshRate,' Hz'),
          'ความสว่างสูงสุด' => $val($mobile->Display_Brightness,' nits'),
          'กระจก/การป้องกัน' => $val($mobile->Display_Protection),
        ],
        'ประสิทธิภาพ (Performance)' => [
          'ชิป/CPU' => $val($mobile->Processor),
          'GPU' => $val($mobile->GPU),
          'RAM' => $val($mobile->RAM_GB,' GB'),
          'ชนิด RAM' => $val($mobile->RAM_Type),
          'ความจุ' => $val($mobile->Storage_GB,' GB'),
          'ชนิดสตอเรจ' => $val($mobile->Storage_Type),
          'รองรับ microSD' => $yn($mobile->Expandable),
        ],
        'กล้อง (Camera)' => [
          'กล้องหลัง' => $val($mobile->BackCamera),
          'ฟีเจอร์กล้องหลัง' => $val($mobile->RearCamera_Features),
          'กล้องหน้า' => $val($mobile->FrontCamera),
          'ฟีเจอร์กล้องหน้า' => $val($mobile->FrontCamera_Features),
          'วิดีโอสูงสุด' => $val($mobile->Video_Recording),
        ],
        'แบตเตอรี่และชาร์จ' => [
          'ความจุ' => $val($mobile->Battery_mAh,' mAh'),
          'ชนิดแบต' => $val($mobile->Battery_Type),
          'ชาร์จไว (สาย)' => $val($mobile->Charging_Wired_Watt,' W'),
          'ชาร์จไว (ไร้สาย)' => $val($mobile->Charging_Wireless_Watt,' W'),
          'ชาร์จย้อนกลับ' => $val($mobile->Charging_Reverse_Watt,' W'),
        ],
        'เครือข่ายและการเชื่อมต่อ' => [
          'เครือข่าย' => $val($mobile->Network),
          'Wi-Fi' => $val($mobile->Wifi_Std),
          'Bluetooth' => $val($mobile->Bluetooth),
          'NFC' => $yn($mobile->NFC),
          'GPS' => $yn($mobile->GPS),
          'Infrared' => $yn($mobile->Infrared),
          'USB' => $val($mobile->USB_Type),
          'ชนิดซิม' => $val($mobile->Sim_Type),
          'eSIM' => $yn($mobile->eSIM),
          'ช่องหูฟัง 3.5 มม.' => $yn($mobile->Jack35),
        ],
        'ระบบเสียง' => [
          'ลำโพงสเตอริโอ' => $yn($mobile->Stereo_Speakers),
          'Dolby Atmos' => $yn($mobile->Dolby_Atmos),
        ],
        'ความปลอดภัย/เซนเซอร์' => [
          'สแกนนิ้ว' => $val($mobile->Fingerprint_Type),
          'ปลดล็อกใบหน้า' => $yn($mobile->Face_Unlock),
          'เซนเซอร์อื่นๆ' => $val($mobile->Sensors),
        ],
        'ระบบปฏิบัติการและอัปเดต' => [
          'ระบบปฏิบัติการ' => $val($mobile->OS),
          'สกิน/อินเตอร์เฟซ' => $val($mobile->UI_Skin),
          'เวอร์ชัน' => $val($mobile->OS_Version),
          'การันตีอัปเดต' => $val($mobile->OS_Updates_Years,' ปี'),
        ],
        'ฟีเจอร์อื่น ๆ' => [
          'ฟีเจอร์เพิ่มเติม' => $val($mobile->Features),
        ],
      ];
    @endphp

    <div class="head">
      {{-- ซ้าย: รูปหลัก + แถวรูป --}}
      <div class="card">
        <div class="bd" style="text-align:center">
          @php
            $imgPath = $mobile->coverImage?->Img ?? $mobile->images->first()?->Img ?? null;
            $imgUrl  = $imgPath ? asset('storage/'.$imgPath) : asset('images/default.jpg');
          @endphp
          <div class="hero" id="mainImageWrap">
            <img id="mainImage" src="{{ $imgUrl }}" alt="{{ $mobile->Model }}" loading="lazy">
          </div>

          @if($mobile->images && $mobile->images->count() > 0)
            @php $thumbs = $mobile->images; @endphp
            <div class="thumbs-wrap" data-per-page="4" aria-label="แกลเลอรีรูปตัวเครื่อง">
              <button class="t-nav t-prev" type="button" aria-label="ก่อนหน้า" disabled>‹</button>

              <div class="thumbs-viewport">
                <div class="thumbs-track" id="thumbTrack">
                  @foreach($thumbs as $img)
                    <img
                      src="{{ asset('storage/'.$img->Img) }}"
                      alt="รูปตัวเครื่อง"
                      class="thumbs-item"
                      loading="lazy"
                    >
                  @endforeach
                </div>
              </div>

              <button class="t-nav t-next" type="button" aria-label="ถัดไป">›</button>
              <div class="t-fade t-left" style="display:none"></div>
              <div class="t-fade t-right" style="{{ $thumbs->count() > 4 ? '' : 'display:none' }}"></div>
            </div>
          @endif
        </div>
      </div>

      {{-- ขวา: ชื่อ + ไฮไลต์หลัก --}}
      <div>
        <h1 class="title">{{ $mobile->FullName ?? $mobile->Model }}</h1>
        <div class="meta">
          แบรนด์: <strong>{{ $mobile->brand->Brand ?? '-' }}</strong>
          @if(!empty($mobile->OS)) <span class="chip">{{ $mobile->OS }}</span> @endif
        </div>

        <div class="card" style="margin-top:12px">
          <div class="bd">
            <div class="kpis">
              <div>ชิป: <b>{{ $mobile->Processor ?? '-' }}</b></div>
              <div>RAM/ROM: <b>{{ $mobile->RAM_GB ?? '-' }}GB / {{ $mobile->Storage_GB ?? '-' }}GB</b></div>
              <div>จอ: <b>{{ $mobile->ScreenSize_in ?? '-' }}″ {{ $mobile->Display_Type ?? $mobile->Display ?? '' }}</b></div>
              <div>แบตฯ: <b>{{ $mobile->Battery_mAh ? number_format($mobile->Battery_mAh).' mAh' : '-' }}</b></div>
              <div>กล้องหลัง: <b>{{ $mobile->BackCamera ?? '-' }}</b></div>
              <div>ราคา: <b>{{ $mobile->Price!==null ? number_format($mobile->Price).' '.($mobile->Currency ?? 'THB') : '-' }}</b></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- สเปกเต็ม: การ์ด 2 คอลัมน์ บาลานซ์ --}}
    <div class="spec-grid">
      @foreach($sections as $title => $pairs)
        @php $hasAny = collect($pairs)->contains(fn($v)=> $v !== '-'); @endphp
        @if($hasAny)
          <section class="sec" aria-label="{{ $title }}">
            <h3>{{ $title }}</h3>
            <table class="spec">
              <tbody>
                @foreach($pairs as $label => $value)
                  @if($value !== '-')
                    <tr>
                      <th>{{ $label }}</th>
                      <td>{{ $value }}</td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </section>
        @endif
      @endforeach
    </div>

    @include('components.comments', ['model' => $mobile, 'type' => 'mobile'])
  </div>

  <script>
    // สลับรูปหลักเมื่อคลิกรูปย่อย
    (function(){
      const mainImg = document.getElementById('mainImage');
      const track = document.getElementById('thumbTrack');
      if(!mainImg || !track) return;
      const thumbs = Array.from(track.querySelectorAll('.thumbs-item'));
      if(!thumbs.length) return;
      let current = 0; thumbs[0].classList.add('is-active');
      thumbs.forEach((t,i)=>t.addEventListener('click',()=>{
        thumbs.forEach(x=>x.classList.remove('is-active'));
        t.classList.add('is-active'); current=i; mainImg.src=t.src;
      }));
    })();

    // เลื่อนรูปย่อยทีละหน้า (4 รูป)
    (function(){
      const wrap = document.querySelector('.thumbs-wrap');
      if(!wrap) return;
      let perPage = parseInt(wrap.dataset.perPage||'4',10);
      const viewport = wrap.querySelector('.thumbs-viewport');
      const track = wrap.querySelector('.thumbs-track');
      const prevBtn = wrap.querySelector('.t-prev');
      const nextBtn = wrap.querySelector('.t-next');
      const fadeL = wrap.querySelector('.t-left');
      const fadeR = wrap.querySelector('.t-right');
      const items = Array.from(track.querySelectorAll('.thumbs-item'));
      const gap=10, w=80;
      let page=0, pages=Math.max(1, Math.ceil(items.length/perPage));

      function widthFor(n){ return (n*w + (n-1)*gap) + 'px'; }
      function update(){
        const x = -(page * (perPage*w + (perPage-1)*gap));
        track.style.transform = `translateX(${x}px)`;
        prevBtn.disabled = (page===0);
        nextBtn.disabled = (page>=pages-1);
        fadeL.style.display = page>0 ? '' : 'none';
        fadeR.style.display = page<pages-1 ? '' : 'none';
      }
      prevBtn.addEventListener('click',()=>{ if(page>0){page--;update();}});
      nextBtn.addEventListener('click',()=>{ if(page<pages-1){page++;update();}});

      // responsive: จอเล็กลดเหลือ 3 รูป/หน้า
      const mq = window.matchMedia('(max-width: 420px)');
      function onResize(){
        perPage = mq.matches ? 3 : parseInt(wrap.dataset.perPage||'4',10);
        pages = Math.max(1, Math.ceil(items.length/perPage));
        viewport.style.width = widthFor(perPage);
        page = Math.min(page, pages-1);
        update();
      }
      onResize(); window.addEventListener('resize', onResize);
      update();
    })();
  </script>
</body>
</html>
