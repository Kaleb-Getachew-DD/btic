@extends('layouts.app')
@section('title', 'Apply for Incubation')
@section('meta_description', 'Apply to join DDU BTIC — Dire Dawa University Business and Technology Incubation Center. Open for innovative startups.')

@section('content')
<div class="form-section">
    <div class="form-container">

        {{-- Header --}}
        <div class="form-header">
            <div class="section-tag section-tag--on-dark" style="position:relative;z-index:1;">
                <i class="fas fa-paper-plane"></i> Cohort Application
            </div>
            <h1 class="form-header-title">Apply for DDU BTIC Incubation</h1>
            <p class="form-header-sub">Complete the application below. We review all applications within 2 weeks and contact you by email.</p>
            <p style="margin-top:12px;font-size:0.88rem;opacity:0.85;position:relative;z-index:1;">
                Already applied?
                <a href="{{ route('apply.track') }}" style="color:var(--gold-light);font-weight:600;text-decoration:underline;">Track your application status</a>
            </p>
        </div>

        @if($cohorts->isEmpty())
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>No open cohorts at the moment.</strong>
                    Applications are not currently being accepted. Please check back later or <a href="{{ route('contact.index') }}" style="color:inherit;font-weight:700;text-decoration:underline;">contact us</a> for information on upcoming cohorts.
                </div>
            </div>
        @else

        {{-- Progress Steps --}}
        <div class="progress-steps">
            @php
                $steps = ['Startup Info','Founder Details','Problem & Solution','Support & Goals','Documents'];
            @endphp
            @foreach($steps as $i => $step)
                <div class="progress-step" data-step="{{ $i }}">
                    <div class="progress-step-num">{{ $i + 1 }}</div>
                    <div class="progress-step-label">{{ $step }}</div>
                </div>
                @if(!$loop->last)
                    <div class="progress-line"></div>
                @endif
            @endforeach
        </div>

        {{-- Errors --}}
        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin-top:6px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('apply.store') }}" enctype="multipart/form-data" id="applicationForm" class="needs-validation">
            @csrf

            {{-- STEP 1: Startup Info --}}
            <div class="form-step">
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-step">1</div>
                        <div class="form-card-title">Startup Information</div>
                    </div>
                    <div class="form-card-body">
                        <div class="form-group">
                            <label class="form-label">Select Cohort <span class="required">*</span></label>
                            <select name="cohort_id" class="form-control @error('cohort_id') is-invalid @enderror" required>
                                <option value="">Choose a cohort...</option>
                                @foreach($cohorts as $cohort)
                                    <option value="{{ $cohort->id }}" {{ old('cohort_id') == $cohort->id ? 'selected' : '' }}>
                                        {{ $cohort->name }} — Closes {{ $cohort->application_end->format('M d, Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Startup Name <span class="required">*</span></label>
                                <input type="text" name="startup_name" class="form-control @error('startup_name') is-invalid @enderror"
                                    value="{{ old('startup_name') }}" placeholder="Your startup's official name" required>
                                @error('startup_name')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tagline</label>
                                <input type="text" name="tagline" class="form-control" value="{{ old('tagline') }}" placeholder="One powerful sentence about your startup">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Startup Description <span class="required">*</span></label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                placeholder="Describe what your startup does, the product/service, and your vision (max 2000 chars)" required maxlength="2000">{{ old('description') }}</textarea>
                            @error('description')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Industry Sector <span class="required">*</span></label>
                                <select name="sector" class="form-control" required>
                                    <option value="">Select sector...</option>
                                    @foreach(['AgriTech','HealthTech','EdTech','FinTech','LogisticsTech','CleanTech','E-commerce','Mobile & Apps','SaaS/Software','Manufacturing','Other'] as $sector)
                                        <option value="{{ $sector }}" {{ old('sector') === $sector ? 'selected' : '' }}>{{ $sector }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Startup Stage <span class="required">*</span></label>
                                <select name="stage" class="form-control" required>
                                    <option value="">Select stage...</option>
                                    <option value="idea" {{ old('stage') === 'idea' ? 'selected' : '' }}>Idea — Concept not yet validated</option>
                                    <option value="prototype" {{ old('stage') === 'prototype' ? 'selected' : '' }}>Prototype — Working demo built</option>
                                    <option value="mvp" {{ old('stage') === 'mvp' ? 'selected' : '' }}>MVP — Minimum viable product launched</option>
                                    <option value="early_traction" {{ old('stage') === 'early_traction' ? 'selected' : '' }}>Early Traction — First users/customers</option>
                                    <option value="growth" {{ old('stage') === 'growth' ? 'selected' : '' }}>Growth — Scaling the business</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Website (if any)</label>
                            <input type="url" name="website" class="form-control" value="{{ old('website') }}" placeholder="https://...">
                        </div>
                    </div>
                </div>
                <div style="display:flex;justify-content:flex-end;margin-top:16px;">
                    <button type="button" class="btn btn-primary" data-next>Next: Founder Details <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 2: Founder Info --}}
            <div class="form-step" style="display:none;">
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-step">2</div>
                        <div class="form-card-title">Founder & Team Information</div>
                    </div>
                    <div class="form-card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Full Name <span class="required">*</span></label>
                                <input type="text" name="founder_name" class="form-control" value="{{ old('founder_name') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Address <span class="required">*</span></label>
                                <input type="email" name="founder_email" class="form-control" value="{{ old('founder_email') }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Phone Number <span class="required">*</span></label>
                                <input type="tel" name="founder_phone" class="form-control" value="{{ old('founder_phone') }}" placeholder="+251 91 234 5678" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Gender <span class="required">*</span></label>
                                <select name="founder_gender" class="form-control" required>
                                    <option value="">Select...</option>
                                    <option value="Male" {{ old('founder_gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('founder_gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Prefer not to say" {{ old('founder_gender') === 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Age Range <span class="required">*</span></label>
                                <select name="founder_age_range" class="form-control" required>
                                    <option value="">Select...</option>
                                    @foreach(['18-24','25-34','35-44','45-54','55+'] as $range)
                                        <option value="{{ $range }}" {{ old('founder_age_range') === $range ? 'selected' : '' }}>{{ $range }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Highest Education Level</label>
                                <select name="founder_education" class="form-control">
                                    <option value="">Select...</option>
                                    @foreach(['High School','Diploma/Certificate','Bachelor\'s Degree','Master\'s Degree','PhD','Other'] as $edu)
                                        <option value="{{ $edu }}" {{ old('founder_education') === $edu ? 'selected' : '' }}>{{ $edu }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">University Affiliation (if any)</label>
                            <input type="text" name="university_affiliation" class="form-control" value="{{ old('university_affiliation') }}"
                                placeholder="e.g. Student/Alumni of Dire Dawa University">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Total Team Size <span class="required">*</span></label>
                                <input type="number" name="team_size" class="form-control" value="{{ old('team_size', 1) }}" min="1" max="50" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Team Background & Expertise</label>
                            <textarea name="team_background" class="form-control" rows="3"
                                placeholder="Briefly describe your team members and their relevant skills/experience">{{ old('team_background') }}</textarea>
                        </div>
                    </div>
                </div>
                <div style="display:flex;justify-content:space-between;margin-top:16px;">
                    <button type="button" class="btn btn-outline" data-prev><i class="fas fa-arrow-left"></i> Back</button>
                    <button type="button" class="btn btn-primary" data-next>Next: Problem & Solution <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 3: Problem & Solution --}}
            <div class="form-step" style="display:none;">
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-step">3</div>
                        <div class="form-card-title">Problem, Solution & Market</div>
                    </div>
                    <div class="form-card-body">
                        <div class="form-group">
                            <label class="form-label">Problem Statement <span class="required">*</span></label>
                            <textarea name="problem_statement" class="form-control" rows="4" maxlength="1500"
                                placeholder="What specific problem are you solving? Who experiences this problem and how severely?" required>{{ old('problem_statement') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Your Solution <span class="required">*</span></label>
                            <textarea name="solution" class="form-control" rows="4" maxlength="1500"
                                placeholder="How does your startup solve this problem? What makes your approach unique?" required>{{ old('solution') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Target Market <span class="required">*</span></label>
                            <textarea name="target_market" class="form-control" rows="3" maxlength="1000"
                                placeholder="Who are your target customers? Describe the size and characteristics of your market." required>{{ old('target_market') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Business Model</label>
                            <textarea name="business_model" class="form-control" rows="3" maxlength="1000"
                                placeholder="How will your startup generate revenue? (e.g. subscription, commission, freemium)">{{ old('business_model') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Competitive Advantage</label>
                            <textarea name="competitive_advantage" class="form-control" rows="3" maxlength="1000"
                                placeholder="What makes your solution better than existing alternatives?">{{ old('competitive_advantage') }}</textarea>
                        </div>
                    </div>
                </div>
                <div style="display:flex;justify-content:space-between;margin-top:16px;">
                    <button type="button" class="btn btn-outline" data-prev><i class="fas fa-arrow-left"></i> Back</button>
                    <button type="button" class="btn btn-primary" data-next>Next: Traction & Support <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 4: Support & Goals --}}
            <div class="form-step" style="display:none;">
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-step">4</div>
                        <div class="form-card-title">Current Traction & Support Needed</div>
                    </div>
                    <div class="form-card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Monthly Revenue (if any)</label>
                                <input type="text" name="monthly_revenue" class="form-control" value="{{ old('monthly_revenue') }}" placeholder="e.g. ETB 0, ETB 50,000">
                            </div>
                            <div class="form-group" style="display:flex;align-items:flex-end;padding-bottom:4px;">
                                <label class="form-toggle" style="cursor:pointer;">
                                    <input type="hidden" name="has_funding" value="0">
                                    <input type="checkbox" name="has_funding" value="1" {{ old('has_funding') ? 'checked' : '' }} style="display:none;" id="hasFunding">
                                    <div style="width:44px;height:24px;background:var(--tan);border-radius:100px;position:relative;cursor:pointer;transition:0.3s;" id="fundingToggleTrack">
                                        <div style="width:18px;height:18px;background:var(--white);border-radius:50%;position:absolute;top:3px;left:3px;transition:0.3s;box-shadow:0 1px 3px rgba(0,0,0,0.2);"></div>
                                    </div>
                                    <span style="font-size:0.9rem;font-weight:500;color:var(--text-dark);">Has existing funding?</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Current Traction</label>
                            <textarea name="current_traction" class="form-control" rows="3" maxlength="1000"
                                placeholder="Any existing users, customers, partnerships, pilots, or revenue? Describe your traction.">{{ old('current_traction') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Support Needed from BTIC <span class="required">*</span></label>
                            <div class="form-hint" style="margin-bottom:10px;">Select all that apply</div>
                            <div class="checkbox-group">
                                @php
                                    $supports = ['Mentorship','Business Development','Technical Support','Legal & Compliance','Market Access','Funding/Investment','Co-working Space','Product Development','Marketing & Branding','Government Relations'];
                                    $oldSupports = old('support_needed', []);
                                @endphp
                                @foreach($supports as $support)
                                <label class="checkbox-item">
                                    <input type="checkbox" name="support_needed[]" value="{{ $support }}"
                                        {{ in_array($support, $oldSupports) ? 'checked' : '' }}>
                                    {{ $support }}
                                </label>
                                @endforeach
                            </div>
                            @error('support_needed')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Why DDU BTIC?</label>
                            <textarea name="why_btic" class="form-control" rows="3" maxlength="1000"
                                placeholder="Why are you applying to BTIC specifically? What do you hope to achieve?">{{ old('why_btic') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">6-Month Goals</label>
                            <textarea name="goals" class="form-control" rows="3" maxlength="1000"
                                placeholder="What specific milestones do you aim to achieve during the BTIC program?">{{ old('goals') }}</textarea>
                        </div>
                    </div>
                </div>
                <div style="display:flex;justify-content:space-between;margin-top:16px;">
                    <button type="button" class="btn btn-outline" data-prev><i class="fas fa-arrow-left"></i> Back</button>
                    <button type="button" class="btn btn-primary" data-next>Next: Documents <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            {{-- STEP 5: Documents & Submit --}}
            <div class="form-step" style="display:none;">
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-step">5</div>
                        <div class="form-card-title">Documents & Final Submission</div>
                    </div>
                    <div class="form-card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Pitch Deck <span style="color:var(--text-muted);font-weight:400;">(Optional)</span></label>
                                <input type="file" name="pitch_deck" class="form-control" accept=".pdf,.ppt,.pptx">
                                <div class="form-hint">PDF, PPT, PPTX — Max 10MB</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Business Plan <span style="color:var(--text-muted);font-weight:400;">(Optional)</span></label>
                                <input type="file" name="business_plan" class="form-control" accept=".pdf,.doc,.docx">
                                <div class="form-hint">PDF, DOC, DOCX — Max 10MB</div>
                            </div>
                        </div>

                        {{-- Summary --}}
                        <div style="background:var(--off-white);border-radius:var(--radius-md);padding:20px;border:1px solid var(--light-gray);margin-top:8px;">
                            <h4 style="font-size:0.95rem;font-weight:700;margin-bottom:12px;color:var(--text-dark);">
                                <i class="fas fa-clipboard-check" style="color:var(--crimson);margin-right:8px;"></i>Before Submitting
                            </h4>
                            <ul style="font-size:0.85rem;color:var(--text-body);line-height:1.8;">
                                <li>✅ All required fields are filled accurately</li>
                                <li>✅ Contact information is correct (we will reach you by email)</li>
                                <li>✅ Problem and solution sections clearly describe your startup</li>
                                <li>✅ You understand the 6-month commitment required</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div style="display:flex;justify-content:space-between;margin-top:16px;align-items:center;">
                    <button type="button" class="btn btn-outline" data-prev><i class="fas fa-arrow-left"></i> Back</button>
                    <button type="submit" class="btn btn-primary btn-lg" style="min-width:200px;">
                        <i class="fas fa-paper-plane"></i> Submit Application
                    </button>
                </div>
            </div>

        </form>
        @endif
    </div>
</div>
@endsection
