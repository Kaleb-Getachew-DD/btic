<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Cohort;
use App\Models\News;
use App\Models\Notification;
use App\Models\Startup;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_applications'  => Application::count(),
            'pending_applications'=> Application::where('status', 'pending')->count(),
            'approved_applications'=> Application::where('status', 'approved')->count(),
            'total_startups'      => Startup::where('is_active', true)->count(),
            'total_news'          => News::where('is_published', true)->count(),
            'active_cohorts'      => Cohort::whereIn('status', ['open', 'active'])->count(),
        ];

        $recentApplications = Application::with('cohort')
            ->latest()
            ->take(8)
            ->get();

        $applicationsByStatus = Application::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $applicationsBySector = Application::selectRaw('sector, count(*) as total')
            ->groupBy('sector')
            ->orderByDesc('total')
            ->take(6)
            ->pluck('total', 'sector');

        $recentNews = News::with('author')->latest()->take(5)->get();
        $openCohorts = Cohort::whereIn('status', ['open', 'upcoming'])->get();
        $notifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'stats',
            'recentApplications',
            'applicationsByStatus',
            'applicationsBySector',
            'recentNews',
            'openCohorts',
            'notifications'
        ));
    }
}
