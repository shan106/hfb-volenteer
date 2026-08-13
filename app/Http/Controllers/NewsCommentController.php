<?php

namespace App\Http\Controllers;

use App\Models\NewsComment;
use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsCommentController extends Controller
{
    /**
     * Een ingelogde gebruiker plaatst een reactie op een nieuwsbericht.
     */
    public function store(Request $request, NewsItem $news)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:1000'],
        ]);

        $news->comments()->create([
            'user_id' => Auth::id(),
            'body'    => $data['body'],
        ]);

        return back()->with('status', __('Your comment has been posted.'));
    }

    /**
     * Een reactie verwijderen: enkel de auteur van de reactie of een admin.
     */
    public function destroy(NewsItem $news, NewsComment $comment)
    {
        abort_if($comment->news_item_id !== $news->id, 404);

        $user = Auth::user();

        abort_unless($user->is_admin || $comment->user_id === $user->id, 403);

        $comment->delete();

        return back()->with('status', __('Comment deleted.'));
    }
}
