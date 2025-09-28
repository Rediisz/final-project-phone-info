{{-- resources/views/admin/banners/edit.blade.php --}}
@extends('layouts.admin')

@section('title','แก้ไขแบนเนอร์ | Back Office')

@section('topbar')
  <h1>แก้ไขแบนเนอร์</h1>
@endsection

@section('content')
  <div class="panel" style="max-width:600px;margin:auto">
    <form method="POST"
          action="{{ route('admin.banners.update', $banner->getKey()) }}"
          enctype="multipart/form-data"
          style="display:flex;flex-direction:column;gap:16px">
      @csrf
      @method('PUT')

      <div>
        <label style="font-weight:600">หัวข้อ</label>
        <input type="text" name="bannerName"
               value="{{ old('bannerName', $banner->bannerName) }}"
               style="width:100%;padding:8px;border:1px solid var(--line);border-radius:6px">
        @error('bannerName')
          <div style="color:red;font-size:14px">{{ $message }}</div>
        @enderror
      </div>

      <div>
        <label style="font-weight:600; display:block; margin-bottom:6px">ไฟล์รูปภาพ</label>
        <img id="previewImg"
            src="{{ $banner->image_url }}"
            alt="banner"
            style="max-width:520px;height:auto;border:1px solid #e5e7eb;border-radius:8px;display:block">

        <input id="bannerImage" type="file" name="image" accept="image/*" style="display:none">
        <button type="button" id="pickImageBtn" class="btn"
                style="background:#f3f4f6;border:1px solid #d1d5db;padding:8px 12px;border-radius:8px;cursor:pointer">เลือกไฟล์ใหม่
        </button>
        <span id="fileName"
            style="display:inline-block; margin-left:10px; padding:4px 8px; background:#e6ffed; color:#065f46; border:1px solid #a7f3d0; border-radius:6px">ยังไม่ได้เลือกไฟล์
        </span>
        @error('image') <div style="color:red;font-size:14px">{{ $message }}</div> @enderror


        {{-- พรีวิวไฟล์ใหม่ที่เลือกยังไม่บันทึก --}}
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
        <input type="number" name="sort_order"
               value="{{ old('sort_order', $banner->sort_order) }}"
               style="width:100px;padding:8px;border:1px solid var(--line);border-radius:6px">
      </div>

      <div style="display:flex;align-items:center;gap:8px">
        <input type="checkbox" name="is_active" value="1"
               {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
        <label>ใช้งาน</label>
      </div>

      <div style="display:flex;gap:8px">
        <button type="submit" class="btn" style="background:var(--primary);color:#fff;font-weight:600">บันทึก</button>
        <a href="{{ route('admin.banners.index') }}" class="btn" style="background:#ddd">ยกเลิก</a>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
<script>
  (function () {
    const input = document.getElementById('bannerImage');
    const btn = document.getElementById('pickImageBtn');
    const fileName = document.getElementById('fileName');
    const img = document.getElementById('previewImg');

    btn.addEventListener('click', () => input.click());

    input.addEventListener('change', () => {
      const file = input.files && input.files[0];
      fileName.textContent = file ? file.name : 'ยังไม่ได้เลือกไฟล์';
      if (!file) return;

      const reader = new FileReader();
      reader.onload = e => {
        // อัปเดต src ของรูปเดิมให้เป็นรูปใหม่ทับเลย
        img.src = e.target.result;
      };
      reader.readAsDataURL(file);
    });
  })();
</script>
@endpush

