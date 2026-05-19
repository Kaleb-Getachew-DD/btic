<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStartupRequest;
use App\Models\Startup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StartupController extends Controller
{
    public function index(Request $request)
    {
        $query = Startup::latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sector', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('sector')) {
            $query->where('sector', $request->sector);
        }
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === '1');
        }

        $startups = $query->paginate(12)->withQueryString();
        $sectors  = Startup::distinct()->pluck('sector')->filter();

        return view('admin.startups.index', compact('startups', 'sectors'));
    }

    public function create()
    {
        return view('admin.startups.create');
    }

    public function store(StoreStartupRequest $request)
    {
        $data         = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        foreach (['logo', 'cover_image', 'founder_photo'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('startups/' . $field, 'public');
            }
        }

        if ($request->has('achievements') && is_string($data['achievements'])) {
            $data['achievements'] = array_filter(array_map('trim', explode("\n", $data['achievements'])));
        }

        Startup::create($data);

        return redirect()->route('admin.startups.index')
            ->with('success', 'Startup portfolio added successfully.');
    }

    public function edit(Startup $startup)
    {
        return view('admin.startups.edit', compact('startup'));
    }

    public function update(StoreStartupRequest $request, Startup $startup)
    {
        $data = $request->validated();

        foreach (['logo', 'cover_image', 'founder_photo'] as $field) {
            if ($request->hasFile($field)) {
                if ($startup->$field) {
                    Storage::disk('public')->delete($startup->$field);
                }
                $data[$field] = $request->file($field)->store('startups/' . $field, 'public');
            }
        }

        if ($request->has('achievements') && is_string($data['achievements'])) {
            $data['achievements'] = array_filter(array_map('trim', explode("\n", $data['achievements'])));
        }

        $startup->update($data);

        return redirect()->route('admin.startups.index')
            ->with('success', 'Startup updated successfully.');
    }

    public function destroy(Startup $startup)
    {
        foreach (['logo', 'cover_image', 'founder_photo'] as $field) {
            if ($startup->$field) Storage::disk('public')->delete($startup->$field);
        }
        $startup->delete();

        return redirect()->route('admin.startups.index')
            ->with('success', 'Startup removed.');
    }

    public function toggleFeatured(Startup $startup)
    {
        $startup->update(['is_featured' => !$startup->is_featured]);

        return back()->with('success', 'Startup ' . ($startup->is_featured ? 'featured' : 'unfeatured') . '.');
    }
}
