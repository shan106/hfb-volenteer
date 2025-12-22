<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;

class FaqController extends Controller
{
    public function index()
    {
        
        $categories = FaqCategory::with(['faqs' => function ($q) {
                $q->where('is_public', true);
            }])
            ->orderBy('sort_order')
            ->get();

        return view('faq.index', compact('categories'));
    }
}
