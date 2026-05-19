<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCohortRequest;
use App\Models\Cohort;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CohortController extends Controller
{
    public function index()
    {
        return view('admin.cohorts.index', ['cohorts' => Cohort::withCount('applications')->orderByDesc('batch_number')->paginate(10)]);
    }

    public function create()
    {
        return view('admin.cohorts.create');
    }

    public function store(StoreCohortRequest $request)
    {
        $data         = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cohorts', 'public');
        }
        if (isset($data['focus_areas']) && is_string($data['focus_areas'])) {
            $data['focus_areas'] = array_filter(array_map('trim', explode(',', $data['focus_areas'])));
        }
        Cohort::create($data);
        return redirect()->route('admin.cohorts.index')->with('success', 'Cohort created successfully.');
    }

    public function edit(Cohort $cohort)
    {
        return view('admin.cohorts.edit', compact('cohort'));
    }

    public function update(StoreCohortRequest $request, Cohort $cohort)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($cohort->image) Storage::disk('public')->delete($cohort->image);
            $data['image'] = $request->file('image')->store('cohorts', 'public');
        }
        if (isset($data['focus_areas']) && is_string($data['focus_areas'])) {
            $data['focus_areas'] = array_filter(array_map('trim', explode(',', $data['focus_areas'])));
        }
        $cohort->update($data);
        return redirect()->route('admin.cohorts.index')->with('success', 'Cohort updated.');
    }

    public function destroy(Cohort $cohort)
    {
        if ($cohort->image) Storage::disk('public')->delete($cohort->image);
        $cohort->delete();
        return redirect()->route('admin.cohorts.index')->with('success', 'Cohort deleted.');
    }

    public function toggleStatus(Cohort $cohort)
    {
        $next = ['upcoming' => 'open', 'open' => 'closed', 'closed' => 'active', 'active' => 'completed', 'completed' => 'upcoming'];
        $cohort->update(['status' => $next[$cohort->status] ?? 'upcoming']);
        return back()->with('success', 'Cohort status updated to ' . ucfirst($cohort->status) . '.');
    }
}
