@extends('layouts.admin')

@section('title','ข้อมูลมือถือ | Back Office')

@section('topbar')
  <h1>ข้อมูลมือถือ</h1>
  <div style="display:flex; gap:8px">
    <a href="{{ route('admin.phones.create') }}" class="btn"
       style="background:var(--primary);color:#fff;border-radius:8px;font-weight:600">
      + เพิ่มมือถือ
    </a>
  </div>
@endsection

@section('content')
  @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
  @endif

  <div class="panel">
    <h3 style="margin:0 0 12px;font-size:16px;display:flex;align-items:center;gap:6px">
      📱 รายการมือถือ
    </h3>

    <div style="overflow:auto">
      <table style="width:100%;border-collapse:collapse;background:#fff;table-layout:fixed">
        {{-- ให้สัดส่วนเหมือนหน้าแบนเนอร์ --}}
        <colgroup>
          <col style="width:80px">      {{-- ลำดับ --}}
          <col>                         {{-- รุ่น/แบรนด์ (ยืดได้) --}}
          <col style="width:220px">     {{-- รูปภาพ --}}
          <col style="width:90px">      {{-- แก้ไข --}}
          <col style="width:80px">      {{-- ลบ --}}
        </colgroup>

        <thead>
          <tr style="background:#f9fafb">
            <th style="padding:12px;border:1px solid var(--line);text-align:center">ลำดับ</th>
            <th style="padding:12px;border:1px solid var(--line);text-align:center">รุ่น / แบรนด์</th>
            <th style="padding:12px;border:1px solid var(--line);text-align:center">รูปภาพ</th>
            <th style="padding:12px;border:1px solid var(--line);text-align:center">แก้ไข</th>
            <th style="padding:12px;border:1px solid var(--line);text-align:center">ลบ</th>
          </tr>
        </thead>

        <tbody>
          @forelse($items as $i => $row)
            <tr>
              <td style="padding:12px;border:1px solid var(--line);text-align:center">
                {{ ($items->firstItem() ?? 0) + $i }}
              </td>

              {{-- รุ่น/แบรนด์ --}}
              <td style="padding:12px;border:1px solid var(--line)">
                <div href="{{ route('admin.phones.edit', $row) }}"
                   style="color:var(--primary); font-weight:600">
                  {{ $row->Model }}
                </div>
                <div style="color:#6b7280; font-size:12px">{{ $row->brand->Brand ?? '-' }}</div>
                <div style="color:#6b7280; font-size:12px">
                  {{ $row->OS }} @if($row->Price !== null) • ฿{{ number_format($row->Price,2) }} @endif
                </div>
              </td>

              {{-- ภาพรูปแรก --}}
              <td style="padding:12px;border:1px solid var(--line);text-align:center">
                @php $img = $row->firstImage?->Img; @endphp
                @if($img)
                  <img src="{{ asset('storage/'.$img) }}" alt="{{ $row->Model }}"
                       style="width:150px;height:90px;object-fit:cover;border-radius:8px;display:inline-block">
                @else
                  <div style="width:150px;height:90px;border:1px dashed var(--line);border-radius:8px;
                              display:inline-flex;align-items:center;justify-content:center;color:#9ca3af;font-size:12px">
                    ไม่มีรูป
                  </div>
                @endif
              </td>

              <td style="padding:12px;border:1px solid var(--line);text-align:center">
                <a href="{{ route('admin.phones.edit', ['mobile' => $row->ID]) }}">✏️</a>
              </td>

              <td style="padding:12px;border:1px solid var(--line);text-align:center">
                <form method="POST"
                    action="{{ route('admin.phones.destroy', ['mobile' => $row->ID]) }}"
                    style="display:inline"
                    onsubmit="return confirm('คุณต้องการลบรายการนี้หรือไม่?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:none;border:none;cursor:pointer" title="ลบ">🗑️</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="padding:16px;border:1px solid var(--line);text-align:center;color:#64748b">
                ยังไม่มีข้อมูลมือถือ
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div style="margin-top:10px">
      {{ $items->links() }}
    </div>
  </div>
@endsection
