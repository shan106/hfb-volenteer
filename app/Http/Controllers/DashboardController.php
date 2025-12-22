<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::with(['faqs' => function ($q) {
                $q->where('is_public', true);
            }])
            ->orderBy('sort_order')
            ->get();

        // BELANGRIJK: dashboard-view, niet faq.index
        return view('dashboard', compact('categories'));
    }
}
