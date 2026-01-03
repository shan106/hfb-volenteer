<?php

namespace App\Http\Controllers;

use App\Models\TimelinePost;
use Illuminate\Http\Request;
use App\Models\TimelineLike; 
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    public function index()
    {
        $posts = TimelinePost::with(['user', 'likes'])
            ->withCount('likes')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('timeline.index', compact('posts'));
    }


    public function like(TimelinePost $post)
    {
        $userId = Auth::id();

        // voorkom dubbele likes
        TimelineLike::firstOrCreate([
            'user_id'          => $userId,
            'timeline_post_id' => $post->id,
        ]);

        return back()->with('status', 'You liked this post.');
    }

    public function unlike(TimelinePost $post)
    {
        $userId = Auth::id();

        TimelineLike::where('user_id', $userId)
            ->where('timeline_post_id', $post->id)
            ->delete();

        return back()->with('status', 'You unliked this post.');
    }



    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
            'image'   => ['nullable', 'image', 'max:4096'],
        ]);

        $post = new TimelinePost();
        $post->user_id = auth()->id();
        $post->content = $data['content'];

        if ($request->hasFile('image')) {
            $post->image_path = $request->file('image')->store('timeline', 'public');
        }

        $post->save();

        return back()->with('status', 'Post added to the timeline.');
    }

    public function destroy(TimelinePost $post)
    {
        if (auth()->id() !== $post->user_id && ! auth()->user()->is_admin) {
            abort(403);
        }

        $post->delete();

        return back()->with('status', 'Post deleted.');
    }
}
