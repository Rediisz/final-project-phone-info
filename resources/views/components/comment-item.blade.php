@php($u = $comment->user)
<div class="comment-item" style="display:flex;gap:12px;padding:12px 0;border-bottom:1px solid #e8eef5">
  <div style="width:36px;height:36px;border-radius:50%;background:#cfd8e3;display:flex;align-items:center;justify-content:center;font-weight:700;">
    {{ strtoupper(mb_substr($u->User_Name ?? 'U',0,1)) }}
  </div>
  <div style="flex:1">
    <div style="font-size:14px;color:#0f2342;font-weight:600">{{ $u->User_Name ?? 'สมาชิก' }}</div>
    <div style="white-space:pre-wrap;line-height:1.5">{{ e($comment->Comment) }}</div>
    <div style="font-size:12px;color:#6b7280;margin-top:4px">{{ $comment->Date?->diffForHumans() }}</div>
  </div>
</div>
