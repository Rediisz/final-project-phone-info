{{-- resources/views/admin/brand/index.blade.php --}}
@extends('layouts.admin')

@section('title','ข้อมูลแบรนด์ | Back Office')

@section('topbar')
  <h1>ข้อมูลแบรนด์</h1>
  <div style="display:flex; gap:8px">
    <a href="{{ route('admin.brands.create') }}" class="btn"
       style="background:var(--primary);color:#fff;border-radius:8px;font-weight:600">
      + เพิ่มแบรนด์
    </a>
  </div>
@endsection

@section('content')
  @if(session('ok'))
    <div class="alert success">{{ session('ok') }}</div>
  @endif

  <div class="panel">
    <h3 style="margin:0 0 12px;font-size:16px;display:flex;align-items:center;gap:6px">
      🏷️ รายการแบรนด์
    </h3>

    <div style="overflow:auto">
      <table style="width:100%;border-collapse:collapse;background:#fff;table-layout:fixed">
        <colgroup>
          <col style="width:80px">      {{-- ลำดับแถว --}}
          <col style="width:200px">     {{-- โลโก้ --}}
          <col>                         {{-- ชื่อแบรนด์ --}}
          <col style="width:120px">     {{-- สถานะ --}}
          <col style="width:90px">      {{-- แก้ไข --}}
          <col style="width:80px">      {{-- ลบ --}}
        </colgroup>

        <thead>
          <tr style="background:#f9fafb">
            <th style="padding:12px;border:1px solid var(--line);text-align:center">ลำดับ</th>
            <th style="padding:12px;border:1px solid var(--line);text-align:center">โลโก้</th>
            <th style="padding:12px;border:1px solid var(--line);text-align:center">ชื่อแบรนด์</th>
            <th style="padding:12px;border:1px solid var(--line);text-align:center">สถานะ</th>
            <th style="padding:12px;border:1px solid var(--line);text-align:center">แก้ไข</th>
            <th style="padding:12px;border:1px solid var(--line);text-align:center">ลบ</th>
          </tr>
        </thead>

        <tbody>
          @forelse($brands as $b)
            <tr>
              {{-- ลำดับแถว (ตามหน้าเพจ) --}}
              <td style="padding:12px;border:1px solid var(--line);text-align:center">
                {{ ($brands->firstItem() ?? 0) + $loop->index }}
              </td>

              {{-- โลโก้ --}}
              <td style="padding:12px;border:1px solid var(--line);text-align:center">
                @if($b->Logo_Path)
                  <img src="{{ asset('storage/'.$b->Logo_Path) }}" alt="{{ $b->Brand }}"
                       style="width:80px;height:80px;object-fit:contain;border-radius:8px;background:#fff">
                @else
                  <div style="width:80px;height:80px;border:1px dashed var(--line);border-radius:8px;
                              display:inline-flex;align-items:center;justify-content:center;
                              color:#9ca3af;font-size:12px">ไม่มีรูป</div>
                @endif
              </td>

              {{-- ชื่อแบรนด์ --}}
              <td style="padding:12px;border:1px solid var(--line)">
                <div style="font-weight:600;color:var(--primary)">{{ $b->Brand }}</div>
              </td>

              {{-- สถานะ (จุดสี เขียว/แดง แบบเดียวกับแบนเนอร์) --}}
              <td style="padding:12px;border:1px solid var(--line);text-align:center">
                <span title="{{ $b->IsActive ? 'ใช้งาน' : 'ปิดใช้งาน' }}"
                      style="display:inline-block;width:14px;height:14px;border-radius:50%;
                             background:{{ $b->IsActive ? '#16a34a' : '#dc2626' }}"></span>
              </td>

              {{-- แก้ไข --}}
              <td style="padding:12px;border:1px solid var(--line);text-align:center">
                <a href="{{ route('admin.brands.edit', $b->ID) }}" title="แก้ไข">✏️</a>
              </td>

              {{-- ลบ --}}
              <td style="padding:12px;border:1px solid var(--line);text-align:center">
                <form action="{{ route('admin.brands.destroy', $b->ID) }}"
                      method="POST" style="display:inline"
                      onsubmit="return confirm('คุณต้องการลบแบรนด์นี้หรือไม่?');">
                  @csrf @method('DELETE')
                  <button type="submit" style="background:none;border:none;cursor:pointer" title="ลบ">🗑️</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="padding:16px;border:1px solid var(--line);text-align:center;color:#64748b">
                ยังไม่มีข้อมูลแบรนด์
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if(method_exists($brands,'hasPages') && $brands->hasPages())
      @php($prev = $brands->previousPageUrl())
      @php($next = $brands->nextPageUrl())
      <div style="margin-top:10px;display:flex;justify-content:center;align-items:center;gap:10px">
        <a href="{{ $prev ?: '#' }}"
           style="padding:8px 12px;border:1px solid var(--line);border-radius:8px;background:#fff;color:#0f2342;text-decoration:none;{{ $prev ? '' : 'pointer-events:none;opacity:.4' }}">ก่อนหน้า</a>
        <span style="color:#6b7280">
          หน้า {{ method_exists($brands,'currentPage') ? $brands->currentPage() : '' }}
          @if(method_exists($brands,'lastPage')) / {{ $brands->lastPage() }} @endif
        </span>
        <a href="{{ $next ?: '#' }}"
           style="padding:8px 12px;border:1px solid var(--line);border-radius:8px;background:#fff;color:#0f2342;text-decoration:none;{{ $next ? '' : 'pointer-events:none;opacity:.4' }}">ถัดไป</a>
      </div>
    @endif
  </div>
@endsection
