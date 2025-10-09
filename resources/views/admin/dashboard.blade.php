{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'หน้าหลัก | Back Office')

{{-- ถ้าหน้านี้มีสไตล์เฉพาะ เพิ่มผ่าน stack "head" ได้ --}}
@push('head')
<style>
  /* เฉพาะรายการมือถือ: ทำให้เห็นทั้งเครื่อง */
  #phones .item { align-items: center; } /* จัดกลางแนวตั้ง */
  #phones .thumb{
    width:110px;              /* กว้างขึ้นนิด */
    height:130px;             /* สูงพอสำหรับสัดส่วนมือถือ */
    flex:0 0 110px;
    object-fit:contain;       /* เห็นทั้งรูป ไม่ครอป */
    background:#fff;          /* พื้นหลังขาว */
    border:1px solid var(--line);
    border-radius:12px;
    padding:6px;              /* มีขอบขาวรอบ ๆ รูป */
    box-sizing:border-box;
  }
  .cards{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
  .card{background:#fff;border:1px solid var(--line);border-radius:12px;padding:14px}
  .kpi{font-size:12px;color:#6b7280}
  .kpi .n{font-size:24px;font-weight:800;color:var(--primary)}

  .panel{background:#fff;border:1px solid var(--line);border-radius:12px;padding:14px}
  .panel h3{margin:0 0 10px;font-size:16px}
  .list{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
  .item{display:flex;gap:10px;align-items:center}
  .thumb{width:90px;height:60px;border-radius:8px;background:#eef3f9;flex:0 0 90px;object-fit:cover}
  .muted{color:#6b7280;font-size:12px}

  .line-title{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;column-gap:12px;margin:6px 0 2px;color:#6b7280;font-weight:700}
  .line-title::before,.line-title::after{content:"";height:2px;background:var(--line)}
  @media (max-width:1080px){ .cards{grid-template-columns:repeat(2,1fr)} .list{grid-template-columns:repeat(2,1fr)} }
  @media (max-width:760px){ .cards{grid-template-columns:1fr} .list{grid-template-columns:1fr} }
</style>
@endpush

@section('topbar')
  <h1>แดชบอร์ด</h1>
@endsection

@section('content')
  {{-- หัวข้อคั่น --}}
  <div class="line-title">หมวดหมู่</div>

  {{-- KPI Cards --}}
  <section class="cards">
    <div class="card">
      <div class="kpi">จำนวนผู้ใช้ทั้งหมด</div>
      <div class="n">{{ $membersCount ?? 0 }}</div>
    </div>
    <div class="card">
      <div class="kpi">มือถือทั้งหมด</div>
      <div class="n">{{ $phonesCount ?? 0 }}</div>
    </div>
    <div class="card">
      <div class="kpi">ข่าวทั้งหมด</div>
      <div class="n">{{ $newsCount ?? 0 }}</div>
    </div>
    <div class="card">
      <div class="kpi">เข้าชมเว็บไซต์วันนี้</div>
      <div class="n">{{ number_format($todayVisitors ?? 0) }}</div>
    </div>
  </section><br>

  {{-- แบนเนอร์ --}}
  <section id="banners" class="panel">
    <h3>แบนเนอร์ (ทั้งหมด {{ $bannersCount ?? 0 }})</h3>

    <div class="list">
      @forelse(($recentBanners ?? []) as $b)
        <div class="item">
          <img class="thumb"
              src="{{ $b->image_url ?? $b->bannerImg ?? asset('images/placeholder.png') }}"
              alt="banner">

          <div style="display:flex;flex-direction:column;gap:4px">
            <div style="font-weight:600">
              {{ $b->title ?? $b->bannerName ?? 'Untitled' }}
            </div>

            <div>
              @php $active = (bool) ($b->is_active ?? false); @endphp
              <span style="
                display:inline-flex;align-items:center;gap:6px;
                font-size:12px;padding:4px 8px;border-radius:999px;
                background: {{ $active ? '#e8f7ee' : '#fdeaea' }};
                color: {{ $active ? '#16a34a' : '#dc2626' }};
                border: 1px solid {{ $active ? '#b9ebc9' : '#f5c2c2' }};
              ">
                <span style="width:8px;height:8px;border-radius:50%;
                  background: {{ $active ? '#16a34a' : '#dc2626' }};"></span>
                {{ $active ? 'ใช้งาน' : 'ปิดใช้งาน' }}
              </span>
            </div>
          </div>
        </div>
      @empty
        <div class="muted">ยังไม่มีแบนเนอร์</div>
      @endforelse
    </div>
  </section>


  {{-- มือถือ --}}
  <section id="phones" class="panel">
    <h3>ข้อมูลมือถือ (ล่าสุด)</h3>

    <div class="list">
      @forelse(($recentPhones ?? []) as $p)
        @php
          $imgPath = $p->coverImage?->Img ?? $p->images->first()?->Img ?? null;
          $imgUrl  = $imgPath ? asset('storage/'.$imgPath) : asset('images/placeholder.png');
          $brand   = $p->brand->Brand ?? '-';
        @endphp

        <div class="item"  style="text-decoration:none;color:inherit">
          <img class="thumb" src="{{ $imgUrl }}" alt="{{ $p->Model }}">
          <div>
            <div style="font-weight:600">{{ $p->Model }}</div>
            <div class="muted">{{ $brand }}</div>
          </div>
        </div>
      @empty
        <div class="muted">ยังไม่มีข้อมูลมือถือ</div>
      @endforelse
    </div>
  </section>


  {{-- ข่าว --}}
  <section id="news" class="panel">
    <h3 style="margin:0 0 10px; display:flex; align-items:center; gap:8px">
      📰 ข้อมูลข่าว (ล่าสุด)
    </h3>

    <div class="list">
      @forelse($recentNews as $n)
        <div class="item" href="#" style="display:flex;gap:12px;align-items:center;padding:10px 0">
          <img class="thumb"
              src="{{ $n->coverUrl() }}"
              alt=""
              style="width:90px;height:90px;object-fit:contain;border:1px solid #e5e7eb;border-radius:12px">
          <div>
            <div style="font-weight:700">{{ $n->Title }}</div>
            <div class="muted" style="font-size:12px;color:#6b7280">
              {{ \Illuminate\Support\Str::limit(strip_tags($n->Details), 60) }}
            </div>
            @if($n->Date)
              <div class="muted" style="font-size:12px;color:#9ca3af">
                {{ $n->Date->format('d M Y H:i') }}
              </div>
            @endif
          </div>
        </div>
      @empty
        <div class="muted" style="color:#6b7280">ยังไม่มีข่าว</div>
      @endforelse
    </div>
  </section>


{{-- สมาชิก 
  <section id="members" class="panel">
    <h3>ข้อมูลสมาชิก (ล่าสุด)</h3>
    <div class="list">
      @forelse(($recentMembers ?? []) as $m)
        <div class="item">
          <img class="thumb" src="{{ $m->avatar_url ?? asset('images/placeholder.png') }}" alt="">
          <div>
            <div style="font-weight:600">{{ $m->User_Name ?? 'user' }}</div>
            <div class="muted">{{ $m->Email ?? '' }}</div>
          </div>
        </div>
      @empty
        <div class="muted">ยังไม่มีสมาชิกใหม่</div>
      @endforelse --}}
    </div>
  </section>
@endsection
