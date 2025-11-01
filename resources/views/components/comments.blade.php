@props(['model','type'])

<section id="comments"
  style="margin-top:32px;background:#fff;border-radius:16px;padding:24px;box-shadow:0 2px 8px rgba(15,35,66,.06);border:1px solid #e8eef5">

  <h3 class="c-heading"
    style="margin:0 0 16px;font-size:20px;color:#0f2342;font-weight:700;">
    💬 คอมเมนต์
  </h3>

  <div id="comment-list" class="c-list">
    @forelse($model->comments()->with('user')->orderByDesc('Date')->get() as $comment)
      @include('components.comment-item', ['comment'=>$comment])
    @empty
      <div id="comment-empty" class="c-empty" style="color:#6b7280;padding:8px 0;">
        ยังไม่มีคอมเมนต์
      </div>
    @endforelse
  </div>

  <div class="c-footer" style="margin-top:14px;border-top:1px solid #e8eef5;padding-top:12px">
    @auth
      <form id="comment-form">
        @csrf
        <textarea
          name="body"
          rows="3"
          placeholder="พิมพ์ความคิดเห็น..."
          required
          class="c-textarea"
          style="width:100%;border:1px solid #dbe3f0;border-radius:12px;padding:12px;resize:vertical;
                 font-family:inherit;font-size:14px;transition:border-color .2s ease,box-shadow .2s ease"></textarea>

        <div style="display:flex;justify-content:flex-end;margin-top:12px">
          <button
            type="submit"
            class="c-button"
            style="background:#0f2342;color:#fff;border:none;border-radius:10px;padding:10px 20px;
                   cursor:pointer;font-weight:600;transition:all .2s ease;font-size:14px">
            ส่งคอมเมนต์
          </button>
        </div>
      </form>
    @else
      <div class="c-authmsg" style="color:#6b7280;font-size:14px;line-height:1.5;">
        ต้องเข้าสู่ระบบจึงจะคอมเมนต์ได้
        <a href="{{ route('login') }}" style="color:#0f2342;text-decoration:underline">เข้าสู่ระบบ</a>
        หรือ
        <a href="{{ route('signup') }}" style="color:#0f2342;text-decoration:underline">สมัครสมาชิก</a>
      </div>
    @endauth
  </div>
</section>

<style>
/* มือถือ/จอแคบ: ขยายฟอนต์ในกล่องคอมเมนต์ให้ไม่จิ๋ว */
@media (max-width: 560px) {

  #comments {
    padding:24px 20px;
  }

  #comments .c-heading {
    font-size:1.2rem;          /* ~19px */
    line-height:1.4;
    margin-bottom:16px;
  }

  #comments .c-list {
    font-size:1.1rem;          /* เพิ่มขนาดตัวอักษร */
    line-height:1.55;
    color:#0f2342;
  }

  #comments .c-empty {
    font-size:1.1rem;          /* เพิ่มขนาดตัวอักษร */
    line-height:1.5;
  }

  #comments .c-footer {
    margin-top:16px;
    padding-top:16px;
    border-top:1px solid #e8eef5;
    font-size:1.1rem;          /* เพิ่มขนาดตัวอักษร */
    line-height:1.55;
  }

  #comments .c-textarea {
    font-size:1.1rem !important;     /* เพิ่มขนาดตัวอักษร */
    line-height:1.5;
    padding:14px 16px !important;
    border-radius:12px;
  }

  #comments .c-button {
    font-size:1.1rem !important;     /* เพิ่มขนาดตัวอักษร */
    line-height:1.4;
    padding:12px 20px !important;  /* ปุ่มใหญ่ขึ้น กดง่ายนิ้วโป้ง */
    border-radius:12px !important;
  }

  #comments .c-authmsg {
    font-size:1.1rem !important;     /* เพิ่มขนาดตัวอักษร */
    line-height:1.6 !important;
  }
}


</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    const fd = new FormData(form);
    fd.append('commentable_type', "{{ $type }}");
    fd.append('commentable_id',   "{{ $model->getKey() }}");

    const res = await fetch("{{ route('comments.store') }}", {
      method: 'POST',
      body: fd,
      headers: { 'Accept': 'application/json' }
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
