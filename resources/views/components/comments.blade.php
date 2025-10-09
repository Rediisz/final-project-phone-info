@props(['model','type'])

<section id="comments" style="margin-top:28px;background:#fff;border-radius:16px;padding:18px;box-shadow:0 2px 8px rgba(15,35,66,.06)">
  <h3 style="margin:0 0 12px;font-size:18px;color:#0f2342;">คอมเมนต์</h3>

  <div id="comment-list">
    @forelse($model->comments()->with('user')->orderByDesc('Date')->get() as $comment)
      @include('components.comment-item', ['comment'=>$comment])
    @empty
      <div id="comment-empty" style="color:#6b7280;padding:8px 0;">ยังไม่มีคอมเมนต์</div>
    @endforelse
  </div>

  <div style="margin-top:14px;border-top:1px solid #e8eef5;padding-top:12px">
    @auth
      <form id="comment-form">
        @csrf  {{-- <<<<<< ใส่ token แบบฟอร์ม --}}
        <textarea name="body" rows="3" placeholder="พิมพ์ความคิดเห็น..." required
          style="width:100%;border:1px solid #dbe3f0;border-radius:12px;padding:10px;resize:vertical;"></textarea>
        <div style="display:flex;justify-content:flex-end;margin-top:8px">
          <button type="submit" style="background:#0f2342;color:#fff;border:none;border-radius:10px;padding:8px 14px;cursor:pointer;">
            ส่งคอมเมนต์
          </button>
        </div>
      </form>
    @else
      <div style="color:#6b7280">
        ต้องเข้าสู่ระบบจึงจะคอมเมนต์ได้
        <a href="{{ route('login') }}" style="color:#0f2342;text-decoration:underline">เข้าสู่ระบบ</a>
        หรือ <a href="{{ route('signup') }}" style="color:#0f2342;text-decoration:underline">สมัครสมาชิก</a>
      </div>
    @endauth
  </div>
</section>

@auth
<script>
(function(){
  const form  = document.getElementById('comment-form');
  if(!form) return;
  const list  = document.getElementById('comment-list');
  const empty = document.getElementById('comment-empty');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const bodyText = form.body.value.trim();
    if (!bodyText) return;

    // ใช้ FormData จะติด _token จาก @csrf อัตโนมัติ ไม่ต้องพึ่ง <meta>
    const fd = new FormData(form);
    fd.append('commentable_type', "{{ $type }}");
    fd.append('commentable_id',   "{{ $model->getKey() }}");

    const res = await fetch("{{ route('comments.store') }}", {
      method: 'POST',
      body: fd,
      headers: { 'Accept': 'application/json' } // ไม่ต้องตั้ง Content-Type ให้ FormData
    });

    if (!res.ok) {
      const t = await res.text().catch(()=> '');
      alert('บันทึกคอมเมนต์ไม่สำเร็จ\n' + t);
      return;
    }

    const data = await res.json();

    if (empty) empty.remove();

    const node = document.createElement('div');
    node.innerHTML = data.html;
    list.prepend(node.firstElementChild);
    form.reset();
  });
})();
</script>
@endauth
