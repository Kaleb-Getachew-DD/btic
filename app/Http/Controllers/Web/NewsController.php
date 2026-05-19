<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('author')->published()->latest('published_at');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        $news      = $query->paginate(9)->withQueryString();
        $featured  = News::published()->where('is_featured', true)->latest('published_at')->take(3)->get();
        $categories = News::published()->distinct()->pluck('category')->filter();

        return view('web.news.index', compact('news', 'featured', 'categories'));
    }

    public function show(string $slug)
    {
        $article = News::with('author')->published()->where('slug', $slug)->firstOrFail();
        $article->incrementViews();

        $related = News::published()
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('web.news.show', compact('article', 'related'));
    }
}
