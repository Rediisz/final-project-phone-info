@extends('layouts.admin')

@section('title','ข้อมูลสมาชิก | Back Office')

@section('topbar')
  <h1>ข้อมูลสมาชิก</h1>
  <div style="display:flex; gap:8px">
    <a href="#" class="btn" style="background:#0f2342;color:#fff">+ เพิ่มสมาชิก</a>
  </div>
@endsection

@section('content')
  <div class="panel">
    <h3 style="margin-top:0; display:flex; align-items:center; gap:8px">
      👥 รายการสมาชิก
    </h3>

    <div style="overflow:auto">
      <table style="width:100%; border-collapse:collapse; background:#fff">
        <thead>
          <tr style="background:#f3f6fb">
            <th style="padding:10px; border:1px solid #e8eef5; width:100px; text-align:center">รูป</th>
            <th style="padding:10px; border:1px solid #e8eef5">ชื่อผู้ใช้</th>
            <th style="padding:10px; border:1px solid #e8eef5">อีเมล</th>
            <th style="padding:10px; border:1px solid #e8eef5; width:140px">สิทธิ์ผู้ใช้งาน</th>
            <th style="padding:10px; border:1px solid #e8eef5; width:120px; text-align:center">แก้ไข</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $row)
            <tr>
              <td style="padding:10px; border:1px solid #e8eef5; text-align:center">
                <img src="{{ $row['avatar'] ?? asset('images/placeholder-user.png') }}"
                     alt="#"
                     style="width:56px; height:56px; object-fit:cover; border-radius:50%; border:1px solid #e8eef5">
              </td>
              <td style="padding:10px; border:1px solid #e8eef5; font-weight:600; color:#0f2342">
                {{ $row['name'] }}
              </td>
              <td style="padding:10px; border:1px solid #e8eef5">
                {{ $row['email'] }}
              </td>
              <td style="padding:10px; border:1px solid #e8eef5">
                @php $role = strtolower($row['role'] ?? 'user'); @endphp
                <span style="padding:4px 10px; border-radius:999px;
                             background:{{ $role==='admin' ? '#e8f4ff' : '#eef7ee' }};
                             color:{{ $role==='admin' ? '#0b5ed7' : '#16a34a' }};
                             font-weight:700; font-size:12px; display:inline-block;">
                  {{ $role === 'admin' ? 'admin' : 'user' }}
                </span>
              </td>
              <td style="padding:10px; border:1px solid #e8eef5; text-align:center">
                <a href="#" title="แก้ไข">✏️</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="padding:16px; text-align:center; color:#6b7280">
                ยังไม่มีสมาชิก
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
