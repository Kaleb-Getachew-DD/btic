<?php
// FILE: app/Http/Requests/Web/StoreApplicationRequest.php
namespace App\Http\Requests\Web;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'cohort_id'              => 'required|exists:cohorts,id',
            'startup_name'           => 'required|string|max:255',
            'tagline'                => 'nullable|string|max:255',
            'description'            => 'required|string|max:2000',
            'sector'                 => 'required|string|max:100',
            'stage'                  => 'required|in:idea,prototype,mvp,early_traction,growth',
            'website'                => 'nullable|url',
            'founder_name'           => 'required|string|max:255',
            'founder_email'          => 'required|email',
            'founder_phone'          => 'required|string|max:20',
            'founder_gender'         => 'required|string|max:50',
            'founder_age_range'      => 'required|string|max:20',
            'founder_education'      => 'nullable|string|max:255',
            'university_affiliation' => 'nullable|string|max:255',
            'team_size'              => 'required|integer|min:1|max:50',
            'team_background'        => 'nullable|string|max:1000',
            'problem_statement'      => 'required|string|max:1500',
            'solution'               => 'required|string|max:1500',
            'target_market'          => 'required|string|max:1000',
            'business_model'         => 'nullable|string|max:1000',
            'competitive_advantage'  => 'nullable|string|max:1000',
            'current_traction'       => 'nullable|string|max:1000',
            'monthly_revenue'        => 'nullable|string|max:100',
            'has_funding'            => 'boolean',
            'funding_details'        => 'nullable|string|max:500',
            'support_needed'         => 'required|array|min:1',
            'support_needed.*'       => 'string',
            'why_btic'               => 'nullable|string|max:1000',
            'goals'                  => 'nullable|string|max:1000',
            'pitch_deck'             => 'nullable|file|mimes:pdf,ppt,pptx|max:10240',
            'business_plan'          => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'cohort_id.required'    => 'Please select a cohort.',
            'startup_name.required' => 'Please enter your startup name.',
            'support_needed.min'    => 'Please select at least one area of support needed.',
        ];
    }
}
