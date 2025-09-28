@extends('layouts.admin')

@section('title','ข้อมูลสมาชิก | Back Office')

@section('topbar')
  <h1>ข้อมูลสมาชิก</h1>
  <div style="display:flex; gap:8px">
    <a href="{{route('admin.members.create')}}" class="btn" style="background:#0f2342;color:#fff">+ เพิ่มสมาชิก</a>
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
            <th style="padding:10px; border:1px solid #e8eef5; width:90px; text-align:center">ลบ</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $row)
            @php
              // avatar: ถ้ามีรูปใน Picture ให้เสิร์ฟจาก storage, ไม่มีก็ placeholder
              $avatar = $row->Picture
                ? asset('storage/'.str_replace('\\','/',$row->Picture))
                : asset('images/placeholder-user.png');

              $role = strtolower(optional($row->role)->RoleName ?? ($row->RoleID == 1 ? 'admin' : 'user'));
            @endphp

            <tr>
              <td style="padding:10px; border:1px solid #e8eef5; text-align:center">
                <img src="{{ $avatar }}" alt="avatar"
                    style="width:56px; height:56px; object-fit:cover; border-radius:50%; border:1px solid #e8eef5">
              </td>

              <td style="padding:10px; border:1px solid #e8eef5; font-weight:600; color:#0f2342">
                {{ $row->User_Name }}
              </td>

              <td style="padding:10px; border:1px solid #e8eef5">
                {{ $row->Email }}
              </td>

              <td style="padding:10px; border:1px solid #e8eef5">
                <span style="padding:4px 10px; border-radius:999px;
                            background:{{ $role==='admin' ? '#e8f4ff' : '#eef7ee' }};
                            color:{{ $role==='admin' ? '#0b5ed7' : '#16a34a' }};
                            font-weight:700; font-size:12px; display:inline-block;">
                  {{ $role }}
                </span>
              </td>

              <td style="padding:10px; border:1px solid #e8eef5; text-align:center">
                <a href="{{ route('admin.members.edit', $row->ID) }}" title="แก้ไข">✏️</a>
              </td>
              <td style="padding:10px; border:1px solid #e8eef5; text-align:center">
              @if($row->ID !== auth()->id())
                <form action="{{ route('admin.members.destroy', $row->ID) }}"
                      method="POST" style="display:inline"
                      onsubmit="return confirm('คุณต้องการลบผู้ใช้นี้หรือไม่?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" title="ลบ" style="background:none;border:none;cursor:pointer;font-size:18px">
                    🗑️
                  </button>
                </form>
              @else
                <span title="ไม่สามารถลบตัวเอง" style="opacity:.4;cursor:not-allowed">🗑️</span>
              @endif
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
