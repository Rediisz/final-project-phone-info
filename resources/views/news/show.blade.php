<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>{{ $news->Title }} | SmartSpec</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <style>
   body{background:#f3f6fb;font-family:sans-serif;margin:0;color:#0f2342}
  /* อย่าเขียน header{} ในหน้านี้ เพื่อไม่ให้ทับ layouts.navbar */
   /* ให้เหมือน mobile/show */
    header h1{ margin:0; font-size:1.6rem; }
    header nav a{ color:#fff; margin-left:14px; text-decoration:none; }
    header nav a:hover{ text-decoration:underline; } 
    /* ให้กว้างเท่าหน้า mobile/home */
  .wrap{max-width:1100px;margin:24px auto;padding:0 16px}

  .crumb{font-size:.9rem;color:#64748b;margin-bottom:10px}
  .crumb a{color:#0f2342;text-decoration:none}
  .crumb a:hover{text-decoration:underline}

  .title{margin:6px 0 4px 0}
  .meta{color:#64748b;font-size:.95rem}
  .pill{display:inline-block;background:#0f2342;color:#fff;border-radius:999px;padding:2px 10px;font-size:.78rem;font-weight:700}

  .card{background:#fff;border-radius:16px;box-shadow:0 4px 12px rgba(15,35,66,.08);overflow:hidden}
  .hero{width:100%;aspect-ratio:16/9;background:#eef3f9;display:flex;align-items:center;justify-content:center}
  .hero img{width:100%;height:100%;object-fit:cover}

  .content{padding:18px 20px;line-height:1.9;font-size:1.05rem}
  .gallery{display:flex;gap:10px;flex-wrap:wrap;padding:14px 0 2px}
  .gallery img{width:180px;height:120px;object-fit:cover;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,.08)}

  .meta-row{display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-top:6px}
  .sep{opacity:.4}
  body > header{
  all: revert-layer;                 /* ยกเลิกผลกระทบจากสไตล์ก่อนหน้า ถ้าเบราว์เซอร์รองรับ */
  background:#0f2342; color:#fff;
  display:flex; justify-content:space-between; align-items:center;
  padding:12px 24px; width:100%; box-sizing:border-box;
    }
    body > header nav{ display:flex; align-items:center; gap:12px; }
  </style>
</head>
<body>
  @include('layouts.navbar')

  <div class="wrap">
    <div class="crumb">
      <a href="{{ route('home') }}">หน้าแรก</a> ·
      <a href="{{ route('news') }}">ข่าว</a> ·
      <span>{{ $news->Title }}</span>
    </div>

    <h1 class="title">{{ $news->Title }}</h1>

    <div class="meta-row">
      <span class="meta">{{ optional($news->Date)->format('d M Y H:i') }}</span>
      @if($news->brand)<span class="sep">•</span><span class="pill">{{ $news->brand->Brand }}</span>@endif
      @if($news->mobile)<span class="sep">•</span><span>{{ $news->mobile->Model }}</span>@endif
    </div>

    <div class="card" style="margin-top:14px">
      @php
        $coverPath = $news->cover?->Img ?? $news->images->first()?->Img ?? null;
        $coverUrl  = $coverPath ? asset('storage/'.$coverPath) : asset('images/default.jpg');
      @endphp
      <div class="hero">
        <img src="{{ $coverUrl }}" alt="{{ $news->Title }}">
      </div>

      <div class="content">
        @if($news->Intro)
          <p><strong>{{ $news->Intro }}</strong></p>
        @endif

        @if($news->Details){!! nl2br(e($news->Details)) !!}@endif
        @if($news->Details2)<br>{!! nl2br(e($news->Details2)) !!}@endif
        @if($news->Details3)<br>{!! nl2br(e($news->Details3)) !!}@endif

        @if($news->images && $news->images->count() > 1)
          <div class="gallery">
            @foreach($news->images as $im)
              <img src="{{ asset('storage/'.$im->Img) }}" alt="image">
            @endforeach
          </div>
        @endif
      </div>
    </div>
    @include('components.comments', ['model' => $news, 'type' => 'news'])
  </div>
</body>
</html>
