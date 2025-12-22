<?php

namespace App\Http\Controllers;

use App\Models\TimelinePost;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index()
    {
        $posts = TimelinePost::with('user')->orderByDesc('created_at')->paginate(10);

        return view('timeline.index', compact('posts'));
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
