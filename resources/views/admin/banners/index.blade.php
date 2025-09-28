@extends('layouts.admin')

@section('title','แบนเนอร์ | Back Office')

@section('topbar')
  <h1 >แบนเนอร์</h1>
  <div style="display:flex; gap:8px">
    <a class="btn"
       style="background:var(--primary);color:#fff;border-radius:8px;font-weight:600"
       href="{{ route('admin.banners.create') }}">+ เพิ่มแบนเนอร์</a>
  </div>
@endsection

@section('content')
  <div class="panel">
    <h3 style="margin:0 0 12px;font-size:16px;display:flex;align-items:center;gap:6px">
      📢 รายการแบนเนอร์
    </h3>

<div style="overflow:auto">
  <table style="width:100%;border-collapse:collapse;background:#fff;table-layout:fixed">
    {{-- กำหนดความกว้างคอลัมน์ให้คุมไม่ให้ตารางบาน --}}
    <colgroup>
      <col style="width:80px">     {{-- ลำดับ --}}
      <col>                        {{-- หัวข้อ (ยืดได้) --}}
      <col style="width:220px">    {{-- รูปภาพ --}}
      <col style="width:120px">    {{-- สถานะ --}}
      <col style="width:90px">     {{-- แก้ไข --}}
      <col style="width:80px">     {{-- ลบ --}}
    </colgroup>

    <thead>
      <tr style="background:#f9fafb">
        <th style="padding:12px;border:1px solid var(--line);text-align:center">ลำดับ</th>
        <th style="padding:12px;border:1px solid var(--line);text-align:center">หัวข้อ</th>
        <th style="padding:12px;border:1px solid var(--line);text-align:center">รูปภาพ</th>
        <th style="padding:12px;border:1px solid var(--line);text-align:center">สถานะ</th>
        <th style="padding:12px;border:1px solid var(--line);text-align:center">แก้ไข</th>
        <th style="padding:12px;border:1px solid var(--line);text-align:center">ลบ</th> 
      </tr>
    </thead>

    <tbody>
      @forelse($banners as $banner)
        <tr>
          {{-- ลำดับรองรับ pagination --}}
          <td style="padding:12px;border:1px solid var(--line);text-align:center">
            {{ ($banners->firstItem() ?? 0) + $loop->index }}
          </td>

          {{-- หัวข้อ: truncate ถ้ายาว --}}
          <td style="padding:12px;border:1px solid var(--line);font-weight:600;color:var(--primary);
                     white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
            {{ $banner->bannerName }}
          </td>

          <td style="padding:12px;border:1px solid var(--line);text-align:center">
            <img src="{{ $banner->image_url }}" alt="banner"
                 style="width:150px;height:90px;object-fit:cover;border-radius:8px;display:inline-block">
          </td>

          <td style="padding:12px;border:1px solid var(--line);text-align:center">
            <span title="{{ $banner->is_active ? 'ใช้งาน' : 'ปิดใช้งาน' }}"
                  style="display:inline-block;width:14px;height:14px;border-radius:50%;
                         background:{{ $banner->is_active ? '#16a34a' : '#dc2626' }}"></span>
          </td>

          <td style="padding:12px;border:1px solid var(--line);text-align:center">
            <a href="{{ route('admin.banners.edit', $banner->getKey()) }}" title="แก้ไข">✏️</a>
          </td>

          <td style="padding:12px;border:1px solid var(--line);text-align:center">
            <form action="{{ route('admin.banners.destroy', $banner->getKey()) }}"
                  method="POST" style="display:inline"
                  onsubmit="return confirm('คุณต้องการลบแบนเนอร์นี้หรือไม่?');">
              @csrf
              @method('DELETE')
              <button type="submit" style="background:none;border:none;cursor:pointer" title="ลบ">🗑️</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="padding:16px;border:1px solid var(--line);text-align:center;color:#64748b">
            ยังไม่มีข้อมูลแบนเนอร์
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

  </div>
@endsection
