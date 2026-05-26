@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="section-tag section-tag--on-dark">
                <i class="fas fa-envelope"></i> Get In Touch
            </div>
            <h1 class="page-hero-title">Contact DDU BTIC</h1>
            <p class="page-hero-sub">Have a question, partnership proposal, or just want to say hello? We'd love to hear from you.</p>
            <div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span class="current">Contact</span></div>
        </div>
    </div>
</section>

<section class="section section-light">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1.5fr;gap:48px;align-items:start;">

            {{-- Contact Info --}}
            <div>
                <div class="section-tag" style="margin-bottom:20px;"><i class="fas fa-map-marker-alt"></i> Find Us</div>
                <h2 style="font-size:1.5rem;font-weight:700;color:var(--text-dark);margin-bottom:8px;">We're Here to Help</h2>
                <div class="divider-gold"></div>
                <p style="margin-top:16px;color:var(--text-body);line-height:1.8;margin-bottom:32px;">
                    Whether you're a startup founder, investor, corporate partner, or student — our team is ready to answer your questions.
                </p>

                <div style="display:flex;flex-direction:column;gap:20px;">
                    @php
                        $contacts = [
                            ['icon'=>'fa-map-marker-alt','label'=>'Address','value'=>\App\Models\Setting::get('contact_address','Dire Dawa University, P.O. Box 1362, Dire Dawa, Ethiopia')],
                            ['icon'=>'fa-phone','label'=>'Phone','value'=>\App\Models\Setting::get('contact_phone','+251 25 111 0000'),'href'=>'tel:'.preg_replace('/\s/','',(string)\App\Models\Setting::get('contact_phone'))],
                            ['icon'=>'fa-envelope','label'=>'Email','value'=>\App\Models\Setting::get('contact_email','btic@ddu.edu.et'),'href'=>'mailto:'.\App\Models\Setting::get('contact_email','btic@ddu.edu.et')],
                            ['icon'=>'fa-clock','label'=>'Office Hours','value'=>'Monday – Friday, 8:00 AM – 5:00 PM EAT'],
                        ];
                    @endphp
                    @foreach($contacts as $c)
                    <div style="display:flex;gap:16px;align-items:flex-start;">
                        <div style="width:48px;height:48px;background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 8px 20px rgba(26,74,158,0.2);">
                            <i class="fas {{ $c['icon'] }}" style="color:white;font-size:1rem;"></i>
                        </div>
                        <div>
                            <div style="font-size:0.75rem;font-weight:700;color:var(--mid-gray);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:3px;">{{ $c['label'] }}</div>
                            @if(isset($c['href']))
                                <a href="{{ $c['href'] }}" style="font-size:0.95rem;color:var(--text-dark);font-weight:500;transition:var(--transition);">{{ $c['value'] }}</a>
                            @else
                                <div style="font-size:0.95rem;color:var(--text-dark);font-weight:500;">{{ $c['value'] }}</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Social --}}
                <div style="margin-top:32px;padding-top:24px;border-top:1px solid var(--light-gray);">
                    <div style="font-size:0.8rem;font-weight:700;color:var(--mid-gray);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:14px;">Follow Us</div>
                    <div style="display:flex;gap:10px;">
                        @if(\App\Models\Setting::get('facebook_url'))
                            <a href="{{ \App\Models\Setting::get('facebook_url') }}" class="team-social-link" target="_blank" style="background:var(--crimson);color:white;"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if(\App\Models\Setting::get('twitter_url'))
                            <a href="{{ \App\Models\Setting::get('twitter_url') }}" class="team-social-link" target="_blank" style="background:var(--crimson);color:white;"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if(\App\Models\Setting::get('linkedin_url'))
                            <a href="{{ \App\Models\Setting::get('linkedin_url') }}" class="team-social-link" target="_blank" style="background:var(--crimson);color:white;"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div style="background:white;border-radius:var(--radius-xl);padding:40px;box-shadow:var(--shadow-lg);border:1px solid var(--light-gray);">
                <h3 style="font-size:1.2rem;font-weight:700;color:var(--text-dark);margin-bottom:6px;">Send Us a Message</h3>
                <p style="font-size:0.875rem;color:var(--mid-gray);margin-bottom:28px;">We respond to all messages within 1 business day.</p>

                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom:24px;" data-auto-dismiss="6000">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Your Name <span class="required">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Full name" required>
                            @error('name')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address <span class="required">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="your@email.com" required>
                            @error('email')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+251 91 ...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Subject <span class="required">*</span></label>
                            <select name="subject" class="form-control" required>
                                <option value="">Select subject...</option>
                                @foreach(['General Inquiry','Program Information','Application Support','Partnership Proposal','Investment Inquiry','Media & Press','Other'] as $subject)
                                    <option value="{{ $subject }}" {{ old('subject') === $subject ? 'selected' : '' }}>{{ $subject }}</option>
                                @endforeach
                            </select>
                            @error('subject')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message <span class="required">*</span></label>
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                            rows="5" placeholder="Write your message here..." required minlength="20">{{ old('message') }}</textarea>
                        @error('message')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
        </div>

        {{-- Quick Links --}}
        <div style="margin-top:64px;display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
            @php
                $quickLinks = [
                    ['icon'=>'fa-paper-plane','title'=>'Apply for Incubation','desc'=>'Ready to join BTIC? Submit your startup application today.','link'=>route('apply.create'),'label'=>'Apply Now'],
                    ['icon'=>'fa-rocket','title'=>'Explore Startups','desc'=>'Discover the innovative startups already in our portfolio.','link'=>route('startups.index'),'label'=>'View Portfolio'],
                    ['icon'=>'fa-graduation-cap','title'=>'Learn About Programs','desc'=>'Find the right program for your stage and goals.','link'=>route('programs.index'),'label'=>'See Programs'],
                ];
            @endphp
            @foreach($quickLinks as $ql)
            <div style="background:white;border:1px solid var(--light-gray);border-radius:var(--radius-lg);padding:28px;text-align:center;box-shadow:var(--shadow-sm);transition:var(--transition);" class="value-card">
                <div style="width:56px;height:56px;background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 8px 20px rgba(26,74,158,0.2);">
                    <i class="fas {{ $ql['icon'] }}" style="color:white;font-size:1.25rem;"></i>
                </div>
                <h4 style="font-size:0.95rem;font-weight:700;color:var(--text-dark);margin-bottom:8px;">{{ $ql['title'] }}</h4>
                <p style="font-size:0.82rem;color:var(--text-body);line-height:1.6;margin-bottom:16px;">{{ $ql['desc'] }}</p>
                <a href="{{ $ql['link'] }}" class="btn btn-outline btn-sm">{{ $ql['label'] }} →</a>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
