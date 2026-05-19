{{-- FILE: resources/views/web/apply/success.blade.php --}}
@extends('layouts.app')
@section('title', 'Application Submitted')

@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;background:var(--off-white);padding:80px 24px;">
    <div style="max-width:600px;width:100%;text-align:center;">
        <div style="width:100px;height:100px;background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 32px;box-shadow:0 20px 40px rgba(140,29,53,0.3);">
            <i class="fas fa-check" style="font-size:2.5rem;color:white;"></i>
        </div>
        <div class="section-tag" style="justify-content:center;margin:0 auto 20px;">
            <i class="fas fa-paper-plane"></i> Application Received
        </div>
        <h1 style="font-family:var(--font-display);font-size:2.2rem;font-weight:800;color:var(--text-dark);margin-bottom:16px;line-height:1.2;">
            Congratulations, {{ $name }}!
        </h1>
        <p style="font-size:1.05rem;color:var(--text-body);line-height:1.8;margin-bottom:32px;">
            Your application to DDU BTIC has been successfully submitted. Our review team will carefully evaluate your application and contact you within <strong>2 weeks</strong>.
        </p>

        <div style="background:white;border-radius:var(--radius-xl);padding:28px 32px;border:1px solid var(--light-gray);box-shadow:var(--shadow-md);margin-bottom:32px;text-align:left;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                <div style="width:40px;height:40px;background:var(--gold-pale);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--crimson);">
                    <i class="fas fa-hashtag"></i>
                </div>
                <div>
                    <div style="font-size:0.75rem;color:var(--mid-gray);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Reference Number</div>
                    <div style="font-size:1.2rem;font-weight:800;color:var(--text-dark);font-family:var(--font-mono);">{{ $ref }}</div>
                </div>
            </div>
            <p style="font-size:0.85rem;color:var(--text-body);margin-bottom:16px;">Save this reference number. You'll need it to track your application status online.</p>
            <a href="{{ route('apply.track', ['ref' => $ref]) }}" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="fas fa-search"></i> Track Application Status
            </a>
        </div>

        <div style="background:white;border-radius:var(--radius-xl);padding:28px 32px;border:1px solid var(--light-gray);box-shadow:var(--shadow-md);margin-bottom:32px;text-align:left;">
            <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px;color:var(--text-dark);">What Happens Next?</h3>
            @php
                $steps = [
                    ['icon'=>'fa-envelope','title'=>'Confirmation Email','desc'=>'You will receive a confirmation email within 24 hours.'],
                    ['icon'=>'fa-search','title'=>'Application Review','desc'=>'Our team reviews all applications within 2 weeks.'],
                    ['icon'=>'fa-phone','title'=>'Interview','desc'=>'Shortlisted applicants will be invited for an interview.'],
                    ['icon'=>'fa-trophy','title'=>'Selection Announcement','desc'=>'Final selections are announced and onboarding begins.'],
                ];
            @endphp
            <div style="display:flex;flex-direction:column;gap:12px;">
                @foreach($steps as $i => $step)
                <div style="display:flex;gap:14px;align-items:flex-start;">
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                        <i class="fas {{ $step['icon'] }}" style="color:white;font-size:0.75rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:0.9rem;font-weight:700;color:var(--text-dark);">{{ $step['title'] }}</div>
                        <div style="font-size:0.82rem;color:var(--text-body);">{{ $step['desc'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('apply.track', ['ref' => $ref]) }}" class="btn btn-primary btn-lg"><i class="fas fa-search"></i> Track Status</a>
            <a href="{{ route('home') }}" class="btn btn-outline btn-lg"><i class="fas fa-home"></i> Back to Home</a>
            <a href="{{ route('startups.index') }}" class="btn btn-outline btn-lg"><i class="fas fa-rocket"></i> Meet Our Startups</a>
        </div>
        <p style="margin-top:24px;font-size:0.82rem;color:var(--mid-gray);">
            Questions? Email us at <a href="mailto:{{ \App\Models\Setting::get('contact_email','btic@ddu.edu.et') }}" style="color:var(--crimson);font-weight:500;">{{ \App\Models\Setting::get('contact_email','btic@ddu.edu.et') }}</a>
        </p>
    </div>
</div>
@endsection
