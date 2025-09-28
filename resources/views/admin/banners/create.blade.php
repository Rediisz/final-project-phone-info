@extends('layouts.admin')

@section('title','เพิ่มแบนเนอร์ | Back Office')

@section('topbar')
  <h1>เพิ่มแบนเนอร์</h1>
@endsection

@section('content')
  <div class="panel" style="max-width:600px;margin:auto">
    <form method="POST" action="{{ route('admin.banners.store') }}"
          enctype="multipart/form-data"
          style="display:flex;flex-direction:column;gap:16px">
      @csrf

      <div>
        <label style="font-weight:600">ชื่อแบนเนอร์</label>
        <input type="text" name="bannerName" value="{{ old('bannerName') }}"
               style="width:100%;padding:8px;border:1px solid var(--line);border-radius:6px">
        @error('bannerName')
          <div style="color:red;font-size:14px">{{ $message }}</div>
        @enderror
      </div>

      {{-- อัปโหลดไฟล์ --}}
      <div>
        <label style="font-weight:600; display:block; margin-bottom:6px">ไฟล์รูปภาพ</label>

        <input id="bannerImage" type="file" name="image" accept="image/*" style="display:none">
        <button type="button" id="pickImageBtn" class="btn"
                style="background:#f3f4f6;border:1px solid #d1d5db;padding:8px 12px;border-radius:8px;cursor:pointer">
          เลือกไฟล์
        </button>
        <span id="fileName"
              style="display:inline-block; margin-left:10px; padding:4px 8px; background:#e6ffed; color:#065f46; border:1px solid #a7f3d0; border-radius:6px">
          ไม่ได้เลือกไฟล์ใด
        </span>

        <div style="margin-top:10px">
          <img id="previewImg" src="" alt=""
               style="max-width:520px; height:auto; border:1px solid #e5e7eb; border-radius:8px; display:none">
        </div>

        @error('image')
          <div style="color:red;font-size:14px">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label style="font-weight:600">ลำดับการแสดง (sort_order)</label>
        <input type="number" name="sort_order" value="{{ old('sort_order',0) }}"
               style="width:100px;padding:8px;border:1px solid var(--line);border-radius:6px">
      </div>

      <div style="display:flex;align-items:center;gap:8px">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
        <label>ใช้งาน</label>
      </div>

      <div style="display:flex;gap:8px">
        <button type="submit" class="btn" style="background:var(--primary);color:#fff;font-weight:600">บันทึก</button>
        <a href="{{ route('admin.banners.index') }}" class="btn" style="background:#ddd">ยกเลิก</a>
      </div>
    </form>
  </div>

  @push('scripts')
  <script>
    (function () {
      const input    = document.getElementById('bannerImage');
      const btn      = document.getElementById('pickImageBtn');
      const fileName = document.getElementById('fileName');
      const preview  = document.getElementById('previewImg');

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
