@extends('layouts.admin')

@section('title','แก้ไขแบรนด์ | Back Office')

@section('topbar')
  <h1>แก้ไขแบรนด์</h1>
@endsection

@section('content')
  <div class="panel" style="max-width:600px;margin:auto">
    <form method="POST"
          action="{{ route('admin.brands.update', $brand->ID) }}"
          enctype="multipart/form-data"
          style="display:flex;flex-direction:column;gap:16px">
      @csrf
      @method('PUT')

      {{-- ชื่อแบรนด์ --}}
      <div>
        <label style="font-weight:600">ชื่อแบรนด์ <span style="color:#ef4444">*</span></label>
        <input type="text" name="Brand"
               value="{{ old('Brand', $brand->Brand) }}"
               style="width:100%;padding:8px;border:1px solid var(--line);border-radius:6px" required>
        @error('Brand')
          <div style="color:red;font-size:14px">{{ $message }}</div>
        @enderror
      </div>

      {{-- โลโก้ (พรีวิว + ปุ่มเลือกไฟล์ใหม่ แบบเดียวกับ banner) --}}
      <div>
        <label style="font-weight:600; display:block; margin-bottom:6px">โลโก้แบรนด์</label>

        {{-- พรีวิวรูปปัจจุบัน --}}
        <img id="brandLogoPreview"
             src="{{ $brand->Logo_Path ? asset('storage/'.$brand->Logo_Path) : asset('images/brand-placeholder.png') }}"
             alt="brand-logo"
             style="max-width:520px;height:auto;border:1px solid #e5e7eb;border-radius:8px;display:block;background:#fff">

        <input id="brandLogoInput" type="file" name="logo" accept="image/*" style="display:none">
        <button type="button" id="pickLogoBtn" class="btn"
                style="background:#f3f4f6;border:1px solid #d1d5db;padding:8px 12px;border-radius:8px;cursor:pointer;margin-top:8px">
          เลือกไฟล์ใหม่
        </button>
        <span id="logoFileName"
              style="display:inline-block; margin-left:10px; padding:4px 8px; background:#e6ffed; color:#065f46; border:1px solid #a7f3d0; border-radius:6px">
          ยังไม่ได้เลือกไฟล์
        </span>

        @error('logo')
          <div style="color:red;font-size:14px;margin-top:6px">{{ $message }}</div>
        @enderror
      </div>

      {{-- ลำดับการแสดงผล --}}
      <div>
        <label style="font-weight:600">ลำดับการแสดง (SortOrder)</label>
        <input type="number" name="SortOrder"
               value="{{ old('SortOrder', $brand->SortOrder ?? 0) }}"
               min="0" step="1"
               style="width:120px;padding:8px;border:1px solid var(--line);border-radius:6px">
        <div style="color:#6b7280;font-size:12px;margin-top:4px">
          0 = ไม่จัดลำดับเป็นพิเศษ (จะไปอยู่กลุ่มท้ายเรียงตามตัวอักษร), 1 = บนสุด, 2 = ถัดไป …
        </div>
      </div>

      {{-- สถานะการใช้งาน --}}
      <div style="display:flex;align-items:center;gap:8px">
        <input type="checkbox" name="IsActive" value="1" id="isActive"
               {{ old('IsActive', $brand->IsActive) ? 'checked' : '' }}>
        <label for="isActive">ใช้งาน</label>
      </div>

      {{-- ปุ่ม --}}
      <div style="display:flex;gap:8px">
        <button type="submit" class="btn" style="background:var(--primary);color:#fff;font-weight:600">บันทึก</button>
        <a href="{{ route('admin.brands.index') }}" class="btn" style="background:#ddd">ยกเลิก</a>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
<script>
  (function () {
    const input    = document.getElementById('brandLogoInput');
    const btn      = document.getElementById('pickLogoBtn');
    const fileName = document.getElementById('logoFileName');
    const preview  = document.getElementById('brandLogoPreview');

    btn.addEventListener('click', () => input.click());

    input.addEventListener('change', () => {
      const file = input.files && input.files[0];
      fileName.textContent = file ? file.name : 'ยังไม่ได้เลือกไฟล์';
      if (!file) return;

      const reader = new FileReader();
      reader.onload = e => {
        // อัปเดตพรีวิวให้เห็นรูปใหม่ทันที (ยังไม่บันทึก)
        preview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    });
  })();
</script>
@endpush
