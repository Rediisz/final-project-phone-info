{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'หน้าหลัก | Back Office')

{{-- ถ้าหน้านี้มีสไตล์เฉพาะ เพิ่มผ่าน stack "head" ได้ --}}
@push('head')
<style>
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
      <div class="kpi">เข้าใช้งานวันนี้</div>
      <div class="n">{{ $todayVisits ?? 0 }}</div>
    </div>
  </section><br>

  {{-- แบนเนอร์ --}}
  <section id="banners" class="panel">
    <h3>แบนเนอร์ (ทั้งหมด)</h3>
    <div class="list">
      @forelse(($recentBanners ?? []) as $b)
        <div class="item">
          <img class="thumb" src="{{ $b->image_url ?? asset('images/placeholder.png') }}" alt="">
          <div>
            <div style="font-weight:600">{{ $b->title ?? 'Untitled' }}</div>
            <div class="muted">{{ $b->description ?? '' }}</div>
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
        <a class="item" href="#">
          <img class="thumb" src="{{ $p->image_url ?? asset('images/placeholder.png') }}" alt="">
          <div>
            <div style="font-weight:600">{{ $p->model ?? 'Unknown' }}</div>
            <div class="muted">{{ $p->brand ?? '-' }}</div>
          </div>
        </a>
      @empty
        <div class="muted">ยังไม่มีข้อมูลมือถือ</div>
      @endforelse
    </div>
  </section>

  {{-- ข่าว --}}
  <section id="news" class="panel">
    <h3>ข้อมูลข่าว (ล่าสุด)</h3>
    <div class="list">
      @forelse(($recentNews ?? []) as $n)
        <a class="item" href="#">
          <img class="thumb" src="{{ $n->image_url ?? asset('images/placeholder.png') }}" alt="">
          <div>
            <div style="font-weight:600">{{ $n->title ?? 'Untitled' }}</div>
            <div class="muted">{{ \Illuminate\Support\Str::limit($n->summary ?? '', 60) }}</div>
          </div>
        </a>
      @empty
        <div class="muted">ยังไม่มีข่าว</div>
      @endforelse
    </div>
  </section>

  {{-- สมาชิก --}}
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
      @endforelse
    </div>
  </section>
@endsection
