<?php
// FILE: app/Http/Controllers/Web/AboutController.php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\TeamMember;

class AboutController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::active()->get();
        return view('web.about.index', compact('teamMembers'));
    }
}
