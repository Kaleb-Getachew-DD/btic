<?php
// FILE: app/Http/Controllers/Web/StartupController.php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Startup;
use Illuminate\Http\Request;

class StartupController extends Controller
{
    public function index(Request $request)
    {
        $query = Startup::active()->orderByDesc('is_featured')->orderBy('sort_order');
        if ($request->filled('sector')) $query->where('sector', $request->sector);
        if ($request->filled('stage'))  $query->where('stage', $request->stage);
        if ($request->filled('search')) $query->where('name', 'like', '%' . $request->search . '%');
        $startups = $query->paginate(12)->withQueryString();
        $sectors  = Startup::active()->distinct()->pluck('sector')->filter();
        return view('web.startups.index', compact('startups', 'sectors'));
    }

    public function show(string $slug)
    {
        $startup = Startup::active()->where('slug', $slug)->firstOrFail();
        $related = Startup::active()->where('sector', $startup->sector)->where('id', '!=', $startup->id)->take(3)->get();
        return view('web.startups.show', compact('startup', 'related'));
    }
}
