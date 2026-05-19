<?php
// FILE: app/Http/Controllers/Admin/ProgramController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProgramRequest;
use App\Models\Program;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index() { return view('admin.programs.index', ['programs' => Program::orderBy('sort_order')->paginate(15)]); }
    public function create() { return view('admin.programs.create'); }
    public function store(StoreProgramRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('programs', 'public');
        if (isset($data['benefits']) && is_string($data['benefits']))
            $data['benefits'] = array_filter(array_map('trim', explode("\n", $data['benefits'])));
        Program::create($data);
        return redirect()->route('admin.programs.index')->with('success', 'Program created.');
    }
    public function edit(Program $program) { return view('admin.programs.edit', compact('program')); }
    public function update(StoreProgramRequest $request, Program $program)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($program->image) Storage::disk('public')->delete($program->image);
            $data['image'] = $request->file('image')->store('programs', 'public');
        }
        if (isset($data['benefits']) && is_string($data['benefits']))
            $data['benefits'] = array_filter(array_map('trim', explode("\n", $data['benefits'])));
        $program->update($data);
        return redirect()->route('admin.programs.index')->with('success', 'Program updated.');
    }
    public function destroy(Program $program)
    {
        if ($program->image) Storage::disk('public')->delete($program->image);
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program deleted.');
    }
}
