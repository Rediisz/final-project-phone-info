@extends('layouts.admin')

@section('title','ข้อมูลข่าว | Back Office')

@section('topbar')
  <h1>ข้อมูลข่าว</h1>
  <div style="display:flex; gap:8px">
    <a href="#" class="btn" style="background:#0f2342;color:#fff">+ เพิ่มข่าว</a>
  </div>
@endsection

@section('content')
  <div class="panel">
    <h3 style="margin-top:0; display:flex; align-items:center; gap:8px">
      📰 รายการข่าว
    </h3>

    <div style="overflow:auto">
      <table style="width:100%; border-collapse:collapse; background:#fff">
        <thead>
          <tr style="background:#f3f6fb">
            <th style="padding:10px; border:1px solid #e8eef5; width:90px">ลำดับ</th>
            <th style="padding:10px; border:1px solid #e8eef5">หัวข้อ</th>
            <th style="padding:10px; border:1px solid #e8eef5; width:180px">รูปภาพ</th>
            <th style="padding:10px; border:1px solid #e8eef5; width:120px">สถานะ</th>
            <th style="padding:10px; border:1px solid #e8eef5; width:120px">แก้ไข</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $i => $row)
            <tr>
              <td style="padding:10px; border:1px solid #e8eef5; text-align:center">{{ $i+1 }}</td>
              <td style="padding:10px; border:1px solid #e8eef5">
                <a href="#" style="color:#0f2342; font-weight:600">{{ $row['title'] }}</a>
              </td>
              <td style="padding:10px; border:1px solid #e8eef5">
                <img src="{{ $row['image'] }}" alt="" style="width:150px; height:90px; object-fit:cover; border-radius:8px">
              </td>
              <td style="padding:10px; border:1px solid #e8eef5; text-align:center">
                @if($row['active'])
                    <span style="display:inline-block;width:14px;height:14px;border-radius:50%;background:#16a34a"></span>
                @else
                    <span style="display:inline-block;width:14px;height:14px;border-radius:50%;background:#ef4444"></span>
                @endif
              </td>

              <td style="padding:10px; border:1px solid #e8eef5; text-align:center">
                <a href="#" title="แก้ไข">✏️</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="padding:16px; text-align:center; color:#6b7280">ยังไม่มีรายการ</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
