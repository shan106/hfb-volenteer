<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsItemController extends Controller
{
    public function index()
    {
        $newsItems = NewsItem::orderByDesc('published_at')->paginate(10);

        return view('admin.news.index', compact('newsItems'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'image'   => ['nullable', 'image', 'max:4096'],
        ]);

        $slug = Str::slug($data['title']);
        if (NewsItem::where('slug', $slug)->exists()) {
            $slug .= '-' . now()->timestamp;
        }

        $news = new NewsItem();
        $news->user_id = auth()->id();
        $news->title = $data['title'];
        $news->slug = $slug;
        $news->excerpt = $data['excerpt'] ?? Str::limit(strip_tags($data['content']), 200);
        $news->content = $data['content'];
        $news->published_at = now();

        if ($request->hasFile('image')) {
            $news->image_path = $request->file('image')->store('news', 'public');
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('status', 'News item created.');
    }

    public function edit(NewsItem $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, NewsItem $news)
    {
        $data = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'image'   => ['nullable', 'image', 'max:4096'],
        ]);

        $news->title = $data['title'];
        $news->excerpt = $data['excerpt'] ?? Str::limit(strip_tags($data['content']), 200);
        $news->content = $data['content'];

        if ($request->hasFile('image')) {
            $news->image_path = $request->file('image')->store('news', 'public');
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('status', 'News item updated.');
    }

    public function destroy(NewsItem $news)
    {
        $news->delete();

        return redirect()->route('admin.news.index')->with('status', 'News item deleted.');
    }
}
