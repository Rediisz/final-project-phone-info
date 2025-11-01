@php($u = $comment->user)
<div class="comment-item" data-id="{{ $comment->ID }}">
  <img src="{{ $u?->avatar_url }}" alt="{{ e($u->User_Name ?? 'user') }}" class="comment-avatar">
  <div class="comment-content">
    <div class="comment-author">{{ $u->User_Name ?? 'สมาชิก' }}</div>
    <div class="comment-body">{{ e($comment->Comment) }}</div>
    <div class="comment-date">{{ $comment->Date?->diffForHumans() }}</div>
  </div>
  @auth
    @if(auth()->user()->RoleID == 1)
      <div>
        <button class="btn-del-comment" data-url="{{ route('comments.destroy',$comment->ID) }}">
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
    const result = await Swal.fire({
      title: 'ยืนยันการลบ?',
      text: 'คอมเมนต์นี้จะถูกลบถาวร',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'ลบ',
      cancelButtonText: 'ยกเลิก',
      reverseButtons: true,
      confirmButtonColor: '#b91c1c'
    });

    if(!result.isConfirmed) return;

    try {
      const res = await fetch(btn.dataset.url, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
        },
      });

      if (res.ok) {
        await Swal.fire({
          icon: 'success',
          title: 'ลบสำเร็จ',
          text: 'คอมเมนต์ถูกลบเรียบร้อยแล้ว',
          confirmButtonText: 'ตกลง'
        });
        root.remove();
      } else {
        const t = await res.text().catch(()=> '');
        Swal.fire({
          icon: 'error',
          title: 'ลบไม่สำเร็จ',
          text: t || 'เกิดข้อผิดพลาดจากเซิร์ฟเวอร์'
        });
      }
    } catch (e) {
      Swal.fire({
        icon: 'error',
        title: 'ลบไม่สำเร็จ',
        text: 'เครือข่ายขัดข้อง ลองใหม่อีกครั้ง'
      });
    }
  });
})();
</script>
@endif
@endauth

<style>
/* สไตล์พื้นฐานสำหรับทุกขนาดหน้าจอ */
.comment-item {
  display: flex;
  gap: 14px;
  padding: 14px 0;
  border-bottom: 1px solid #e8eef5;
  transition: background-color .2s ease;
  border-radius: 8px;
  margin-bottom: 4px;
}

.comment-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  object-position: center;
  background: #cfd8e3;
  flex-shrink: 0;
  border: 2px solid #e8eef5;
}

.comment-content {
  flex: 1;
}

.comment-author {
  font-size: 15px;
  color: #0f2342;
  font-weight: 600;
  margin-bottom: 4px;
}

.comment-body {
  white-space: pre-wrap;
  line-height: 1.6;
  color: #374151;
  font-size: 14px;
}

.comment-date {
  font-size: 12px;
  color: #9ca3af;
  margin-top: 6px;
}

.btn-del-comment {
  background: transparent;
  color: #b91c1c;
  border: 1px solid #b91c1c;
  border-radius: 8px;
  padding: 6px 12px;
  cursor: pointer;
  font-size: 13px;
  transition: all .2s ease;
  font-weight: 500;
}

/* สำหรับมือถือ: ปรับขนาดตัวอักษรให้อ่านง่าย */
@media (max-width: 560px) {
  .comment-item {
    padding: 20px 0;
    gap: 16px;
  }

  .comment-avatar {
    width: 45px;
    height: 45px;
  }

  .comment-author {
    font-size: 20px;
    margin-bottom: 10px;
  }

  .comment-body {
    font-size: 16px;
    line-height: 1.7;
  }

  .comment-date {
    font-size: 14px;
  }

  .btn-del-comment {
    font-size: 14px;
    padding: 8px 14px;
  }
}
</style>