<?php
// app/Http/Controllers/CommentController.php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\MobileInfo;
use App\Models\MobileNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CommentController extends Controller
{
    public function store(Request $req)
    {
        $data = $req->validate([
            'commentable_type' => ['required','in:mobile,news'],
            'commentable_id'   => ['required','integer'],
            'body'             => ['required','string','max:2000'],
        ]);

        $map = ['mobile' => MobileInfo::class, 'news' => MobileNews::class];
        $model = ($map[$data['commentable_type']])::findOrFail($data['commentable_id']);

        $comment = $model->comments()->create([
            'User_ID' => Auth::id(),
            'Comment' => $data['body'],
            'Date'    => now(),
        ])->load('user');

        $html = View::make('components.comment-item', compact('comment'))->render();

        return response()->json(['html' => $html]);
    }

    // โหลดคอมเมนต์ “ถัดไป” ครั้งละ 3
    public function more(Request $req)
    {
        $data = $req->validate([
            'commentable_type' => ['required','in:mobile,news'],
            'commentable_id'   => ['required','integer'],
            'cursor'           => ['nullable','integer'],
        ]);

        // ให้ใช้ morphClass ที่จริงตามที่ถูกบันทึก
        $map = ['mobile' => MobileInfo::class, 'news' => MobileNews::class];
        $morphClass = (new $map[$data['commentable_type']])->getMorphClass();

        $q = Comment::with('user')
            ->where('commentable_type', $morphClass)
            ->where('commentable_id', $data['commentable_id'])
            ->orderByDesc('Date')->orderByDesc('ID');

        if (!empty($data['cursor'])) {
            $q->where('ID', '<', $data['cursor']);
        }

        $items = $q->take(3)->get();

        $html = '';
        foreach ($items as $comment) {
            $html .= View::make('components.comment-item', compact('comment'))->render();
        }

        $nextCursor = $items->last()->ID ?? null;

        $hasMore = false;
        if ($nextCursor) {
            $hasMore = Comment::where('commentable_type', $morphClass)
                ->where('commentable_id', $data['commentable_id'])
                ->where('ID', '<', $nextCursor)
                ->exists();
        }

        return response()->json([
            'html'       => $html,
            'nextCursor' => $nextCursor,
            'hasMore'    => $hasMore,
        ]);
    }

    public function destroy(Comment $comment)
    {
        $user = Auth::user();
        if (!$user || (int)($user->RoleID) !== 1) {
            abort(403);
        }

        $comment->delete();

        return response()->noContent();
    }
}
