<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('author')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        $news       = $query->paginate(15)->withQueryString();
        $categories = News::distinct()->pluck('category')->filter();

        return view('admin.news.index', compact('news', 'categories'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(StoreNewsRequest $request)
    {
        $data              = $request->validated();
        $data['author_id'] = Auth::id();
        $data['slug']      = Str::slug($data['title']);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')
                ->store('news/covers', 'public');
        }

        if ($request->boolean('is_published') && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if ($request->has('tags') && is_string($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        }

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article published successfully.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(StoreNewsRequest $request, News $news)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($news->cover_image) {
                Storage::disk('public')->delete($news->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')
                ->store('news/covers', 'public');
        }

        if ($request->boolean('is_published') && !$news->published_at) {
            $data['published_at'] = now();
        }

        if ($request->has('tags') && is_string($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully.');
    }

    public function destroy(News $news)
    {
        if ($news->cover_image) {
            Storage::disk('public')->delete($news->cover_image);
        }
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article deleted.');
    }

    public function togglePublish(News $news)
    {
        $news->update([
            'is_published' => !$news->is_published,
            'published_at' => !$news->is_published ? now() : $news->published_at,
        ]);

        return back()->with('success', 'Article ' . ($news->is_published ? 'published' : 'unpublished') . '.');
    }
}
