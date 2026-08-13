<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;

class NewsController extends Controller
{
    public function index()
    {
        $newsItems = NewsItem::with('author')
            ->withCount('comments')
            ->orderByDesc('published_at')
            ->paginate(7);

        return view('news.index', compact('newsItems'));
    }

    public function show(NewsItem $news)
    {
        $news->load(['author', 'comments.user']);

        return view('news.show', compact('news'));
    }
}