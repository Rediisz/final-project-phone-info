@extends('layouts.admin')

@section('title','เพิ่มมือถือ | Back Office')

@section('topbar')
  <h1>เพิ่มมือถือ</h1>
@endsection

@section('content')
  @if ($errors->any())
    <div class="alert danger" style="max-width:980px;margin:0 auto 12px">
      <ul style="margin:0;padding-left:18px">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form method="post" action="{{ route('admin.phones.store') }}" enctype="multipart/form-data"
        class="panel" style="max-width:980px;margin:0 auto">
    @csrf

    <style>
    /* ฟิลด์หลัก: input, select, textarea */
    .input{
        width:100%;
        padding:10px 12px;
        border:1px solid #e8eef5;           /* สีกรอบอ่อน */
        border-radius:10px;                  /* ขอบมน */
        background:#fff;
        color:#0f2342;
        outline:none;
        transition:border-color .2s, box-shadow .2s;
    }
    .input:focus{
        border-color:#0f2342;                /* สีเข้มตอนโฟกัส */
        box-shadow:0 0 0 3px rgba(15,35,66,.08);
    }

    /* ให้ select ดูเรียบเหมือน input */
    select.input{
        -webkit-appearance:none;
        -moz-appearance:none;
        appearance:none;
        padding-right:36px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%239ca3af' viewBox='0 0 16 16'%3E%3Cpath d='M4 6l4 4 4-4'/%3E%3C/svg%3E");
        background-repeat:no-repeat;
        background-position:right 12px center;
        background-size:16px;
    }

        /* --- FILE INPUT: ปุ่มเลือกไฟล์แบบขอบดำ มน ๆ --- */
    input[type="file"].input{
    /* ซ่อนกรอบ native ของ input ทั้งก้อนให้เหลือแต่ปุ่ม */
    border: none;
    background: transparent;
    padding: 0;
    }

    /* ปุ่มเลือกไฟล์ (เบราว์เซอร์ใหม่) */
    input[type="file"].input::file-selector-button{
    margin-right: 10px;
    padding: 6px 12px;
    border: 1px solid #111827;   /* ขอบดำ */
    border-radius: 10px;          /* มนเหมือนตัวอย่าง */
    background: #fff;             /* พื้นขาว */
    color: #111827;               /* ตัวอักษรดำ */
    font-weight: 600;
    cursor: pointer;
    transition: background .2s, border-color .2s, box-shadow .2s;
    }
    input[type="file"].input:hover::file-selector-button{
    background: #f9fafb;          /* hover จาง ๆ */
    }
    input[type="file"].input:focus-visible::file-selector-button{
    outline: 2px solid rgba(15,35,66,.20);
    outline-offset: 2px;
    }

    /* Safari/Chrome legacy */
    input[type="file"].input::-webkit-file-upload-button{
    margin-right: 10px;
    padding: 6px 12px;
    border: 1px solid #111827;
    border-radius: 10px;
    background: #fff;
    color: #111827;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s, border-color .2s, box-shadow .2s;
    }
    input[type="file"].input:hover::-webkit-file-upload-button{
    background: #f9fafb;
    }

      .form-grid{display:grid;grid-template-columns:240px 1fr;row-gap:14px;column-gap:18px}
      .form-row label{font-weight:600;display:block;padding-top:8px}
      .file-hint{display:inline-block;margin-left:8px;padding:6px 10px;border-radius:8px;background:#dcfce7;color:#166534;font-size:13px}
      .preview-box{width:160px;height:96px;border:1px dashed #e5e7eb;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:12px;overflow:hidden}
      .thumbs{display:grid;grid-template-columns:repeat(6,1fr);gap:6px}
      .thumb{width:100%;aspect-ratio:1/1;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden}
      .thumb img{width:100%;height:100%;object-fit:cover}
      @media(max-width:820px){.form-grid{grid-template-columns:1fr}}
    </style>

    <div class="form-grid">

      {{-- แบรนด์ --}}
      <div class="form-row"><label>แบรนด์</label></div>
      <div>
        <select name="Brand_ID" class="input" required>
          <option value="">-- เลือกแบรนด์ --</option>
          @foreach($brands as $b)
            <option value="{{ $b->ID }}" {{ old('Brand_ID')==$b->ID?'selected':'' }}>{{ $b->Brand }}</option>
          @endforeach
        </select>
      </div>

      {{-- รุ่น --}}
      <div class="form-row"><label>ชื่อรุ่น (Model)</label></div>
      <div><input type="text" name="Model" class="input" value="{{ old('Model') }}" required></div>

      {{-- วันวางขาย --}}
      <div class="form-row"><label>วันวางขาย (LaunchDate)</label></div>
      <div><input type="date" name="LaunchDate" class="input" value="{{ old('LaunchDate') }}"></div>

      {{-- OS --}}
      <div class="form-row"><label>ระบบปฏิบัติการ (OS)</label></div>
      <div><input type="text" name="OS" class="input" value="{{ old('OS') }}"></div>

      {{-- Processor --}}
      <div class="form-row"><label>ชิปประมวลผล (Processor)</label></div>
      <div><input type="text" name="Processor" class="input" value="{{ old('Processor') }}"></div>

      {{-- RAM --}}
      <div class="form-row"><label>RAM (GB)</label></div>
      <div><input type="number" name="RAM_GB" class="input" value="{{ old('RAM_GB') }}" min="0"></div>

      {{-- Screen size --}}
      <div class="form-row"><label>ขนาดหน้าจอ (นิ้ว)</label></div>
      <div><input type="number" step="0.01" name="ScreenSize_in" class="input" value="{{ old('ScreenSize_in') }}" min="0"></div>

      {{-- Display --}}
      <div class="form-row"><label>ชนิดหน้าจอ (Display)</label></div>
      <div><input type="text" name="Display" class="input" value="{{ old('Display') }}"></div>

      {{-- Cameras --}}
      <div class="form-row"><label>กล้องหน้า (FrontCamera)</label></div>
      <div><input type="text" name="FrontCamera" class="input" value="{{ old('FrontCamera') }}"></div>

      <div class="form-row"><label>กล้องหลัง (BackCamera)</label></div>
      <div><input type="text" name="BackCamera" class="input" value="{{ old('BackCamera') }}"></div>

      {{-- Battery / Network / Material / Weight / Price --}}
      <div class="form-row"><label>แบตเตอรี่ (mAh)</label></div>
      <div><input type="number" name="Battery_mAh" class="input" value="{{ old('Battery_mAh') }}" min="0"></div>

      <div class="form-row"><label>เครือข่าย (Network)</label></div>
      <div><input type="text" name="Network" class="input" value="{{ old('Network') }}"></div>

      <div class="form-row"><label>วัสดุ (Material)</label></div>
      <div><input type="text" name="Material" class="input" value="{{ old('Material') }}"></div>

      <div class="form-row"><label>น้ำหนัก (กรัม)</label></div>
      <div><input type="number" name="Weight_g" class="input" value="{{ old('Weight_g') }}" min="0"></div>

      <div class="form-row"><label>ราคา (฿)</label></div>
      <div><input type="number" step="0.01" name="Price" class="input" value="{{ old('Price') }}" min="0"></div>

      {{-- Cover --}}
      <div class="form-row"><label>รูปปก (ใช้รูปแรกเป็นปกอัตโนมัติ)</label></div>
      <div>
        <input type="file" name="cover" id="coverInput" class="input" accept=".jpg,.jpeg,.png,.webp">
        <span id="coverHint" class="file-hint">ไม่ได้เลือกรูป</span>
        <div id="coverPreview" class="preview-box" style="margin-top:8px">พรีวิวรูปปก</div>
      </div>

      {{-- Gallery --}}
      <div class="form-row"><label>แกลเลอรี่ (อัปโหลดได้หลายรูป)</label></div>
      <div>
        <input type="file" name="images[]" id="galleryInput" class="input" accept=".jpg,.jpeg,.png,.webp" multiple>
        <span id="galleryHint" class="file-hint">0 ไฟล์</span>
        <div id="galleryPreview" class="thumbs" style="margin-top:8px"></div>
      </div>

      {{-- Actions --}}
      <div class="form-row"></div>
      <div style="margin-top:8px">
        <button class="btn" style="background:#0f2342;color:#fff">บันทึก</button>
        <a class="btn" href="{{ route('admin.phones.index') }}">ยกเลิก</a>
      </div>
    </div>
  </form>

  <script>
    // พรีวิว cover
    const coverInput = document.getElementById('coverInput');
    const coverPreview = document.getElementById('coverPreview');
    const coverHint = document.getElementById('coverHint');
    coverInput?.addEventListener('change', e=>{
      const f = e.target.files?.[0];
      if(!f){ coverPreview.innerHTML='พรีวิวรูปปก'; coverHint.textContent='ไม่ได้เลือกรูป'; return; }
      coverHint.textContent = f.name;
      const url = URL.createObjectURL(f);
      coverPreview.innerHTML = '';
      const img = new Image(); img.src = url; img.style.width='100%'; img.style.height='100%'; img.style.objectFit='cover';
      coverPreview.appendChild(img);
    });

    // พรีวิว gallery
    const gInput = document.getElementById('galleryInput');
    const gPreview = document.getElementById('galleryPreview');
    const gHint = document.getElementById('galleryHint');
    gInput?.addEventListener('change', e=>{
      const files = Array.from(e.target.files||[]);
      gHint.textContent = files.length + ' ไฟล์';
      gPreview.innerHTML='';
      files.forEach(f=>{
        const url = URL.createObjectURL(f);
        const box = document.createElement('div'); box.className='thumb';
        const img = new Image(); img.src=url; img.style.width='100%'; img.style.height='100%'; img.style.objectFit='cover';
        box.appendChild(img); gPreview.appendChild(box);
      });
    });
  </script>
@endsection
