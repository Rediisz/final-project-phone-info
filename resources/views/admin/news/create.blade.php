@extends('layouts.admin')
@section('title','เพิ่มข่าว | Back Office')

@section('topbar')
  <h1>เพิ่มข่าว</h1>
@endsection

@section('content')
  @if ($errors->any())
    <div class="alert danger" style="max-width:980px;margin:0 auto 12px">
      <ul style="margin:0;padding-left:18px">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form method="post" action="{{ route('admin.news.store') }}" enctype="multipart/form-data"
        class="panel" style="max-width:980px;margin:0 auto">
    @csrf

    <style>
    .input{width:100%;padding:10px 12px;border:1px solid #e8eef5;border-radius:10px;background:#fff;color:#0f2342;outline:none;transition:border-color .2s,box-shadow .2s}
    .input:focus{border-color:#0f2342;box-shadow:0 0 0 3px rgba(15,35,66,.08)}
    input[type="file"].input{border:none;background:transparent;padding:0}
    input[type="file"].input::file-selector-button{margin-right:10px;padding:6px 12px;border:1px solid #111827;border-radius:10px;background:#fff;color:#111827;font-weight:600;cursor:pointer;transition:background .2s,border-color .2s,box-shadow .2s}
    input[type="file"].input:hover::file-selector-button{background:#f9fafb}
    input[type="file"].input:focus-visible::file-selector-button{outline:2px solid rgba(15,35,66,.20);outline-offset:2px}
    input[type="file"].input::-webkit-file-upload-button{margin-right:10px;padding:6px 12px;border:1px solid #111827;border-radius:10px;background:#fff;color:#111827;font-weight:600;cursor:pointer;transition:background .2s,border-color .2s,box-shadow .2s}
    input[type="file"].input:hover::-webkit-file-upload-button{background:#f9fafb}
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
      <div class="form-row"><label>แบรนด์</label></div>
      <div>
        <select name="Brand_ID" id="brandSelect" class="input" required>
          <option value="">-- เลือกแบรนด์ --</option>
          @foreach($brands as $b)
            <option value="{{ $b->ID }}" {{ old('Brand_ID')==$b->ID?'selected':'' }}>{{ $b->Brand }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-row"><label>รุ่น</label></div>
      <div>
        <select name="Mobile_ID" id="mobileSelect" class="input" required>
          <option value="">-- เลือกรุ่น --</option>
        </select>
      </div>

      <div class="form-row"><label>หัวข้อ</label></div>
      <div><input type="text" name="Title" class="input" value="{{ old('Title') }}" required></div>
      <div class="form-row"><label>เกริ่นนำ</label></div>
      <div><textarea name="Intro" class="input" rows="4">{{ old('Intro') }}</textarea></div>

      <div class="form-row"><label>รายละเอียดช่วงที่ 1</label></div>
      <div><textarea name="Details" class="input" rows="6" required>{{ old('Details') }}</textarea></div>

      <div class="form-row"><label>รายละเอียดช่วงที่ 2</label></div>
      <div><textarea name="Details2" class="input" rows="6">{{ old('Details2') }}</textarea></div>

      <div class="form-row"><label>รายละเอียดช่วงที่ 3</label></div>
      <div><textarea name="Details3" class="input" rows="6">{{ old('Details3') }}</textarea></div>
      <div class="form-row"><label>รูปปก (อัปโหลด 1 รูป)</label></div>
      <div>
        <input type="file" name="cover" id="coverInput" class="input" accept=".jpg,.jpeg,.png,.webp">
        <span id="coverHint" class="file-hint">ไม่ได้เลือกรูป</span>
        <div id="coverPreview" class="preview-box" style="margin-top:8px">พรีวิวรูปปก</div>
      </div>
      <div class="form-row"><label>แกลเลอรี (อัปโหลดได้หลายรูป)</label></div>
      <div>
        <input type="file" name="images[]" id="galleryInput" class="input" accept=".jpg,.jpeg,.png,.webp" multiple>
        <span id="galleryHint" class="file-hint">0 ไฟล์</span>
        <div id="galleryPreview" class="thumbs" style="margin-top:8px"></div>
      </div>

      <div class="form-row"></div>
      <div style="margin-top:8px">
        <button class="btn" style="background:#0f2342;color:#fff">บันทึก</button>
        <a class="btn" href="{{ route('admin.news.index') }}">ยกเลิก</a>
      </div>
    </div>
  </form>

  <script>
    //พรีวิวปก 
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

    //พรีวิวแกลเลอรี 
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

    const brandSel  = document.getElementById('brandSelect');
    const mobileSel = document.getElementById('mobileSelect');

    async function loadMobiles(brandId, selectedId = null){
      mobileSel.innerHTML = '<option value="">กำลังโหลด...</option>';
      if(!brandId){ mobileSel.innerHTML = '<option value="">-- เลือกรุ่น --</option>'; return; }
      const res = await fetch(`{{ route('admin.news.mobiles') }}?brand_id=${brandId}`, {credentials:'same-origin'});
      const rows = await res.json();
      mobileSel.innerHTML = '<option value="">-- เลือกรุ่น --</option>';
      rows.forEach(r=>{
        const opt = document.createElement('option');
        opt.value = r.ID; opt.textContent = r.Model;
        if(selectedId && String(selectedId)===String(r.ID)) opt.selected = true;
        mobileSel.appendChild(opt);
      });
    }
    brandSel?.addEventListener('change', e => loadMobiles(e.target.value));

    // ถ้า validate fail แล้วย้อนกลับมา มีค่าเก่า → เติมให้
    @if(old('Brand_ID'))
      loadMobiles('{{ old('Brand_ID') }}', '{{ old('Mobile_ID') }}');
    @endif
  </script>
@endsection
