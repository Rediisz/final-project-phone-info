<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>{{ $news->Title }} | SmartSpec</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <style>
   *{box-sizing:border-box}
   body{background:#f3f6fb;font-family:system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;margin:0;color:#0f2342;line-height:1.6}
  /* อย่าเขียน header{} ในหน้านี้ เพื่อไม่ให้ทับ layouts.navbar */
    header h1{ margin:0; font-size:1.6rem; font-weight:700; }
    header nav a{ color:#fff; margin-left:14px; text-decoration:none; transition:opacity .2s ease; }
    header nav a:hover{ text-decoration:underline; opacity:.85; } 
  .wrap{max-width:900px;margin:32px auto;padding:0 20px}

  .crumb{font-size:.95rem;color:#64748b;margin-bottom:12px}
  .crumb a{color:#0f2342;text-decoration:none;transition:color .2s ease}
  .crumb a:hover{text-decoration:underline;color:#0f2342}

  .title{margin:8px 0 12px 0;font-size:2rem;font-weight:700;line-height:1.3;color:#0f2342}
  .meta{color:#64748b;font-size:.95rem}
  .pill{display:inline-block;background:#0f2342;color:#fff;border-radius:999px;padding:4px 12px;font-size:.8rem;font-weight:600;margin-right:6px}

  .card{background:#fff;border-radius:16px;box-shadow:0 2px 8px rgba(15,35,66,.06);overflow:hidden;border:1px solid #e8eef5}
  .hero{width:100%;aspect-ratio:16/9;background:#eef3f9;display:flex;align-items:center;justify-content:center;overflow:hidden}
  .hero img{width:100%;height:100%;object-fit:cover;transition:transform .3s ease}
  .hero:hover img{transform:scale(1.02)}

  .content{padding:28px 32px;line-height:1.8;font-size:1.05rem;color:#374151}
  .content strong{color:#0f2342;font-weight:600}
  .gallery{display:flex;gap:12px;flex-wrap:wrap;padding:20px 0 0}
  .gallery img{width:180px;height:120px;object-fit:cover;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.1);transition:transform .2s ease;cursor:pointer}
  .gallery img:hover{transform:scale(1.05);box-shadow:0 4px 12px rgba(0,0,0,.15)}

  .meta-row{display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-top:8px}
  .sep{opacity:.4;color:#64748b}

  @media (max-width:768px){
    .title{font-size:1.5rem}
    .wrap{padding:0 16px;margin:20px auto}
    .content{padding:20px}
    .gallery img{width:calc(50% - 6px)}
  }
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
