<?php
// FILE: app/Http/Controllers/Web/HomeController.php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cohort;
use App\Models\News;
use App\Models\Program;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Startup;
use App\Models\TeamMember;
use App\Models\Partner;

class HomeController extends Controller
{
    public function index()
    {
        $featuredStartups = Startup::featured()->take(6)->get();
        $latestNews       = News::published()->latest('published_at')->take(3)->get();
        $programs         = Program::active()->take(4)->get();
        $services         = Service::active()->take(6)->get();
        $teamMembers      = TeamMember::active()->take(8)->get();
        $openCohort       = Cohort::where('status', 'open')->latest()->first();
        $stats = [
            'startups' => Setting::get('stats_startups', '50+'),
            'cohorts'  => Setting::get('stats_cohorts', '5'),
            'jobs'     => Setting::get('stats_jobs', '200+'),
            'funding'  => Setting::get('stats_funding', '$500K+'),
        ];
        $partners = Partner::active()->get();
        $partnershipTitle = Setting::get('partnership_title', 'Our Partners & Collaborators');
        $partnershipSubtitle = Setting::get('partnership_subtitle', 'Working together with leading institutions and organizations to build Ethiopia\'s innovation ecosystem.');
        $presidentName = Setting::get('president_name', '');
        $presidentTitle = Setting::get('president_title', 'Our University President');
        $presidentImage = Setting::assetUrl('president_image');

        return view('web.home.index', compact(
            'featuredStartups', 'latestNews', 'programs', 'services',
            'teamMembers', 'openCohort', 'stats', 'partners',
            'partnershipTitle', 'partnershipSubtitle',
            'presidentName', 'presidentTitle', 'presidentImage'
        ));
    }
}
