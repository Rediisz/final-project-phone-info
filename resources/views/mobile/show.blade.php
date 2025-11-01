{{-- resources/views/mobile/show.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>{{ $mobile->FullName ?? $mobile->Model }} | SmartSpec</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root{
      --ink:#0f2342;
      --muted:#6b7b93;
      --bg:#f4f6fb;
      --card:#fff;
      --line:#eef2f7;
      --shadow:0 6px 18px rgba(15,35,66,.08);
      --radius:16px;
      --brand:#0f2342;
      --chip:#0f2342;
      --accent:#3b82f6;
      --accent-light:#dbeafe;
      --success:#10b981;
      --warning:#f59e0b;
      --row-bg:#fbfdff;
      --gradient:linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    *{box-sizing:border-box}
    body{
      margin:0;
      background:var(--bg);
      color:var(--ink);
      font-family:system-ui,-apple-system,Segoe UI,Roboto,Inter,Arial,sans-serif;
      line-height:1.6;
    }

    /* ===== Navbar: ให้เหมือนทุกหน้า ===== */
    .site-header{
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .site-header .site-nav a{
      color:#fff;
      text-decoration:none;
      transition:all .3s ease;
      position:relative;
      padding:4px 0;
    }
    .site-header .site-nav a::after{
      content:"";
      position:absolute;
      width:0;
      height:2px;
      bottom:-2px;
      left:0;
      background:var(--accent, #3b82f6);
      transition:width .3s ease;
    }
    .site-header .site-nav a:hover::after{
      width:100%;
    }

    /* ===== จำกัดสไตล์ลิงก์เฉพาะในคอนเทนต์ ไม่ให้ทับ navbar ===== */
    .page a{color:var(--accent);text-decoration:none;transition:color .2s ease}
    .page a:hover{color:var(--ink)}

    .page{
      max-width:1200px;
      margin:32px auto;
      padding:0 20px;
    }

    .crumb{
      color:var(--muted);
      margin:8px 0 20px;
      font-size:.95rem;
      display:flex;
      align-items:center;
      gap:8px;
    }
    .crumb a{
      text-decoration:none;
      transition:color .2s ease;
    }
    .crumb a:hover{
      text-decoration:underline;
      color:var(--ink);
    }
    .crumb span:not(:last-child)::after {
      content: "•";
      margin-left:8px;
      color:var(--muted);
    }

    /* =================== HERO + SUMMARY =================== */
    .head{
      display:grid;
      grid-template-columns:450px 1fr;
      gap:32px;
      margin-bottom:32px;
    }
    @media(max-width:980px){
      .head{
        grid-template-columns:1fr;
        gap:24px;
      }
    }

    .card{
      background:var(--card);
      border-radius:20px;
      box-shadow:0 10px 25px rgba(15,35,66,.08);
      border:1px solid #e8eef5;
      overflow:hidden;
      transition:transform .3s ease, box-shadow .3s ease;
    }
    .card:hover {
      transform:translateY(-5px);
      box-shadow:0 15px 30px rgba(15,35,66,.12);
    }
    .card .bd{padding:24px}

    .hero{
      aspect-ratio:1/1;
      background:linear-gradient(145deg, #f0f4f8, #d9e2ec);
      border-radius:20px;
      display:flex;
      align-items:center;
      justify-content:center;
      overflow:hidden;
      position:relative;
    }
    .hero::before {
      content:"";
      position:absolute;
      top:0;
      left:0;
      right:0;
      bottom:0;
      background:var(--gradient);
      opacity:0.1;
      z-index:1;
    }
    .hero img{
      max-width:90%;
      max-height:90%;
      object-fit:contain;
      transition:transform .5s ease;
      position:relative;
      z-index:2;
    }
    .hero:hover img{transform:scale(1.05) rotate(2deg)}

    /* thumbs */
    .thumbs-wrap{
      position:relative;
      margin-top:16px;
    }
    .thumbs-viewport{
      overflow:hidden;
      width:100%;
      margin:0 auto;
    }
    .thumbs-track{
      display:flex;
      gap:12px;
      transition:transform .35s ease;
      padding:0 10px;
    }
    .thumbs-item{
      width:80px;
      height:80px;
      object-fit:cover;
      border-radius:12px;
      border:2px solid transparent;
      box-shadow:0 4px 8px rgba(0,0,0,.1);
      cursor:pointer;
      background:#fff;
      transition:all .3s ease;
    }
    .thumbs-item:hover{
      transform:translateY(-5px);
      box-shadow:0 8px 16px rgba(0,0,0,.15);
    }
    .thumbs-item.is-active{
      border-color:var(--accent);
      box-shadow:0 0 0 3px rgba(59, 130, 246, 0.3);
    }

    .t-nav{
      position:absolute;
      top:50%;
      transform:translateY(-50%);
      width:36px;
      height:36px;
      border-radius:50%;
      border:0;
      background:var(--card);
      color:var(--accent);
      font-weight:700;
      font-size:18px;
      box-shadow:0 4px 12px rgba(0,0,0,.15);
      cursor:pointer;
      z-index:10;
      transition:all .3s ease;
    }
    .t-nav:hover { background:var(--accent); color:white; }
    .t-nav[disabled]{opacity:.4;cursor:not-allowed}
    .t-nav[disabled]:hover { background:var(--card); color:var(--accent); }
    .t-prev{left:5px}
    .t-next{right:5px}

    .title{
      margin:0 0 16px;
      font-size:2.2rem;
      line-height:1.3;
      font-weight:800;
      color:var(--ink);
      background:var(--gradient);
      -webkit-background-clip:text;
      -webkit-text-fill-color:transparent;
      background-clip:text;
    }
    .meta{
      color:var(--muted);
      margin-bottom:24px;
      font-size:1rem;
      line-height:1.4;
      display:flex;
      align-items:center;
      gap:8px;
    }
    .chip{
      display:inline-flex;
      align-items:center;
      background:var(--accent);
      color:#fff;
      border-radius:20px;
      padding:6px 14px;
      font-size:.8rem;
      font-weight:600;
      line-height:1.3;
      box-shadow:0 4px 8px rgba(59, 130, 246, 0.3);
    }
    .chip i { margin-right:6px; font-size:0.7rem; }

    /* KPIs */
    .kpis{
      display:grid;
      grid-template-columns:repeat(2,1fr);
      gap:16px;
      margin-top:24px;
    }
    @media(max-width:520px){ .kpis{grid-template-columns:1fr} }
    .kpis div{
      background:linear-gradient(145deg, #f8fbff, #f0f7ff);
      border:1px solid var(--accent-light);
      padding:18px;
      border-radius:16px;
      transition:all .3s ease;
      font-size:1rem;
      line-height:1.5;
      position:relative;
      overflow:hidden;
    }
    .kpis div::before { content:""; position:absolute; top:0; left:0; width:4px; height:100%; background:var(--accent); }
    .kpis div:hover{ transform:translateY(-3px); box-shadow:0 8px 16px rgba(15,35,66,.1); }
    .kpis b{ font-weight:700; color:var(--ink); font-size:1.1rem; }

    /* =================== SPEC SECTIONS =================== */
    .spec-grid{ display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-top:32px; }
    @media(max-width:920px){ .spec-grid{ grid-template-columns:1fr; } }

    .sec{
      border-radius:20px;
      background:var(--card);
      box-shadow:0 8px 20px rgba(15,35,66,.08);
      border:1px solid #e8eef5;
      overflow:hidden;
      transition:all .3s ease;
    }
    .sec:hover{ transform:translateY(-5px); box-shadow:0 12px 25px rgba(15,35,66,.12); }

    .sec h3{
      margin:0; padding:20px; border-bottom:1px solid var(--line);
      font-size:1.2rem; font-weight:700; background:linear-gradient(to right, #f8fbff, #f0f7ff);
      color:var(--ink); line-height:1.4; display:flex; align-items:center; gap:10px;
    }
    .sec h3 i { color:var(--accent); }

    .spec{ width:100%; border-collapse:collapse; }
    .spec th, .spec td{ padding:16px 20px; border-bottom:1px solid #f1f5fa; vertical-align:top; font-size:1rem; line-height:1.55; }
    .spec th{ width:40%; font-weight:600; color:#1f2f4a; background:var(--row-bg); }
    .spec td{ color:var(--ink); font-weight:500; }
    .spec tr:hover td{ background:#f9fbfe; }
    .spec tr:last-child th, .spec tr:last-child td{ border-bottom:0; }

    /* =================== RESPONSIVE =================== */
    @media(max-width:980px){
      .page{ padding:0 16px; max-width:700px; }
      .head{ grid-template-columns:1fr; gap:24px; }
      .title{ font-size:clamp(1.8rem,5vw,2.2rem); text-align:center; }
      .meta{ justify-content:center; font-size:1rem; margin-bottom:20px; }
      .chip{ padding:5px 12px; font-size:.8rem; }
      .hero{ border-radius:20px; aspect-ratio:1/1; }
      .thumbs-item{ width:70px; height:70px; }
      .kpis{ grid-template-columns:1fr; gap:12px; }
      .kpis div{ padding:16px; font-size:1rem; border-radius:16px; }
      .spec-grid{ grid-template-columns:1fr; gap:20px; margin-top:24px; }
      .sec{ border-radius:18px; }
      .sec h3{ font-size:1.2rem; padding:16px 20px; justify-content:center; }
      .spec th, .spec td{ font-size:1rem; line-height:1.6; padding:16px; }
      .spec th{ font-weight:600; color:#1f2f4a; background:var(--row-bg); }
      .spec td{ color:var(--ink); font-weight:600; }
      .spec tr:hover td{ background:#eef5ff; }
    }

    @media(max-width:560px){
      .page{ padding:0 12px; max-width:480px; }
      .title{ font-size:clamp(1.6rem,6vw,2rem); margin-bottom:12px; }
      .meta{ font-size:0.9rem; flex-wrap:wrap; gap:6px; }
      .kpis div{ font-size:0.95rem; padding:14px; }
      .sec h3{ font-size:1.1rem; padding:14px 16px; }
      .spec th, .spec td{ font-size:0.95rem; line-height:1.6; padding:14px 12px; }
      .card .bd { padding:16px; }
    }

    /* ===== Navbar ให้เหมือนหน้า Home ===== */
header{
  background:#0f2342;
  color:#fff;
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
  background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  background-clip:text;
}
header nav a{
  color:#fff;
  margin-left:14px;
  text-decoration:none;  /* ไม่มีขีดเส้นใต้ */
  transition:all .3s ease;
  position:relative;
}
header nav a:hover{
  color:#dbeafe;         /* --accent-light */
}
header nav a::after{
  content:"";
  position:absolute;
  left:0;
  bottom:-5px;
  height:2px;
  width:0;
  background:#3b82f6;    /* --accent */
  transition:width .3s ease;
}
header nav a:hover::after{ width:100%; }

/* จำกัดผลกระทบของลิงก์ในเนื้อหา ไม่ให้ไปทับ navbar */
.page a{
  color:var(--accent);
  text-decoration:none;
  transition:color .2s ease;
}
.page a:hover{ color:var(--ink); }

  </style>
</head>
<body>
  @include('layouts.navbar')

  <div class="page">

    <div class="crumb">
      <a href="{{ route('home') }}">หน้าแรก</a>
      <a href="{{ route('home') }}">มือถือ</a>
      <span>{{ $mobile->Model }}</span>
    </div>

    @php
      $yn = function($v){
        if ($v === null) return '-';
        $s = is_bool($v) ? ($v ? '1' : '0') : trim((string)$v);
        if ($s === '') return '-';
        $s = strtolower($s);
        if (in_array($s, ['1','true','yes','y'])) return 'มี';
        if (in_array($s, ['0','false','no','n']))  return 'ไม่มี';
        return ucfirst($s);
      };
      $val  = fn($v,$suf='') => (isset($v) && $v!=='')
        ? (is_numeric($v)?rtrim(rtrim((string)$v),'.'):$v).$suf
        : '-';
      $date = fn($d)=> empty($d) ? '-' : \Illuminate\Support\Carbon::parse($d)->format('d M Y');

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
          'ราคาเปิดตัว' => ($mobile->LaunchPrice!==null ? number_format($mobile->LaunchPrice).' '.($mobile->Currency ?? 'THB') : '-'),
          'ราคาปัจจุบัน' => ($mobile->Price!==null ? number_format($mobile->Price).' '.($mobile->Currency ?? 'THB') : '-'),
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
              <button class="t-nav t-prev" type="button" aria-label="ก่อนหน้า" disabled>
                <i class="fas fa-chevron-left"></i>
              </button>

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

              <button class="t-nav t-next" type="button" aria-label="ถัดไป">
                <i class="fas fa-chevron-right"></i>
              </button>
            </div>
          @endif
        </div>
      </div>

      {{-- ขวา: ชื่อ + ไฮไลต์หลัก --}}
      <div>
        <h1 class="title">{{ $mobile->FullName ?? $mobile->Model }}</h1>
        <div class="meta">
          <i class="fas fa-tag"></i>
          <strong>{{ $mobile->brand->Brand ?? '-' }}</strong>
          @if(!empty($mobile->OS))
            <span class="chip"><i class="fas fa-mobile-alt"></i>{{ $mobile->OS }}</span>
          @endif
        </div>

        <div class="card" style="margin-top:16px">
          <div class="bd">
            <div class="kpis">
              <div><i class="fas fa-microchip"></i> ชิป: <b>{{ $mobile->Processor ?? '-' }}</b></div>
              <div><i class="fas fa-memory"></i> RAM/ROM: <b>{{ $mobile->RAM_GB ?? '-' }}GB / {{ $mobile->Storage_GB ?? '-' }}GB</b></div>
              <div><i class="fas fa-desktop"></i> จอ: <b>{{ $mobile->ScreenSize_in ?? '-' }}″ {{ $mobile->Display_Type ?? $mobile->Display ?? '' }}</b></div>
              <div><i class="fas fa-battery-full"></i> แบตฯ: <b>{{ $mobile->Battery_mAh ? number_format($mobile->Battery_mAh).' mAh' : '-' }}</b></div>
              <div><i class="fas fa-camera"></i> กล้องหลัง: <b>{{ $mobile->BackCamera ?? '-' }}</b></div>
              <div><i class="fas fa-tag"></i> ราคา: <b>{{ $mobile->Price!==null ? number_format($mobile->Price).' '.($mobile->Currency ?? 'THB') : '-' }}</b></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- สเปกเต็ม --}}
    <div class="spec-grid">
      @foreach($sections as $title => $pairs)
        @php
          $hasAny = collect($pairs)->contains(fn($v)=> $v !== '-');
          $icon = '';
          switch($title) {
            case 'ข้อมูลทั่วไป': $icon = 'fas fa-info-circle'; break;
            case 'จอภาพ (Display)': $icon = 'fas fa-desktop'; break;
            case 'ประสิทธิภาพ (Performance)': $icon = 'fas fa-tachometer-alt'; break;
            case 'กล้อง (Camera)': $icon = 'fas fa-camera'; break;
            case 'แบตเตอรี่และชาร์จ': $icon = 'fas fa-battery-full'; break;
            case 'เครือข่ายและการเชื่อมต่อ': $icon = 'fas fa-wifi'; break;
            case 'ระบบเสียง': $icon = 'fas fa-volume-up'; break;
            case 'ความปลอดภัย/เซนเซอร์': $icon = 'fas fa-shield-alt'; break;
            case 'ระบบปฏิบัติการและอัปเดต': $icon = 'fas fa-cogs'; break;
            case 'ฟีเจอร์อื่น ๆ': $icon = 'fas fa-star'; break;
          }
        @endphp
        @if($hasAny)
          <section class="sec" aria-label="{{ $title }}">
            <h3><i class="{{ $icon }}"></i> {{ $title }}</h3>
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
      thumbs[0].classList.add('is-active');
      thumbs.forEach((t)=>t.addEventListener('click',()=>{
        thumbs.forEach(x=>x.classList.remove('is-active'));
        t.classList.add('is-active');
        mainImg.src=t.src;
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
      const items = Array.from(track.querySelectorAll('.thumbs-item'));
      const gap=12, w=80;
      let page=0, pages=Math.max(1, Math.ceil(items.length/perPage));

      function widthFor(n){ return (n*w + (n-1)*gap) + 'px'; }
      function update(){
        const x = -(page * (perPage*w + (perPage-1)*gap));
        track.style.transform = `translateX(${x}px)`;
        prevBtn.disabled = (page===0);
        nextBtn.disabled = (page>=pages-1);
      }

      prevBtn.addEventListener('click',()=>{ if(page>0){page--;update();} });
      nextBtn.addEventListener('click',()=>{ if(page<pages-1){page++;update();} });

      // responsive: จอเล็กลดเหลือ 3 รูป/หน้า
      const mq = window.matchMedia('(max-width: 420px)');
      function onResize(){
        perPage = mq.matches ? 3 : parseInt(wrap.dataset.perPage||'4',10);
        pages = Math.max(1, Math.ceil(items.length/perPage));
        viewport.style.width = widthFor(perPage);
        page = Math.min(page, pages-1);
        update();
      }
      onResize();
      window.addEventListener('resize', onResize);
      update();
    })();
  </script>
</body>
</html>
