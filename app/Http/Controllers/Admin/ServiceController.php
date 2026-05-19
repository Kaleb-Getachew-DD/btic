<?php
// FILE: app/Http/Controllers/Admin/ServiceController.php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index() { return view('admin.services.index', ['services' => Service::orderBy('sort_order')->paginate(15)]); }
    public function create() { return view('admin.services.create'); }
    public function store(Request $request)
    {
        $data = $request->validate(['title'=>'required|string|max:255','description'=>'required|string','icon'=>'nullable|string','category'=>'nullable|string','features'=>'nullable|string','is_active'=>'boolean','sort_order'=>'nullable|integer']);
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('services','public');
        if (isset($data['features']) && is_string($data['features']))
            $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'])));
        Service::create($data);
        return redirect()->route('admin.services.index')->with('success','Service created.');
    }
    public function edit(Service $service) { return view('admin.services.edit', compact('service')); }
    public function update(Request $request, Service $service)
    {
        $data = $request->validate(['title'=>'required|string|max:255','description'=>'required|string','icon'=>'nullable|string','category'=>'nullable|string','features'=>'nullable|string','is_active'=>'boolean','sort_order'=>'nullable|integer']);
        if ($request->hasFile('image')) {
            if ($service->image) Storage::disk('public')->delete($service->image);
            $data['image'] = $request->file('image')->store('services','public');
        }
        if (isset($data['features']) && is_string($data['features']))
            $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'])));
        $service->update($data);
        return redirect()->route('admin.services.index')->with('success','Service updated.');
    }
    public function destroy(Service $service)
    {
        if ($service->image) Storage::disk('public')->delete($service->image);
        $service->delete();
        return redirect()->route('admin.services.index')->with('success','Service deleted.');
    }
}
