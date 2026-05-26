@extends('layouts.app')
@section('title', 'Track Application')
@section('meta_description', 'Check your DDU BTIC incubation application status using your reference number.')

@section('content')
<section class="form-section" style="padding-top:100px;padding-bottom:80px;">
    <div class="form-container" style="max-width:720px;">

        <div class="form-header" style="margin-bottom:28px;">
            <div class="section-tag section-tag--on-dark" style="position:relative;z-index:1;">
                <i class="fas fa-search"></i> Application Status
            </div>
            <h1 class="form-header-title" style="font-size:2rem;">Track Your Application</h1>
            <p class="form-header-sub">Enter the reference number you received after submitting your application (e.g. <strong>BTIC-XXXXXXXX</strong>).</p>
        </div>

        <div style="background:white;border-radius:var(--radius-xl);padding:28px 32px;border:1px solid var(--light-gray);box-shadow:var(--shadow-md);margin-bottom:28px;">
            <form method="POST" action="{{ route('apply.track.lookup') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="reference_number">Reference Number <span class="required">*</span></label>
                    <input
                        type="text"
                        id="reference_number"
                        name="reference_number"
                        class="form-control @error('reference_number') is-invalid @enderror"
                        value="{{ $reference ?? '' }}"
                        placeholder="BTIC-XXXXXXXX"
                        required
                        autocomplete="off"
                        style="font-family:var(--font-mono);letter-spacing:0.06em;text-transform:uppercase;"
                    >
                    @error('reference_number')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px;">
                    <i class="fas fa-search"></i> Check Status
                </button>
            </form>
        </div>

        @if($reference && !isset($application))
        <div class="alert alert-warning" style="margin-bottom:24px;">
            <i class="fas fa-exclamation-circle"></i>
            <span>No application found for <strong>{{ $reference }}</strong>. Please check the reference number and try again.</span>
        </div>
        @endif

        @isset($application)
        <div style="background:white;border-radius:var(--radius-xl);border:1px solid var(--light-gray);box-shadow:var(--shadow-md);overflow:hidden;">
            <div style="background:linear-gradient(135deg,var(--navy),var(--crimson));padding:24px 28px;color:white;">
                <div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.1em;opacity:0.75;margin-bottom:6px;">Application Found</div>
                <h2 style="font-family:var(--font-display);font-size:1.5rem;font-weight:800;margin-bottom:4px;">{{ $application->startup_name }}</h2>
                <div style="font-family:var(--font-mono);font-size:0.95rem;opacity:0.9;">{{ $application->reference_number }}</div>
            </div>

            <div style="padding:28px 32px;">
                @php
                    $statusSteps = [
                        'pending' => ['label' => 'Submitted', 'icon' => 'fa-inbox'],
                        'under_review' => ['label' => 'Under Review', 'icon' => 'fa-search'],
                        'shortlisted' => ['label' => 'Shortlisted', 'icon' => 'fa-star'],
                        'approved' => ['label' => 'Approved', 'icon' => 'fa-check-circle'],
                        'rejected' => ['label' => 'Not Selected', 'icon' => 'fa-times-circle'],
                        'withdrawn' => ['label' => 'Withdrawn', 'icon' => 'fa-ban'],
                    ];
                    $current = $application->status;
                    $statusColors = [
                        'pending' => 'var(--yellow)',
                        'under_review' => 'var(--blue)',
                        'shortlisted' => 'var(--green)',
                        'approved' => 'var(--green)',
                        'rejected' => 'var(--brown)',
                        'withdrawn' => 'var(--tan)',
                    ];
                @endphp

                <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;flex-wrap:wrap;">
                    <span style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:999px;font-weight:700;font-size:0.9rem;background:{{ $statusColors[$current] ?? 'var(--tan)' }}22;color:{{ $statusColors[$current] ?? 'var(--brown)' }};">
                        <i class="fas {{ $statusSteps[$current]['icon'] ?? 'fa-circle' }}"></i>
                        {{ $application->status_label }}
                    </span>
                    <span style="font-size:0.85rem;color:var(--text-body);">
                        Submitted {{ $application->created_at->format('M d, Y') }}
                    </span>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px;">
                    <div style="padding:14px;background:var(--off-white);border-radius:var(--radius-md);">
                        <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;color:var(--mid-gray);margin-bottom:4px;">Cohort</div>
                        <div style="font-weight:700;color:var(--text-dark);">{{ $application->cohort->name ?? '—' }}</div>
                    </div>
                    <div style="padding:14px;background:var(--off-white);border-radius:var(--radius-md);">
                        <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;color:var(--mid-gray);margin-bottom:4px;">Founder</div>
                        <div style="font-weight:700;color:var(--text-dark);">{{ $application->founder_name }}</div>
                    </div>
                </div>

                @if($application->reviewed_at)
                <p style="font-size:0.82rem;color:var(--mid-gray);margin-bottom:20px;">
                    <i class="fas fa-clock"></i> Last updated {{ $application->reviewed_at->format('M d, Y \a\t g:i A') }}
                </p>
                @endif

                @if($application->review_notes)
                <div style="border-left:4px solid var(--gold);padding:16px 20px;background:var(--gold-pale);border-radius:0 var(--radius-md) var(--radius-md) 0;margin-bottom:8px;">
                    <div style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:var(--navy);margin-bottom:8px;">
                        <i class="fas fa-comment-dots"></i> Review Comments
                    </div>
                    <p style="font-size:0.92rem;color:var(--text-body);line-height:1.7;white-space:pre-line;margin:0;">{{ $application->review_notes }}</p>
                </div>
                @else
                <div style="padding:16px;background:var(--off-white);border-radius:var(--radius-md);font-size:0.88rem;color:var(--text-body);">
                    <i class="fas fa-info-circle" style="color:var(--navy);"></i>
                    No review comments yet. Our team will post updates here as your application progresses.
                </div>
                @endif
            </div>
        </div>
        @endisset

        <p style="text-align:center;margin-top:24px;font-size:0.85rem;color:var(--mid-gray);">
            Haven't applied yet?
            <a href="{{ route('apply.create') }}" style="color:var(--crimson);font-weight:600;">Submit an application</a>
        </p>
    </div>
</section>
@endsection
