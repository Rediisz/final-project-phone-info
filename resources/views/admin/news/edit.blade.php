@extends('layouts.admin')
@section('title','แก้ไขข่าว | Back Office')

@section('topbar')
  <h1>แก้ไขข่าว</h1>
@endsection

@section('content')
  @if ($errors->any())
    <div class="alert danger" style="max-width:980px;margin:0 auto 12px">
      <ul style="margin:0;padding-left:18px">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form method="post" action="{{ route('admin.news.update',$news->ID) }}" enctype="multipart/form-data"
        class="panel" style="max-width:980px;margin:0 auto">
    @csrf @method('PUT')

    <style>
      .input{width:100%;padding:10px 12px;border:1px solid #e8eef5;border-radius:10px;background:#fff;color:#0f2342;outline:none;transition:border-color .2s,box-shadow .2s}
      .input:focus{border-color:#0f2342;box-shadow:0 0 0 3px rgba(15,35,66,.08)}
      .form-grid{display:grid;grid-template-columns:240px 1fr;row-gap:14px;column-gap:18px}
      .form-row label{font-weight:600;display:block;padding-top:8px}

      /* gallery เหมือนหน้า phones (ใช้ JS toggle class .selected) */
      .thumbs{display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:10px}
      .thumb{position:relative;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;background:#fff;cursor:pointer}
      .thumb img{width:100%;height:120px;object-fit:cover;display:block}
      .thumb .badge{position:absolute;top:6px;left:6px;background:#fff;padding:2px 6px;border-radius:999px;border:1px solid #e5e7eb;font-size:11px}
      .thumb.selected{outline:3px solid #dc2626}
      .thumb.selected::after{content:"ลบ";position:absolute;top:6px;right:6px;background:#dc2626;color:#fff;font-size:11px;padding:2px 8px;border-radius:999px}

      .preview-box{border:2px dashed #e5e7eb;border-radius:10px;min-height:140px;display:flex;align-items:center;justify-content:center;background:#fff;overflow:hidden}
      .preview-box img{max-width:100%;max-height:240px}
      .chips{display:flex;gap:8px;flex-wrap:wrap;margin-top:8px}
      .chip{border:1px solid #e5e7eb;background:#fff;border-radius:999px;padding:4px 10px;font-size:12px}

      @media(max-width:820px){.form-grid{grid-template-columns:1fr}}
    </style>

    <div class="form-grid">
      <div class="form-row"><label>แบรนด์</label></div>
      <div>
        <select name="Brand_ID" id="brandSelect" class="input" required>
          <option value="">-- เลือกแบรนด์ --</option>
          @foreach($brands as $b)
            <option value="{{ $b->ID }}" {{ (old('Brand_ID',$news->Brand_ID)==$b->ID)?'selected':'' }}>{{ $b->Brand }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-row"><label>รุ่น</label></div>
      <div>
        <select name="Mobile_ID" id="mobileSelect" class="input" required>
          <option value="">-- เลือกรุ่น --</option>
          @foreach(($mobiles ?? []) as $m)
            <option value="{{ $m->ID }}" {{ (old('Mobile_ID',$news->Mobile_ID)==$m->ID)?'selected':'' }}>{{ $m->Model }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-row"><label>หัวข้อ</label></div>
      <div><input type="text" name="Title" class="input" value="{{ old('Title',$news->Title) }}" required></div>

      <div class="form-row"><label>เกริ่นนำ (Intro)</label></div>
      <div><textarea name="Intro" class="input" rows="4">{{ old('Intro',$news->Intro) }}</textarea></div>

      <div class="form-row"><label>รายละเอียดช่วงที่ 1</label></div>
      <div><textarea name="Details" class="input" rows="6" required>{{ old('Details',$news->Details) }}</textarea></div>

      <div class="form-row"><label>รายละเอียดช่วงที่ 2</label></div>
      <div><textarea name="Details2" class="input" rows="6">{{ old('Details2',$news->Details2) }}</textarea></div>

      <div class="form-row"><label>รายละเอียดช่วงที่ 3</label></div>
      <div><textarea name="Details3" class="input" rows="6">{{ old('Details3',$news->Details3) }}</textarea></div>

      <div class="form-row"><label>วันที่นำเข้าข่าว</label></div>
      <div>
        <div class="input" style="background:#f9fafb" aria-readonly="true">
          {{ optional($news->Date)->format('Y-m-d H:i:s') }}
        </div>
        <div class="muted" style="font-size:12px;color:#6b7280">ใช้จัดเรียงข่าวใหม่ก่อน–เก่าทีหลัง</div>
      </div>

      <div class="form-row"><label>อัปโหลดปกใหม่</label></div>
      <div>
        <input type="file" name="cover" id="coverInput" class="input" accept="image/*">
        <span id="coverHint" class="file-hint">ไม่ได้เลือกรูป</span>
        <div style="display:flex;gap:16px;margin-top:10px;align-items:flex-start">
          <div>
            <div style="font-size:12px;color:#6b7280;margin-bottom:6px">ปกปัจจุบัน</div>
            <img src="{{ $news->coverUrl() }}" style="width:200px;height:120px;object-fit:contain;border:1px solid #e5e7eb;border-radius:8px">
          </div>
          <div>
            <div style="font-size:12px;color:#6b7280;margin-bottom:6px">พรีวิวปกใหม่</div>
            <div id="coverPreview" class="preview-box">พรีวิวปก</div>
          </div>
        </div>
      </div>

      <div class="form-row"><label>เพิ่มรูปแกลเลอรี</label></div>
      <div>
        <input type="file" name="images[]" id="galleryInput" class="input" accept="image/*" multiple>
        <div class="chips" id="galleryInfo"></div>
        <div id="galleryPreviewNew" class="thumbs" style="margin-top:8px"></div>
      </div>

      <div class="form-row"><label>แกลเลอรีปัจจุบัน</label></div>
      <div>
        @php $gallery = $news->images->where('IsCover',0); @endphp
        @if($gallery->count())
          <div class="thumbs" id="existingGallery">
            @foreach($gallery as $img)
              <div class="thumb" data-id="{{ $img->ID }}">
                <img src="{{ asset('storage/'.$img->Img) }}" alt="">
                <span class="badge">เดิม</span>
              </div>
            @endforeach
          </div>

          <div id="deleteBucket" style="display:none"></div>

          <div style="font-size:12px;color:#6b7280;margin-top:6px">
            คลิกที่รูปเพื่อเลือก/ยกเลิกลบ (รูป “ปก” แยกแสดงด้านบน)
          </div>
        @else
          <div class="muted" style="color:#6b7280">ยังไม่มีรูป</div>
        @endif
      </div>

      <div class="form-row"></div>
      <div style="margin-top:8px">
        <button class="btn" style="background:#0f2342;color:#fff">บันทึก</button>
        <a class="btn" href="{{ route('admin.news.index') }}">กลับ</a>
      </div>
    </div>
  </form>

  <script>
  //COVER PREVIEW 
  const coverInput = document.getElementById('coverInput');
  const coverPreview = document.getElementById('coverPreview');
  const coverHint = document.getElementById('coverHint');
  coverInput?.addEventListener('change', e=>{
    const f = e.target.files?.[0];
    coverPreview.innerHTML='';
    if(!f){ coverPreview.textContent='พรีวิวปก'; coverHint.textContent='ไม่ได้เลือกรูป'; return; }
    coverHint.textContent = f.name;
    const img=new Image(); img.src=URL.createObjectURL(f);
    img.onload=()=>URL.revokeObjectURL(img.src);
    coverPreview.appendChild(img);
  });

  //NEW GALLERY PREVIEW 
  const gInput=document.getElementById('galleryInput');
  const gWrap=document.getElementById('galleryPreviewNew');
  const gInfo=document.getElementById('galleryInfo');
  function refreshNewGallery(){
    gWrap.innerHTML=''; gInfo.innerHTML='';
    Array.from(gInput.files).forEach((file,idx)=>{
      const card=document.createElement('div'); card.className='thumb';
      const img=document.createElement('img'); img.src=URL.createObjectURL(file);
      img.onload=()=>URL.revokeObjectURL(img.src);
      card.appendChild(img);
      card.addEventListener('click',()=>{
        const keep=Array.from(gInput.files).filter((_,i)=>i!==idx);
        const dt=new DataTransfer(); keep.forEach(f=>dt.items.add(f));
        gInput.files=dt.files; refreshNewGallery();
      });
      gWrap.appendChild(card);
    });
    if(gInput.files.length){
      const chip=document.createElement('span'); chip.className='chip';
      chip.textContent=gInput.files.length+' ไฟล์'; gInfo.appendChild(chip);
    }
  }
  gInput?.addEventListener('change',refreshNewGallery);

  //GALLERY TOGGLE DELETE 
  const existing=document.getElementById('existingGallery');
  const bucket=document.getElementById('deleteBucket');
  existing?.addEventListener('click',e=>{
    const card=e.target.closest('.thumb');
    if(!card) return;
    const id=card.dataset.id;
    card.classList.toggle('selected');

    const existed=bucket.querySelector('input[data-id="'+id+'"]');
    if(card.classList.contains('selected')){
      if(!existed){
        const hid=document.createElement('input');
        hid.type='hidden';
        hid.name='remove_image_ids[]';
        hid.value=id;
        hid.setAttribute('data-id', id);
        bucket.appendChild(hid);
      }
    }else{
      existed?.remove();
    }
  });

  // โหลดรุ่นตามแบรนด์
  const brandSel  = document.getElementById('brandSelect');
  const mobileSel = document.getElementById('mobileSelect');
  async function loadMobiles(brandId, selectedId=null){
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
  </script>
@endsection
