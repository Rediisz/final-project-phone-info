@extends('layouts.admin')

@section('title','แบนเนอร์ | Back Office')

@section('topbar')
  <h1 >แบนเนอร์</h1>
  <div style="display:flex; gap:8px">
    <a class="btn"
       style="background:var(--primary);color:#fff;border-radius:8px;font-weight:600"
       href="#">+ เพิ่มแบนเนอร์</a>
  </div>
@endsection

@section('content')
  <div class="panel">
    <h3 style="margin:0 0 12px;font-size:16px;display:flex;align-items:center;gap:6px">
      📢 รายการแบนเนอร์
    </h3>

    <div style="overflow:auto">
      <table style="width:100%;border-collapse:collapse;background:#fff">
        <thead>
          <tr style="background:#f9fafb">
            <th style="padding:12px;border:1px solid var(--line);text-align:center;width:70px">ลำดับ</th>
            <th style="padding:12px;border:1px solid var(--line);text-align:left">หัวข้อ</th>
            <th style="padding:12px;border:1px solid var(--line);text-align:left;width:200px">รูปภาพ</th>
            <th style="padding:12px;border:1px solid var(--line);text-align:center;width:120px">สถานะ</th>
            <th style="padding:12px;border:1px solid var(--line);text-align:center;width:100px">แก้ไข</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="padding:12px;border:1px solid var(--line);text-align:center">1</td>
            <td style="padding:12px;border:1px solid var(--line);font-weight:600;color:var(--primary)">SmartSpec</td>
            <td style="padding:12px;border:1px solid var(--line)">
              <img src="{{ asset('images/placeholder.png') }}"
                   alt="banner"
                   style="width:150px;height:90px;object-fit:cover;border-radius:8px">
            </td>
            <td style="padding:12px;border:1px solid var(--line);text-align:center">
              <span style="display:inline-block;width:14px;height:14px;border-radius:50%;background:#16a34a"></span>
            </td>
            <td style="padding:12px;border:1px solid var(--line);text-align:center">
              <a href="#" title="แก้ไข">✏️</a>
            </td>
          </tr>
          <tr>
            <td style="padding:12px;border:1px solid var(--line);text-align:center">2</td>
            <td style="padding:12px;border:1px solid var(--line);font-weight:600;color:var(--primary)">SmartSpec</td>
            <td style="padding:12px;border:1px solid var(--line)">
              <img src="{{ asset('images/placeholder.png') }}"
                   alt="banner"
                   style="width:150px;height:90px;object-fit:cover;border-radius:8px">
            </td>
            <td style="padding:12px;border:1px solid var(--line);text-align:center">
              <span style="display:inline-block;width:14px;height:14px;border-radius:50%;background:#16a34a"></span>
            </td>
            <td style="padding:12px;border:1px solid var(--line);text-align:center">
              <a href="#" title="แก้ไข">✏️</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
@endsection
