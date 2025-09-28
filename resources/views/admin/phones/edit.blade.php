@extends('layouts.admin')

@section('title','แก้ไขมือถือ | Back Office')

@section('topbar')
  <h1>แก้ไขมือถือ</h1>
@endsection

@section('content')
  @if ($errors->any())
    <div class="alert danger" style="max-width:980px;margin:0 auto 12px">
      <ul style="margin:0;padding-left:18px">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form method="post"
      action="{{ route('admin.phones.update', ['mobile' => $mobile->getKey()]) }}"
      enctype="multipart/form-data"
      class="panel" style="max-width:980px;margin:0 auto">
    @csrf
    @method('PUT')

    <style>
      .input{width:100%;padding:10px 12px;border:1px solid #e8eef5;border-radius:10px;background:#fff;color:#0f2342;outline:none;transition:border-color .2s, box-shadow .2s}
      .input:focus{border-color:#0f2342;box-shadow:0 0 0 3px rgba(15,35,66,.08)}
      .form-grid{display:grid;grid-template-columns:240px 1fr;row-gap:14px;column-gap:18px}
      .form-row label{font-weight:600;display:block;padding-top:8px}
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
        <select name="Brand_ID" class="input" required>
          @foreach($brands as $b)
            <option value="{{ $b->ID }}" {{ (old('Brand_ID',$mobile->Brand_ID)==$b->ID)?'selected':'' }}>{{ $b->Brand }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-row"><label>ชื่อรุ่น (Model)</label></div>
      <div><input type="text" name="Model" class="input" value="{{ old('Model',$mobile->Model) }}" required></div>

      <div class="form-row"><label>วันวางขาย (LaunchDate)</label></div>
      <div><input type="date" name="LaunchDate" class="input" value="{{ old('LaunchDate',$mobile->LaunchDate) }}"></div>

      <div class="form-row"><label>ระบบปฏิบัติการ (OS)</label></div>
      <div><input type="text" name="OS" class="input" value="{{ old('OS',$mobile->OS) }}"></div>

      <div class="form-row"><label>ชิปประมวลผล (Processor)</label></div>
      <div><input type="text" name="Processor" class="input" value="{{ old('Processor',$mobile->Processor) }}"></div>

      <div class="form-row"><label>RAM (GB)</label></div>
      <div><input type="number" name="RAM_GB" class="input" value="{{ old('RAM_GB',$mobile->RAM_GB) }}" min="0"></div>

      <div class="form-row"><label>ขนาดหน้าจอ (นิ้ว)</label></div>
      <div><input type="number" step="0.01" name="ScreenSize_in" class="input" value="{{ old('ScreenSize_in',$mobile->ScreenSize_in) }}" min="0"></div>

      <div class="form-row"><label>ชนิดหน้าจอ (Display)</label></div>
      <div><input type="text" name="Display" class="input" value="{{ old('Display',$mobile->Display) }}"></div>

      <div class="form-row"><label>กล้องหน้า (FrontCamera)</label></div>
      <div><input type="text" name="FrontCamera" class="input" value="{{ old('FrontCamera',$mobile->FrontCamera) }}"></div>

      <div class="form-row"><label>กล้องหลัง (BackCamera)</label></div>
      <div><input type="text" name="BackCamera" class="input" value="{{ old('BackCamera',$mobile->BackCamera) }}"></div>

      <div class="form-row"><label>แบตเตอรี่ (mAh)</label></div>
      <div><input type="number" name="Battery_mAh" class="input" value="{{ old('Battery_mAh',$mobile->Battery_mAh) }}" min="0"></div>

      <div class="form-row"><label>เครือข่าย (Network)</label></div>
      <div><input type="text" name="Network" class="input" value="{{ old('Network',$mobile->Network) }}"></div>

      <div class="form-row"><label>วัสดุ (Material)</label></div>
      <div><input type="text" name="Material" class="input" value="{{ old('Material',$mobile->Material) }}"></div>

      <div class="form-row"><label>น้ำหนัก (กรัม)</label></div>
      <div><input type="number" name="Weight_g" class="input" value="{{ old('Weight_g',$mobile->Weight_g) }}" min="0"></div>

      <div class="form-row"><label>ราคา (฿)</label></div>
      <div><input type="number" step="0.01" name="Price" class="input" value="{{ old('Price',$mobile->Price) }}" min="0"></div>

      <div class="form-row"><label>อัปโหลดรูปปกใหม่ (ถ้ามี)</label></div>
      <div>
        <input type="file" name="cover" id="coverInput" class="input" accept="image/*">
        <div id="coverPreview" class="preview-box" style="margin-top:8px">
          @php $cover = $mobile->images->firstWhere('IsCover',1); @endphp
          @if($cover)
            <img src="{{ asset('storage/'.$cover->Img) }}" alt="cover">
          @else
            <span style="color:#6b7280">ยังไม่มีรูปปก</span>
          @endif
        </div>
      </div>

      <div class="form-row"><label>เพิ่มรูปแกลเลอรี่</label></div>
      <div>
        <input type="file" name="images[]" id="galleryInput" class="input" accept="image/*" multiple>
        <div class="chips" id="galleryInfo"></div>
        <div id="galleryPreviewNew" class="thumbs" style="margin-top:8px"></div>
      </div>

      <div class="form-row"><label>รูปเดิม</label></div>
      <div>
        @if($mobile->images->where('IsCover',0)->count())
          <div class="thumbs" id="existingGallery">
            @foreach($mobile->images->where('IsCover',0) as $img)
              <div class="thumb" data-id="{{ $img->ID }}">
                <img src="{{ asset('storage/'.$img->Img) }}" alt="">
                <span class="badge">เดิม</span>
              </div>
            @endforeach
          </div>
          <div id="deleteBucket"></div>
          <div style="font-size:12px;color:#6b7280;margin-top:6px">คลิกที่รูปเพื่อเลือก/ยกเลิกลบ</div>
        @else
          <div style="color:#6b7280">ยังไม่มีรูป</div>
        @endif
      </div>

      <div class="form-row"></div>
      <div style="margin-top:8px">
        <button class="btn" style="background:#0f2342;color:#fff">บันทึกการแก้ไข</button>
        <a class="btn" href="{{ route('admin.phones.index') }}">ยกเลิก</a>
      </div>
    </div>
  </form>

  <script>
  (function(){
    //COVER PREVIEW
    const coverInput = document.getElementById('coverInput');
    const coverPreview = document.getElementById('coverPreview');
    coverInput?.addEventListener('change', e=>{
      coverPreview.innerHTML = '';
      const f = e.target.files?.[0];
      if(!f){coverPreview.innerHTML='<span style="color:#6b7280">ยังไม่มีรูปปก</span>';return;}
      const img=document.createElement('img');
      img.src=URL.createObjectURL(f);
      img.onload=()=>URL.revokeObjectURL(img.src);
      coverPreview.appendChild(img);
    });

    //NEW GALLERY PREVIEW 
    const gInput=document.getElementById('galleryInput');
    const gWrap=document.getElementById('galleryPreviewNew');
    const gInfo=document.getElementById('galleryInfo');
    function refreshNewGallery(){
      gWrap.innerHTML=''; gInfo.innerHTML='';
      const dt=new DataTransfer();
      Array.from(gInput.files).forEach((file,idx)=>{
        const card=document.createElement('div');
        card.className='thumb';
        const img=document.createElement('img');
        img.src=URL.createObjectURL(file);
        img.onload=()=>URL.revokeObjectURL(img.src);
        card.appendChild(img);
        card.addEventListener('click',()=>{
          const keep=Array.from(gInput.files).filter((_,i)=>i!==idx);
          const dt2=new DataTransfer();
          keep.forEach(f=>dt2.items.add(f));
          gInput.files=dt2.files;refreshNewGallery();
        });
        gWrap.appendChild(card);
        dt.items.add(file);
      });
      if(gInput.files.length){
        const chip=document.createElement('span');
        chip.className='chip';
        chip.textContent=gInput.files.length+' ไฟล์';
        gInfo.appendChild(chip);
      }
    }

    gInput?.addEventListener('change',refreshNewGallery);
    const existing=document.getElementById('existingGallery');
    const bucket=document.getElementById('deleteBucket');
    existing?.addEventListener('click',e=>{
      const card=e.target.closest('.thumb');
      if(!card)return;
      const id=card.dataset.id;
      card.classList.toggle('selected');
      const existed=bucket.querySelector('input[value="'+id+'"]');
      if(card.classList.contains('selected')){
        if(!existed){
          const hid=document.createElement('input');
          hid.type='hidden'; hid.name='remove_image_ids[]'; hid.value=id;
          bucket.appendChild(hid);
        }
      }else{
        existed?.remove();
      }
    });
  })();
  </script>
@endsection
