@extends('layouts.admin')
@section('title','ข้อมูลข่าว | Back Office')

@section('topbar')
  <h1>ข้อมูลข่าว</h1>
  <div style="display:flex; gap:8px">
    <a class="btn" style="background:var(--primary);color:#fff" href="{{ route('admin.news.create') }}">+ เพิ่มข่าว</a>
  </div>
@endsection

@section('content')
<div class="panel">
  <h3 style="margin:0 0 12px;font-size:16px;display:flex;align-items:center;gap:6px">📰 รายการข่าว</h3>

  <div style="overflow:auto">
    <table style="width:100%;border-collapse:collapse;background:#fff;table-layout:fixed">
      {{-- ให้สัดส่วนเท่ากับหน้า phones --}}
      <colgroup>
        <col style="width:80px">   {{-- ลำดับ --}}
        <col>                      {{-- หัวข้อ --}}
        <col style="width:220px">  {{-- รูปภาพ --}}
        <col style="width:90px">   {{-- แก้ไข --}}
        <col style="width:80px">   {{-- ลบ --}}
      </colgroup>

      <thead>
        <tr style="background:#f9fafb">
          <th style="padding:12px;border:1px solid var(--line);text-align:center">ลำดับ</th>
          <th style="padding:12px;border:1px solid var(--line);text-align:center">หัวข้อ</th>
          <th style="padding:12px;border:1px solid var(--line);text-align:center">รูปภาพ</th>
          <th style="padding:12px;border:1px solid var(--line);text-align:center">แก้ไข</th>
          <th style="padding:12px;border:1px solid var(--line);text-align:center">ลบ</th>
        </tr>
      </thead>

      <tbody>
        @forelse($items as $i => $item)
          <tr>
            <td style="padding:12px;border:1px solid var(--line);text-align:center">
              {{ ($items->firstItem() ?? 0) + $i }}
            </td>

            <td style="padding:12px;border:1px solid var(--line)">
              <div href="{{ route('admin.news.edit', $item->ID) }}"
                 style="color:var(--primary);font-weight:600">
                {{ $item->Title }}
              </div>
              <div style="color:#6b7280;font-size:12px">
                {{ $item->brand->Brand ?? '-' }} @if($item->mobile) • {{ $item->mobile->Model }} @endif
              </div>
            </td>

            <td style="padding:12px;border:1px solid var(--line);text-align:center">
              @php $img = $item->coverUrl(); @endphp
              @if($img)
                <img src="{{ $img }}" alt="{{ $item->Title }}"
                     style="width:150px;height:150px;object-fit:cover;border-radius:8px;display:inline-block">
              @else
                <div style="width:150px;height:150px;border:1px dashed var(--line);border-radius:8px;
                            display:inline-flex;align-items:center;justify-content:center;color:#9ca3af;font-size:12px">
                  ไม่มีรูป
                </div>
              @endif
            </td>

            <td style="padding:12px;border:1px solid var(--line);text-align:center">
              <a href="{{ route('admin.news.edit', ['news' => $item->ID]) }}">✏️</a>
            </td>

            <td style="padding:12px;border:1px solid var(--line);text-align:center">
              <form method="POST"
                    action="{{ route('admin.news.destroy', ['news' => $item->ID]) }}"
                    style="display:inline"
                    onsubmit="return confirm('คุณต้องการลบข่าวนี้หรือไม่?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="background:none;border:none;cursor:pointer" title="ลบ">🗑️</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" style="padding:16px;border:1px solid var(--line);text-align:center;color:#64748b">
              ยังไม่มีข่าว
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:10px">
    {{ $items->links() }}
  </div>
</div>
@endsection
