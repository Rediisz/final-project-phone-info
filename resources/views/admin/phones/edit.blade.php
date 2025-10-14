@extends('layouts.admin')

@section('title','แก้ไขมือถือ | Back Office')

@section('topbar')
  <h1>แก้ไขมือถือ: {{ $mobile->Model }}</h1>
@endsection

@section('content')
  @if ($errors->any())
    <div class="alert danger" style="max-width:980px;margin:0 auto 12px">
      <ul style="margin:0;padding-left:18px">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form method="post" action="{{ route('admin.phones.update', $mobile->ID) }}" enctype="multipart/form-data"
        class="panel" style="max-width:980px;margin:0 auto">
    @csrf
    @method('PUT')

    <style>
      .input{
        width:100%; padding:10px 12px; border:1px solid #e8eef5; border-radius:10px;
        background:#fff; color:#0f2342; outline:none; transition:border-color .2s, box-shadow .2s;
      }
      .input:focus{ border-color:#0f2342; box-shadow:0 0 0 3px rgba(15,35,66,.08); }
      select.input{
        -webkit-appearance:none; -moz-appearance:none; appearance:none; padding-right:36px;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%239ca3af' viewBox='0 0 16 16'%3E%3Cpath d='M4 6l4 4 4-4'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:right 12px center; background-size:16px;
      }
      input[type="file"].input{ border:none; background:transparent; padding:0; }
      input[type="file"].input::file-selector-button,
      input[type="file"].input::-webkit-file-upload-button{
        margin-right:10px; padding:6px 12px; border:1px solid #111827; border-radius:10px;
        background:#fff; color:#111827; font-weight:600; cursor:pointer;
        transition:background .2s, border-color .2s, box-shadow .2s;
      }
      input[type="file"].input:hover::file-selector-button,
      input[type="file"].input:hover::-webkit-file-upload-button{ background:#f9fafb; }
      input[type="file"].input:focus-visible::file-selector-button{ outline:2px solid rgba(15,35,66,.20); outline-offset:2px; }

      .form-grid{display:grid;grid-template-columns:240px 1fr;row-gap:14px;column-gap:18px}
      .form-row label{font-weight:600;display:block;padding-top:8px}
      .file-hint{display:inline-block;margin-left:8px;padding:6px 10px;border-radius:8px;background:#dcfce7;color:#166534;font-size:13px}
      .preview-box{width:160px;height:96px;border:1px dashed #e5e7eb;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:12px;overflow:hidden}
      .thumbs{display:grid;grid-template-columns:repeat(6,1fr);gap:6px}
      .thumb{width:100%;aspect-ratio:1/1;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;position:relative}
      .thumb img{width:100%;height:100%;object-fit:cover}
      .section{grid-column:1 / -1; margin:10px 0; padding:10px 12px; background:#f3f6fb; border:1px solid #e8eef5; border-radius:10px; font-weight:700; color:#0f2342}
      .inline{display:flex;gap:14px;flex-wrap:wrap}
      .check{display:flex;align-items:center;gap:8px}
      .muted{color:#6b7280;font-size:13px}
      @media(max-width:820px){.form-grid{grid-template-columns:1fr}}

      /* --- ลบรูปแบบคลิกให้ขึ้นกรอบแดง --- */
      .thumb.removable{cursor:pointer;border:2px solid transparent;transition:border-color .2s, box-shadow .2s}
      .thumb.removable:hover{box-shadow:0 1px 6px rgba(0,0,0,.08)}
      .thumb.removable.selected{border-color:#dc2626; box-shadow:0 0 0 3px rgba(220,38,38,.2)}
      .thumb.removable input[type="checkbox"]{display:none}
      .thumb .badge-cover{
        position:absolute; left:6px; bottom:6px; background:#0f2342; color:#fff;
        font-size:11px; padding:2px 6px; border-radius:999px; opacity:.9
      }
    </style>

    <div class="form-grid">
      <div class="section">ข้อมูลหลัก</div>

      <div class="form-row"><label>แบรนด์ *</label></div>
      <div>
        <select name="Brand_ID" class="input" required>
          @foreach($brands as $b)
            <option value="{{ $b->ID }}" {{ old('Brand_ID', $mobile->Brand_ID)==$b->ID?'selected':'' }}>{{ $b->Brand }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-row"><label>Model *</label></div>
      <div><input type="text" name="Model" class="input" value="{{ old('Model', $mobile->Model) }}" required maxlength="150"></div>

      <div class="form-row"><label>FullName</label></div>
      <div><input type="text" name="FullName" class="input" value="{{ old('FullName', $mobile->FullName) }}" maxlength="100"></div>

      <div class="form-row"><label>Series / Variant</label></div>
      <div class="inline">
        <input type="text" name="Series" class="input" style="flex:1" placeholder="Series" value="{{ old('Series', $mobile->Series) }}" maxlength="100">
        <input type="text" name="Variant" class="input" style="flex:1" placeholder="Variant" value="{{ old('Variant', $mobile->Variant) }}" maxlength="100">
      </div>

      <div class="form-row"><label>ColorOptions</label></div>
      <div><input type="text" name="ColorOptions" class="input" value="{{ old('ColorOptions', $mobile->ColorOptions) }}" placeholder="Black, Blue, Green" maxlength="200"></div>

      <div class="form-row"><label>LaunchDate</label></div>
      <div><input type="date" name="LaunchDate" class="input" value="{{ old('LaunchDate', optional($mobile->LaunchDate)->format('Y-m-d')) }}"></div>

      <div class="form-row"><label>Availability</label></div>
      <div><input type="text" name="Availability" class="input" value="{{ old('Availability', $mobile->Availability) }}" placeholder="Available / Coming soon" maxlength="30"></div>

      <div class="form-row"><label>Price / LaunchPrice / Currency</label></div>
      <div class="inline">
        <input type="number" step="0.01" min="0" name="Price" class="input" style="flex:1" placeholder="Price" value="{{ old('Price', $mobile->Price) }}">
        <input type="number" step="0.01" min="0" name="LaunchPrice" class="input" style="flex:1" placeholder="LaunchPrice" value="{{ old('LaunchPrice', $mobile->LaunchPrice) }}">
        <input type="text" name="Currency" class="input" style="flex:0 0 110px" placeholder="THB" value="{{ old('Currency', $mobile->Currency ?? 'THB') }}" maxlength="3">
      </div>

      <div class="section">หน้าจอ</div>

      <div class="form-row"><label>ScreenSize_in</label></div>
      <div><input type="number" step="0.1" min="0" max="20" name="ScreenSize_in" class="input" value="{{ old('ScreenSize_in', $mobile->ScreenSize_in) }}" placeholder="เช่น 6.7"></div>

      <div class="form-row"><label>Display (ชื่อการตลาด)</label></div>
      <div><input type="text" name="Display" class="input" value="{{ old('Display', $mobile->Display) }}" placeholder="เช่น LTPO OLED" maxlength="255"></div>

      <div class="form-row"><label>Display_Type / Resolution</label></div>
      <div class="inline">
        <input type="text" name="Display_Type" class="input" style="flex:1" placeholder="เช่น OLED / IPS" value="{{ old('Display_Type', $mobile->Display_Type) }}" maxlength="60">
        <input type="text" name="Display_Resolution" class="input" style="flex:1" placeholder="2400x1080" value="{{ old('Display_Resolution', $mobile->Display_Resolution) }}" maxlength="30">
      </div>

      <div class="form-row"><label>RefreshRate / Brightness / Protection</label></div>
      <div class="inline">
        <input type="number" min="0" max="1000" name="Display_RefreshRate" class="input" style="flex:1" placeholder="Hz" value="{{ old('Display_RefreshRate', $mobile->Display_RefreshRate) }}">
        <input type="number" min="0" max="10000" name="Display_Brightness" class="input" style="flex:1" placeholder="nits" value="{{ old('Display_Brightness', $mobile->Display_Brightness) }}">
        <input type="text" name="Display_Protection" class="input" style="flex:1" placeholder="เช่น Gorilla Glass" value="{{ old('Display_Protection', $mobile->Display_Protection) }}" maxlength="80">
      </div>

      <div class="section">ชิป/ระบบ</div>

      <div class="form-row"><label>Processor / GPU</label></div>
      <div class="inline">
        <input type="text" name="Processor" class="input" style="flex:1" value="{{ old('Processor', $mobile->Processor) }}" placeholder="เช่น Snapdragon 8 Gen 3" maxlength="100">
        <input type="text" name="GPU" class="input" style="flex:1" value="{{ old('GPU', $mobile->GPU) }}" placeholder="GPU" maxlength="80">
      </div>

      <div class="form-row"><label>OS / UI_Skin / OS_Version</label></div>
      <div class="inline">
        <input type="text" name="OS" class="input" style="flex:1" value="{{ old('OS', $mobile->OS) }}" placeholder="Android / iOS" maxlength="50">
        <input type="text" name="UI_Skin" class="input" style="flex:1" value="{{ old('UI_Skin', $mobile->UI_Skin) }}" placeholder="เช่น One UI" maxlength="50">
        <input type="text" name="OS_Version" class="input" style="flex:1" value="{{ old('OS_Version', $mobile->OS_Version) }}" placeholder="เช่น 14" maxlength="50">
      </div>

      <div class="form-row"><label>OS_Updates_Years</label></div>
      <div><input type="number" min="0" max="20" name="OS_Updates_Years" class="input" value="{{ old('OS_Updates_Years', $mobile->OS_Updates_Years) }}"></div>

      <div class="section">หน่วยความจำ</div>

      <div class="form-row"><label>RAM_GB / RAM_Type</label></div>
      <div class="inline">
        <input type="number" min="0" max="65535" name="RAM_GB" class="input" style="flex:1" value="{{ old('RAM_GB', $mobile->RAM_GB) }}" placeholder="GB">
        <input type="text" name="RAM_Type" class="input" style="flex:1" value="{{ old('RAM_Type', $mobile->RAM_Type) }}" placeholder="LPDDR5X …" maxlength="20">
      </div>

      <div class="form-row"><label>Storage_GB / Storage_Type</label></div>
      <div class="inline">
        <input type="number" min="0" max="65535" name="Storage_GB" class="input" style="flex:1" value="{{ old('Storage_GB', $mobile->Storage_GB) }}">
        <input type="text" name="Storage_Type" class="input" style="flex:1" value="{{ old('Storage_Type', $mobile->Storage_Type) }}" placeholder="UFS 4.0 …" maxlength="20">
      </div>

      <div class="form-row"><label>Expandable (มีสล็อตเพิ่มความจุ)</label></div>
      <div class="check">
        <input type="hidden" name="Expandable" value="0">
        <input type="checkbox" id="ex" name="Expandable" value="1" {{ old('Expandable', $mobile->Expandable) ? 'checked' : '' }}>
        <label for="ex" style="padding-top:0">รองรับ microSD / เพิ่มความจุ</label>
      </div>

      <div class="section">กล้อง</div>

      <div class="form-row"><label>FrontCamera / BackCamera</label></div>
      <div class="inline">
        <input type="text" name="FrontCamera" class="input" style="flex:1" value="{{ old('FrontCamera', $mobile->FrontCamera) }}" placeholder="เช่น 16MP f/2.4" maxlength="50">
        <input type="text" name="BackCamera" class="input" style="flex:1" value="{{ old('BackCamera', $mobile->BackCamera) }}" placeholder="เช่น 50MP (wide)+8MP (ultra)" maxlength="50">
      </div>

      <div class="form-row"><label>FrontCamera_Features / RearCamera_Features</label></div>
      <div class="inline">
        <input type="text" name="FrontCamera_Features" class="input" style="flex:1" value="{{ old('FrontCamera_Features', $mobile->FrontCamera_Features) }}">
        <input type="text" name="RearCamera_Features" class="input" style="flex:1" value="{{ old('RearCamera_Features', $mobile->RearCamera_Features) }}">
      </div>

      <div class="form-row"><label>Video_Recording</label></div>
      <div><input type="text" name="Video_Recording" class="input" value="{{ old('Video_Recording', $mobile->Video_Recording) }}" placeholder="4K60 / 8K30 ฯลฯ" maxlength="100"></div>

      <div class="section">แบตเตอรี่ & ชาร์จ</div>

      <div class="form-row"><label>Battery_mAh / Battery_Type</label></div>
      <div class="inline">
        <input type="number" min="0" max="100000" name="Battery_mAh" class="input" style="flex:1" value="{{ old('Battery_mAh', $mobile->Battery_mAh) }}">
        <input type="text" name="Battery_Type" class="input" style="flex:1" value="{{ old('Battery_Type', $mobile->Battery_Type) }}" placeholder="Li-Po …" maxlength="20">
      </div>

      <div class="form-row"><label>Wired / Wireless / Reverse (Watt)</label></div>
      <div class="inline">
        <input type="number" min="0" max="1000" name="Charging_Wired_Watt" class="input" style="flex:1" value="{{ old('Charging_Wired_Watt', $mobile->Charging_Wired_Watt) }}" placeholder="เช่น 67">
        <input type="number" min="0" max="1000" name="Charging_Wireless_Watt" class="input" style="flex:1" value="{{ old('Charging_Wireless_Watt', $mobile->Charging_Wireless_Watt) }}">
        <input type="number" min="0" max="1000" name="Charging_Reverse_Watt" class="input" style="flex:1" value="{{ old('Charging_Reverse_Watt', $mobile->Charging_Reverse_Watt) }}">
      </div>

      <div class="section">เครือข่าย & การเชื่อมต่อ</div>

      <div class="form-row"><label>Network</label></div>
      <div><input type="text" name="Network" class="input" value="{{ old('Network', $mobile->Network) }}" placeholder="2G/3G/4G/5G" maxlength="255"></div>

      <div class="form-row"><label>Wifi_Std / Bluetooth / USB_Type / Sim_Type</label></div>
      <div class="inline">
        <input type="text" name="Wifi_Std" class="input" style="flex:1" value="{{ old('Wifi_Std', $mobile->Wifi_Std) }}" placeholder="Wi-Fi 6E …" maxlength="20">
        <input type="text" name="Bluetooth" class="input" style="flex:1" value="{{ old('Bluetooth', $mobile->Bluetooth) }}" placeholder="5.3 …" maxlength="10">
        <input type="text" name="USB_Type" class="input" style="flex:1" value="{{ old('USB_Type', $mobile->USB_Type) }}" placeholder="USB-C 2.0 …" maxlength="30">
        <input type="text" name="Sim_Type" class="input" style="flex:1" value="{{ old('Sim_Type', $mobile->Sim_Type) }}" placeholder="Dual Nano / Hybrid …" maxlength="40">
      </div>

      <div class="form-row"><label>ตัวเลือก</label></div>
      <div class="inline">
        <input type="hidden" name="NFC" value="0">
        <label class="check"><input type="checkbox" name="NFC" value="1" {{ old('NFC', $mobile->NFC) ? 'checked' : '' }}> NFC</label>

        <input type="hidden" name="GPS" value="0">
        <label class="check"><input type="checkbox" name="GPS" value="1" {{ old('GPS', $mobile->GPS) ? 'checked' : '' }}> GPS</label>

        <input type="hidden" name="Infrared" value="0">
        <label class="check"><input type="checkbox" name="Infrared" value="1" {{ old('Infrared', $mobile->Infrared) ? 'checked' : '' }}> Infrared</label>

        <input type="hidden" name="eSIM" value="0">
        <label class="check"><input type="checkbox" name="eSIM" value="1" {{ old('eSIM', $mobile->eSIM) ? 'checked' : '' }}> eSIM</label>

        <input type="hidden" name="Jack35" value="0">
        <label class="check"><input type="checkbox" name="Jack35" value="1" {{ old('Jack35', $mobile->Jack35) ? 'checked' : '' }}> 3.5mm Jack</label>

        <input type="hidden" name="Stereo_Speakers" value="0">
        <label class="check"><input type="checkbox" name="Stereo_Speakers" value="1" {{ old('Stereo_Speakers', $mobile->Stereo_Speakers) ? 'checked' : '' }}> Stereo</label>

        <input type="hidden" name="Dolby_Atmos" value="0">
        <label class="check"><input type="checkbox" name="Dolby_Atmos" value="1" {{ old('Dolby_Atmos', $mobile->Dolby_Atmos) ? 'checked' : '' }}> Dolby Atmos</label>
      </div>

      <div class="section">ความปลอดภัย & เซนเซอร์</div>

      <div class="form-row"><label>Fingerprint_Type</label></div>
      <div><input type="text" name="Fingerprint_Type" class="input" value="{{ old('Fingerprint_Type', $mobile->Fingerprint_Type) }}" placeholder="Side / Under-display …" maxlength="30"></div>

      <div class="form-row"><label>Face_Unlock</label></div>
      <div class="check">
        <input type="hidden" name="Face_Unlock" value="0">
        <input type="checkbox" id="faceu" name="Face_Unlock" value="1" {{ old('Face_Unlock', $mobile->Face_Unlock) ? 'checked' : '' }}>
        <label for="faceu" style="padding-top:0">รองรับปลดล็อกด้วยใบหน้า</label>
      </div>

      <div class="form-row"><label>Sensors</label></div>
      <div><input type="text" name="Sensors" class="input" value="{{ old('Sensors', $mobile->Sensors) }}" placeholder="accelerometer, gyroscope, proximity, compass …"></div>

      <div class="form-row"><label>Features</label></div>
      <div><input type="text" name="Features" class="input" value="{{ old('Features', $mobile->Features) }}"></div>

      <div class="section">ตัวเครื่อง</div>

      <div class="form-row"><label>Material</label></div>
      <div><input type="text" name="Material" class="input" value="{{ old('Material', $mobile->Material) }}" maxlength="100"></div>

      <div class="form-row"><label>Dimensions</label></div>
      <div><input type="text" name="Dimensions" class="input" value="{{ old('Dimensions', $mobile->Dimensions) }}" placeholder="161.2 x 74.3 x 7.9 mm" maxlength="50"></div>

      <div class="form-row"><label>Weight_g / IP_Rating</label></div>
      <div class="inline">
        <input type="number" min="0" max="20000" name="Weight_g" class="input" style="flex:1" value="{{ old('Weight_g', $mobile->Weight_g) }}">
        <input type="text" name="IP_Rating" class="input" style="flex:1" value="{{ old('IP_Rating', $mobile->IP_Rating) }}" placeholder="IP68 …" maxlength="20">
      </div>

      <div class="section">สื่อ (รูปภาพ)</div>

      {{-- รูปที่อัปไว้ + คลิกเพื่อเลือกลบ --}}
      <div class="form-row"><label>รูปที่อัปไว้</label></div>
      <div>
        @if($mobile->images && $mobile->images->count())
          <div class="thumbs" style="margin-bottom:8px">
            @foreach($mobile->images as $im)
              <label class="thumb removable" title="คลิกเพื่อเลือกลบรูปนี้">
                <img src="{{ asset('storage/'.$im->Img) }}" alt="img">
                @if($mobile->coverImage && $mobile->coverImage->ID === $im->ID)
                  <span class="badge-cover">Cover</span>
                @endif
                <input type="checkbox" name="remove_image_ids[]" value="{{ $im->ID }}">
              </label>
            @endforeach
          </div>
          <div class="muted">คลิกที่รูปเพื่อเลือกลบ (กรอบแดง = จะถูกลบเมื่อกดบันทึก)</div>
        @else
          <div class="muted">ยังไม่มีรูป</div>
        @endif
      </div>

      <div class="form-row"><label>เปลี่ยนรูปปก (Cover ใหม่)</label></div>
      <div>
        <input type="file" name="cover" id="coverInput" class="input" accept=".jpg,.jpeg,.png,.webp">
        <span id="coverHint" class="file-hint">เลือกไฟล์เพื่อแทนที่รูปปกเดิม</span>
        <div id="coverPreview" class="preview-box" style="margin-top:8px">
          @if($mobile->coverImage)
            <img src="{{ asset('storage/'.$mobile->coverImage->Img) }}" style="width:100%;height:100%;object-fit:cover" alt="cover">
          @else
            พรีวิวรูปปก
          @endif
        </div>
      </div>

      <div class="form-row"><label>อัปโหลดแกลเลอรี่เพิ่ม</label></div>
      <div>
        <input type="file" name="images[]" id="galleryInput" class="input" accept=".jpg,.jpeg,.png,.webp" multiple>
        <span id="galleryHint" class="file-hint">0 ไฟล์</span>
        <div id="galleryPreview" class="thumbs" style="margin-top:8px"></div>
      </div>

      <div class="form-row"></div>
      <div style="margin-top:8px">
        <button class="btn" style="background:#0f2342;color:#fff">บันทึกการแก้ไข</button>
        <a class="btn" href="{{ route('admin.phones.index') }}">ยกเลิก</a>
      </div>
    </div>
  </form>

<script>
  // พรีวิว cover ใหม่ (ถ้าเลือก)
  const coverInput = document.getElementById('coverInput');
  const coverPreview = document.getElementById('coverPreview');
  const coverHint = document.getElementById('coverHint');
  coverInput?.addEventListener('change', e=>{
    const f = e.target.files?.[0];
    if(!f){ return; }
    coverHint.textContent = f.name;
    const url = URL.createObjectURL(f);
    coverPreview.innerHTML = '';
    const img = new Image(); img.src = url; img.style.width='100%'; img.style.height='100%'; img.style.objectFit='cover';
    coverPreview.appendChild(img);
  });

  // พรีวิว gallery ที่จะอัปเพิ่ม
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

  // ✅ toggle เลือกลบรูป (กัน default toggle ของ label ก่อน)
  document.querySelectorAll('.thumb.removable').forEach(t => {
    t.addEventListener('click', ev => {
      // กันพฤติกรรม default ของ label ที่จะ toggle checkbox เอง
      ev.preventDefault();
      ev.stopPropagation();

      // ถ้าคลิกโดน input ตรงๆ ก็ไม่ต้องทำซ้ำ
      if (ev.target.tagName === 'INPUT') return;

      const chk = t.querySelector('input[type="checkbox"]');
      chk.checked = !chk.checked;              // toggle เอง
      t.classList.toggle('selected', chk.checked); // ใส่/เอา class กรอบแดง
    });
  });
</script>
@endsection
