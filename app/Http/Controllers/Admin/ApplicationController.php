<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Cohort;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with('cohort')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('startup_name', 'like', '%' . $request->search . '%')
                  ->orWhere('founder_name', 'like', '%' . $request->search . '%')
                  ->orWhere('reference_number', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('cohort_id')) {
            $query->where('cohort_id', $request->cohort_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('sector')) {
            $query->where('sector', $request->sector);
        }

        $applications = $query->paginate(15)->withQueryString();
        $cohorts      = Cohort::orderByDesc('batch_number')->get();
        $sectors      = Application::distinct()->pluck('sector')->filter();

        $statusCounts = [
            'all'          => Application::count(),
            'pending'      => Application::where('status', 'pending')->count(),
            'under_review' => Application::where('status', 'under_review')->count(),
            'shortlisted'  => Application::where('status', 'shortlisted')->count(),
            'approved'     => Application::where('status', 'approved')->count(),
            'rejected'     => Application::where('status', 'rejected')->count(),
        ];

        return view('admin.applications.index', compact('applications', 'cohorts', 'sectors', 'statusCounts'));
    }

    public function show(Application $application)
    {
        $application->load('cohort', 'reviewer');
        return view('admin.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status'       => 'required|in:pending,under_review,shortlisted,approved,rejected,withdrawn',
            'review_notes' => 'nullable|string|max:2000',
        ]);

        $oldStatus = $application->status;

        $application->update([
            'status'       => $request->status,
            'review_notes' => $request->review_notes,
            'reviewed_by'  => Auth::id(),
            'reviewed_at'  => now(),
        ]);

        // Internal notification for all admins
        Notification::notifyAdmins(
            'application_status',
            'Application Status Updated',
            "Application #{$application->reference_number} for {$application->startup_name} changed from " .
            ucfirst($oldStatus) . " to " . ucfirst($request->status) . ".",
            ['application_id' => $application->id],
            route('admin.applications.show', $application)
        );

        return back()->with('success', 'Application status updated to ' . ucfirst($request->status) . '.');
    }

    public function destroy(Application $application)
    {
        $application->delete();
        return redirect()->route('admin.applications.index')
            ->with('success', 'Application deleted.');
    }
}
