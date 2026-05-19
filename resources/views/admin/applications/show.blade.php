@extends('layouts.admin')
@section('title', 'Application: '.$application->startup_name)
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.applications.index') }}">Applications</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">{{ $application->startup_name }}</span>
@endsection

@section('content')
<div class="application-detail-header">
    <div>
        <div style="font-size:0.75rem;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:6px;">Startup Application</div>
        <h1 style="font-size:1.75rem;font-weight:800;color:white;margin-bottom:4px;">{{ $application->startup_name }}</h1>
        <div class="application-ref">{{ $application->reference_number }}</div>
    </div>
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <span class="badge {{ $application->status_badge_class }}" style="font-size:0.85rem;padding:6px 16px;">
            {{ $application->status_label }}
        </span>
        <a href="{{ route('admin.applications.index') }}" class="btn btn-outline-white btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="detail-grid">
    {{-- Left: Full Application Details --}}
    <div>
        {{-- Startup Info --}}
        <div class="admin-card" style="margin-bottom:20px;">
            <div class="admin-card-header">
                <div class="admin-card-title"><i class="fas fa-rocket" style="color:var(--crimson);margin-right:8px;"></i>Startup Information</div>
            </div>
            <div class="admin-card-body">
                <div class="detail-2col">
                    <div class="detail-field"><div class="detail-field-label">Startup Name</div><div class="detail-field-value">{{ $application->startup_name }}</div></div>
                    <div class="detail-field"><div class="detail-field-label">Tagline</div><div class="detail-field-value">{{ $application->tagline ?: '—' }}</div></div>
                    <div class="detail-field"><div class="detail-field-label">Sector</div><div class="detail-field-value"><span class="badge badge-primary">{{ $application->sector }}</span></div></div>
                    <div class="detail-field"><div class="detail-field-label">Stage</div><div class="detail-field-value">{{ ucfirst(str_replace('_',' ',$application->stage)) }}</div></div>
                    <div class="detail-field"><div class="detail-field-label">Cohort Applied</div><div class="detail-field-value">{{ $application->cohort->name ?? '—' }}</div></div>
                    <div class="detail-field"><div class="detail-field-label">Website</div><div class="detail-field-value">{{ $application->website ? "<a href='{$application->website}' target='_blank' style='color:var(--crimson);'>{$application->website}</a>" : '—' }}</div></div>
                </div>
                <div class="detail-field" style="margin-top:12px;">
                    <div class="detail-field-label">Description</div>
                    <div class="detail-field-value" style="white-space:pre-line;">{{ $application->description }}</div>
                </div>
            </div>
        </div>

        {{-- Founder Info --}}
        <div class="admin-card" style="margin-bottom:20px;">
            <div class="admin-card-header">
                <div class="admin-card-title"><i class="fas fa-user" style="color:var(--crimson);margin-right:8px;"></i>Founder Information</div>
            </div>
            <div class="admin-card-body">
                <div class="detail-3col">
                    <div class="detail-field"><div class="detail-field-label">Full Name</div><div class="detail-field-value">{{ $application->founder_name }}</div></div>
                    <div class="detail-field"><div class="detail-field-label">Email</div><div class="detail-field-value"><a href="mailto:{{ $application->founder_email }}" style="color:var(--crimson);">{{ $application->founder_email }}</a></div></div>
                    <div class="detail-field"><div class="detail-field-label">Phone</div><div class="detail-field-value">{{ $application->founder_phone }}</div></div>
                    <div class="detail-field"><div class="detail-field-label">Gender</div><div class="detail-field-value">{{ ucfirst($application->founder_gender) }}</div></div>
                    <div class="detail-field"><div class="detail-field-label">Age Range</div><div class="detail-field-value">{{ $application->founder_age_range }}</div></div>
                    <div class="detail-field"><div class="detail-field-label">Education</div><div class="detail-field-value">{{ $application->founder_education ?: '—' }}</div></div>
                    <div class="detail-field"><div class="detail-field-label">University Affiliation</div><div class="detail-field-value">{{ $application->university_affiliation ?: '—' }}</div></div>
                    <div class="detail-field"><div class="detail-field-label">Team Size</div><div class="detail-field-value">{{ $application->team_size }} {{ $application->team_size === 1 ? 'person' : 'people' }}</div></div>
                </div>
                @if($application->team_background)
                <div class="detail-field" style="margin-top:12px;"><div class="detail-field-label">Team Background</div><div class="detail-field-value" style="white-space:pre-line;">{{ $application->team_background }}</div></div>
                @endif
            </div>
        </div>

        {{-- Problem & Solution --}}
        <div class="admin-card" style="margin-bottom:20px;">
            <div class="admin-card-header">
                <div class="admin-card-title"><i class="fas fa-lightbulb" style="color:var(--crimson);margin-right:8px;"></i>Problem & Solution</div>
            </div>
            <div class="admin-card-body">
                <div class="detail-field" style="margin-bottom:16px;"><div class="detail-field-label">Problem Statement</div><div class="detail-field-value" style="white-space:pre-line;">{{ $application->problem_statement }}</div></div>
                <div class="detail-field" style="margin-bottom:16px;"><div class="detail-field-label">Proposed Solution</div><div class="detail-field-value" style="white-space:pre-line;">{{ $application->solution }}</div></div>
                <div class="detail-field" style="margin-bottom:16px;"><div class="detail-field-label">Target Market</div><div class="detail-field-value" style="white-space:pre-line;">{{ $application->target_market }}</div></div>
                @if($application->business_model)
                <div class="detail-field" style="margin-bottom:16px;"><div class="detail-field-label">Business Model</div><div class="detail-field-value" style="white-space:pre-line;">{{ $application->business_model }}</div></div>
                @endif
                @if($application->competitive_advantage)
                <div class="detail-field"><div class="detail-field-label">Competitive Advantage</div><div class="detail-field-value" style="white-space:pre-line;">{{ $application->competitive_advantage }}</div></div>
                @endif
            </div>
        </div>

        {{-- Traction & Support --}}
        <div class="admin-card" style="margin-bottom:20px;">
            <div class="admin-card-header">
                <div class="admin-card-title"><i class="fas fa-chart-line" style="color:var(--crimson);margin-right:8px;"></i>Traction & Support Needed</div>
            </div>
            <div class="admin-card-body">
                <div class="detail-2col">
                    <div class="detail-field"><div class="detail-field-label">Monthly Revenue</div><div class="detail-field-value">{{ $application->monthly_revenue ?: 'Not yet generating revenue' }}</div></div>
                    <div class="detail-field"><div class="detail-field-label">Has Funding?</div><div class="detail-field-value">{{ $application->has_funding ? 'Yes' : 'No' }}</div></div>
                </div>
                @if($application->current_traction)
                <div class="detail-field" style="margin-top:12px;"><div class="detail-field-label">Current Traction</div><div class="detail-field-value" style="white-space:pre-line;">{{ $application->current_traction }}</div></div>
                @endif
                @if($application->funding_details)
                <div class="detail-field" style="margin-top:12px;"><div class="detail-field-label">Funding Details</div><div class="detail-field-value">{{ $application->funding_details }}</div></div>
                @endif
                @if($application->support_needed)
                <div class="detail-field" style="margin-top:12px;">
                    <div class="detail-field-label">Support Needed</div>
                    <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:6px;">
                        @foreach($application->support_needed as $support)
                            <span class="badge badge-primary">{{ $support }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                @if($application->why_btic)
                <div class="detail-field" style="margin-top:12px;"><div class="detail-field-label">Why BTIC?</div><div class="detail-field-value" style="white-space:pre-line;">{{ $application->why_btic }}</div></div>
                @endif
            </div>
        </div>

        {{-- Documents --}}
        @if($application->pitch_deck || $application->business_plan)
        <div class="admin-card">
            <div class="admin-card-header"><div class="admin-card-title"><i class="fas fa-file-pdf" style="color:var(--crimson);margin-right:8px;"></i>Uploaded Documents</div></div>
            <div class="admin-card-body">
                <div style="display:flex;gap:12px;">
                    @if($application->pitch_deck)
                        <a href="{{ asset('storage/'.$application->pitch_deck) }}" target="_blank" class="btn btn-secondary">
                            <i class="fas fa-file-powerpoint" style="color:#E24329;"></i> Pitch Deck
                        </a>
                    @endif
                    @if($application->business_plan)
                        <a href="{{ asset('storage/'.$application->business_plan) }}" target="_blank" class="btn btn-secondary">
                            <i class="fas fa-file-word" style="color:#2B579A;"></i> Business Plan
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Right: Status & Review --}}
    <div>
        <div class="status-form" style="margin-bottom:16px;">
            <div class="status-form-header"><i class="fas fa-tasks" style="margin-right:8px;"></i>Update Application Status</div>
            <div class="status-form-body">
                <form method="POST" action="{{ route('admin.applications.update-status', $application) }}">
                    @csrf @method('PATCH')
                    <div class="status-options">
                        @foreach(['pending'=>'Pending','under_review'=>'Under Review','shortlisted'=>'Shortlisted','approved'=>'Approved','rejected'=>'Rejected','withdrawn'=>'Withdrawn'] as $val => $label)
                        <label class="status-option {{ $application->status === $val ? 'selected' : '' }}">
                            <input type="radio" name="status" value="{{ $val }}" {{ $application->status === $val ? 'checked' : '' }}>
                            <div>
                                <span class="badge {{ ['pending'=>'badge-warning','under_review'=>'badge-info','shortlisted'=>'badge-purple','approved'=>'badge-success','rejected'=>'badge-danger','withdrawn'=>'badge-secondary'][$val] }}">{{ $label }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label class="form-label">Review Notes</label>
                        <textarea name="review_notes" class="form-control" rows="3" placeholder="Internal notes about this application...">{{ old('review_notes', $application->review_notes) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;">
                        <i class="fas fa-save"></i> Save Status
                    </button>
                </form>
            </div>
        </div>

        <div class="admin-card" style="margin-bottom:16px;">
            <div class="admin-card-header"><div class="admin-card-title">Application Timeline</div></div>
            <div class="admin-card-body">
                <div class="detail-field"><div class="detail-field-label">Submitted</div><div class="detail-field-value">{{ $application->created_at->format('M d, Y \a\t h:i A') }}</div></div>
                @if($application->reviewed_at)
                <div class="detail-field" style="margin-top:10px;"><div class="detail-field-label">Last Reviewed</div><div class="detail-field-value">{{ $application->reviewed_at->format('M d, Y \a\t h:i A') }}</div></div>
                @endif
                @if($application->reviewer)
                <div class="detail-field" style="margin-top:10px;"><div class="detail-field-label">Reviewed By</div><div class="detail-field-value">{{ $application->reviewer->name }}</div></div>
                @endif
                @if($application->review_notes)
                <div class="detail-field" style="margin-top:10px;"><div class="detail-field-label">Review Notes</div><div class="detail-field-value" style="white-space:pre-line;">{{ $application->review_notes }}</div></div>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('admin.applications.destroy', $application) }}" onsubmit="return confirm('Permanently delete this application?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" style="width:100%;">
                <i class="fas fa-trash"></i> Delete Application
            </button>
        </form>
    </div>
</div>
@endsection
