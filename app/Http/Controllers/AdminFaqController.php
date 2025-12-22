<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class AdminFaqController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::orderBy('sort_order')->get();
        $faqs = Faq::with('category')->orderBy('faq_category_id')->orderBy('sort_order')->get();

        return view('admin.faq.index', compact('categories', 'faqs'));
    }

    public function create()
    {
        $categories = FaqCategory::orderBy('sort_order')->get();

        return view('admin.faq.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'faq_category_id' => ['required', 'exists:faq_categories,id'],
            'question'        => ['required', 'string', 'max:255'],
            'answer'          => ['required', 'string'],
            'sort_order'      => ['nullable', 'integer'],
            
        ]);

        $data['is_public'] = $request->boolean('is_public');

        $maxSort = Faq::where('faq_category_id', $data['faq_category_id'])->max('sort_order');
        $data['sort_order'] = ($maxSort ?? 0) + 1; 

        Faq::create($data);

        return redirect()->route('admin.faq.index')
                         ->with('status', 'FAQ item created.');
    }

    public function edit(Faq $faq)
    {
        $categories = FaqCategory::orderBy('sort_order')->get();

        return view('admin.faq.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'faq_category_id' => ['required', 'exists:faq_categories,id'],
            'question'        => ['required', 'string', 'max:255'],
            'answer'          => ['required', 'string'],
            'sort_order'      => ['nullable', 'integer'],
            'is_public'       => ['nullable', 'boolean'],
        ]);

        $data['is_public'] = $request->boolean('is_public');

        if (is_null($data['sort_order'])) {
        $data['sort_order'] = $faq->sort_order; 
    }

        $faq->update($data);

        return redirect()->route('admin.faq.index')
                         ->with('status', 'FAQ item updated.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faq.index')
                         ->with('status', 'FAQ item deleted.');
    }

    

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        FaqCategory::create($data);

        return back()->with('status', 'FAQ category created.');
    }

    public function updateCategory(Request $request, FaqCategory $category)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $category->update($data);

        return back()->with('status', 'FAQ category updated.');
    }

    public function destroyCategory(FaqCategory $category)
    {
        $category->delete();

        return back()->with('status', 'FAQ category deleted.');
    }
}
