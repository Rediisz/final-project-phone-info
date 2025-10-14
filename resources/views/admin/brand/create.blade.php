
@extends('layouts.admin')

@section('title','เพิ่มแบรนด์ | Back Office')

@section('topbar')
  <h1>เพิ่มแบรนด์</h1>
@endsection

@section('content')
  <div class="panel" style="max-width:600px;margin:auto">
    <form method="POST" action="{{ route('admin.brands.store') }}"
          enctype="multipart/form-data"
          style="display:flex;flex-direction:column;gap:16px">
      @csrf

      {{-- ชื่อแบรนด์ --}}
      <div>
        <label style="font-weight:600">ชื่อแบรนด์ <span style="color:#ef4444">*</span></label>
        <input type="text" name="Brand" value="{{ old('Brand') }}"
               style="width:100%;padding:8px;border:1px solid var(--line);border-radius:6px" required>
        @error('Brand')
          <div style="color:red;font-size:14px">{{ $message }}</div>
        @enderror
      </div>

      {{-- อัปโหลดโลโก้ (เหมือน banner: ปุ่มเลือกไฟล์ + แสดงชื่อไฟล์ + พรีวิว) --}}
      <div>
        <label style="font-weight:600; display:block; margin-bottom:6px">โลโก้แบรนด์ (PNG/JPG/WebP)</label>

        <input id="brandLogo" type="file" name="logo" accept="image/*" style="display:none">
        <button type="button" id="pickLogoBtn" class="btn"
                style="background:#f3f4f6;border:1px solid #d1d5db;padding:8px 12px;border-radius:8px;cursor:pointer">
          เลือกไฟล์
        </button>
        <span id="logoFileName"
              style="display:inline-block; margin-left:10px; padding:4px 8px; background:#e6ffed; color:#065f46; border:1px solid #a7f3d0; border-radius:6px">
          ไม่ได้เลือกไฟล์ใด
        </span>

        <div style="margin-top:10px">
          <img id="logoPreview" src="" alt=""
               style="max-width:520px; height:auto; border:1px solid #e5e7eb; border-radius:8px; display:none; background:#fff">
        </div>

        @error('logo')
          <div style="color:red;font-size:14px">{{ $message }}</div>
        @enderror
      </div>

      {{-- ลำดับการแสดงผล --}}
      <div>
        <label style="font-weight:600">ลำดับการแสดง (SortOrder)</label>
        <input type="number" name="SortOrder" value="{{ old('SortOrder',0) }}" min="0" step="1"
               style="width:120px;padding:8px;border:1px solid var(--line);border-radius:6px">
        <div style="color:#6b7280;font-size:12px;margin-top:4px">
          0 = ไม่จัดลำดับเป็นพิเศษ (จะเรียงตามตัวอักษร), 1 = บนสุด, 2 = ถัดไป …
        </div>
      </div>

      {{-- สถานะการใช้งาน --}}
      <div style="display:flex;align-items:center;gap:8px">
        <input type="checkbox" name="IsActive" value="1" id="isActive"
               {{ old('IsActive', true) ? 'checked' : '' }}>
        <label for="isActive">ใช้งาน</label>
      </div>

      {{-- ปุ่ม --}}
      <div style="display:flex;gap:8px">
        <button type="submit" class="btn" style="background:var(--primary);color:#fff;font-weight:600">บันทึก</button>
        <a href="{{ route('admin.brands.index') }}" class="btn" style="background:#ddd">ยกเลิก</a>
      </div>
    </form>
  </div>

  @push('scripts')
  <script>
    (function () {
      const input    = document.getElementById('brandLogo');
      const btn      = document.getElementById('pickLogoBtn');
      const fileName = document.getElementById('logoFileName');
      const preview  = document.getElementById('logoPreview');

      btn.addEventListener('click', () => input.click());

      input.addEventListener('change', () => {
        if (!input.files || !input.files[0]) {
          fileName.textContent = 'ไม่ได้เลือกไฟล์ใด';
          preview.style.display = 'none';
          preview.src = '';
          return;
        }

        const file = input.files[0];
        fileName.textContent = file.name;

        const reader = new FileReader();
        reader.onload = (e) => {
          preview.src = e.target.result;
          preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
      });
    })();
  </script>
  @endpush
@endsection
