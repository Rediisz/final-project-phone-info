@php($u = $comment->user)
<div class="comment-item" data-id="{{ $comment->ID }}" style="display:flex;gap:12px;padding:12px 0;border-bottom:1px solid #e8eef5">
  <img src="{{ $u?->avatar_url }}" alt="{{ e($u->User_Name ?? 'user') }}"
       style="width:36px;height:36px;border-radius:50%;object-fit:cover;object-position:center;background:#cfd8e3">
  <div style="flex:1">
    <div style="font-size:14px;color:#0f2342;font-weight:600">{{ $u->User_Name ?? 'สมาชิก' }}</div>
    <div style="white-space:pre-wrap;line-height:1.5">{{ e($comment->Comment) }}</div>
    <div style="font-size:12px;color:#6b7280;margin-top:4px">{{ $comment->Date?->diffForHumans() }}</div>
  </div>
  @auth
    @if(auth()->user()->RoleID == 1)
      <div>
        <button class="btn-del-comment" data-url="{{ route('comments.destroy',$comment->ID) }}"
          style="background:transparent;color:#b91c1c;border:1px solid #b91c1c;border-radius:8px;padding:6px 10px;cursor:pointer">
          ลบ
        </button>
      </div>
    @endif
  @endauth
</div>
@auth
@if(auth()->user()->RoleID == 1)
<script>
(function(){
  const root = document.currentScript.previousElementSibling; // div.comment-item
  const btn  = root.querySelector('.btn-del-comment');
  if(!btn) return;
  btn.addEventListener('click', async () => {
    if(!confirm('ยืนยันลบคอมเมนต์นี้?')) return;
    const res = await fetch(btn.dataset.url, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
      },
    });
    if(res.ok){ root.remove(); }
    else{ alert('ลบไม่สำเร็จ'); }
  });
})();
</script>
@endif
@endauth
