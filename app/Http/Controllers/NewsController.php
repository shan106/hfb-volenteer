<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;

class NewsController extends Controller
{
    public function index()
    {
        $newsItems = NewsItem::orderByDesc('published_at')->paginate(6);

        return view('news.index', compact('newsItems'));
    }

    public function show(NewsItem $news)
    {
        return view('news.show', compact('news'));
    }
}
