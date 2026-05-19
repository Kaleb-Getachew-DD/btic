<?php
// FILE: app/Http/Controllers/Web/ProgramController.php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Service;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::active()->get();
        $services = Service::active()->get();
        return view('web.programs.index', compact('programs', 'services'));
    }
}
