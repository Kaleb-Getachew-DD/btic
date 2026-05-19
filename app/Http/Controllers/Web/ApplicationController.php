<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreApplicationRequest;
use App\Models\Application;
use App\Models\Cohort;
use App\Models\Notification;

class ApplicationController extends Controller
{
    public function create()
    {
        $cohorts = Cohort::whereIn('status', ['open'])->get();
        $openCohort = $cohorts->first();

        return view('web.apply.index', compact('cohorts', 'openCohort'));
    }

    public function store(StoreApplicationRequest $request)
    {
        $data = $request->validated();

        // Handle file uploads
        if ($request->hasFile('pitch_deck')) {
            $data['pitch_deck'] = $request->file('pitch_deck')
                ->store('applications/pitch-decks', 'public');
        }
        if ($request->hasFile('business_plan')) {
            $data['business_plan'] = $request->file('business_plan')
                ->store('applications/business-plans', 'public');
        }

        $application = Application::create($data);

        // Notify all admins
        Notification::notifyAdmins(
            'new_application',
            'New Startup Application Received',
            "A new application has been submitted by {$application->founder_name} for startup '{$application->startup_name}' (Ref: {$application->reference_number}).",
            ['application_id' => $application->id],
            route('admin.applications.show', $application)
        );

        return redirect()->route('apply.success')
            ->with('application_ref', $application->reference_number)
            ->with('startup_name', $application->startup_name);
    }

    public function success()
    {
        $ref  = session('application_ref');
        $name = session('startup_name');

        if (!$ref) {
            return redirect()->route('apply.create');
        }

        return view('web.apply.success', compact('ref', 'name'));
    }
}
