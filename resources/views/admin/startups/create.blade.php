@extends('layouts.admin')
@section('title', 'Add Startup')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.startups.index') }}">Startups</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Add Startup</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Add Startup to Portfolio</h1>
    <a href="{{ route('admin.startups.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form method="POST" action="{{ route('admin.startups.store') }}" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">
        <div>
            {{-- Basic Info --}}
            <div class="admin-form-section">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-info-circle"></i></div>
                    <div class="admin-form-section-title">Basic Information</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Startup Name <span class="required">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tagline</label>
                            <input type="text" name="tagline" class="form-control" value="{{ old('tagline') }}" placeholder="One-line description">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sector <span class="required">*</span></label>
                            <select name="sector" class="form-control" required>
                                <option value="">Select sector...</option>
                                @foreach(['AgriTech','HealthTech','EdTech','FinTech','LogisticsTech','CleanTech','E-commerce','Mobile','SaaS','Other'] as $sector)
                                    <option value="{{ $sector }}" {{ old('sector') === $sector ? 'selected' : '' }}>{{ $sector }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stage <span class="required">*</span></label>
                            <select name="stage" class="form-control" required>
                                <option value="">Select stage...</option>
                                @foreach(['idea'=>'Idea','prototype'=>'Prototype','mvp'=>'MVP','early_traction'=>'Early Traction','growth'=>'Growth'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('stage') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Cohort Batch</label>
                            <input type="text" name="cohort_batch" class="form-control" value="{{ old('cohort_batch') }}" placeholder="e.g. Cohort 5">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Founded Year</label>
                            <input type="text" name="founded_year" class="form-control" value="{{ old('founded_year') }}" placeholder="e.g. 2023">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="e.g. Dire Dawa, Ethiopia">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Team Size</label>
                            <input type="number" name="team_size" class="form-control" value="{{ old('team_size', 1) }}" min="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description <span class="required">*</span></label>
                        <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Full Story</label>
                        <textarea name="full_story" class="form-control" rows="5" placeholder="Detailed startup story for the portfolio page...">{{ old('full_story') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Founder --}}
            <div class="admin-form-section">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-user"></i></div>
                    <div class="admin-form-section-title">Founder Details</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Founder Name <span class="required">*</span></label>
                            <input type="text" name="founder_name" class="form-control" value="{{ old('founder_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Founder Title</label>
                            <input type="text" name="founder_title" class="form-control" value="{{ old('founder_title') }}" placeholder="e.g. CEO & Co-Founder">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Founder Bio</label>
                        <textarea name="founder_bio" class="form-control" rows="3" placeholder="Brief founder biography...">{{ old('founder_bio') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Founder Photo</label>
                        <div class="image-upload-area" onclick="this.querySelector('input').click()">
                            <input type="file" name="founder_photo" accept="image/*" style="display:none;">
                            <div class="image-upload-icon"><i class="fas fa-user-circle"></i></div>
                            <div class="image-upload-text">Upload founder photo</div>
                            <div class="image-upload-sub">JPG, PNG — Max 2MB</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact & Social --}}
            <div class="admin-form-section">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-link"></i></div>
                    <div class="admin-form-section-title">Contact & Social Links</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Website</label>
                            <input type="url" name="website" class="form-control" value="{{ old('website') }}" placeholder="https://...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">LinkedIn</label>
                            <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Twitter</label>
                            <input type="url" name="twitter" class="form-control" value="{{ old('twitter') }}" placeholder="https://twitter.com/...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Facebook</label>
                            <input type="url" name="facebook" class="form-control" value="{{ old('facebook') }}" placeholder="https://facebook.com/...">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Metrics & Achievements --}}
            <div class="admin-form-section">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-chart-bar"></i></div>
                    <div class="admin-form-section-title">Metrics & Achievements</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="form-group">
                        <label class="form-label">Key Achievements</label>
                        <textarea name="achievements" class="form-control" rows="4" placeholder="One achievement per line:&#10;Raised $50K seed funding&#10;Won Best Startup Award 2023&#10;10,000 active users">{{ old('achievements') }}</textarea>
                        <div class="form-hint">Enter one achievement per line</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-toggle-on"></i></div>
                    <div class="admin-form-section-title">Visibility</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="form-group">
                        <label class="form-toggle">
                            <div class="toggle-switch">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                            <span class="toggle-label">Active (Show on website)</span>
                        </label>
                    </div>
                    <div class="form-group" style="margin-top:12px;">
                        <label class="form-toggle">
                            <div class="toggle-switch">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                            <span class="toggle-label">Featured on Homepage</span>
                        </label>
                    </div>
                    <div class="form-group" style="margin-top:12px;">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                        <div class="form-hint">Lower = appears first</div>
                    </div>
                </div>
            </div>

            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-image"></i></div>
                    <div class="admin-form-section-title">Images</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="form-group">
                        <label class="form-label">Logo</label>
                        <div class="image-upload-area" onclick="this.querySelector('input').click()">
                            <input type="file" name="logo" accept="image/*" style="display:none;">
                            <div class="image-upload-icon"><i class="fas fa-building"></i></div>
                            <div class="image-upload-text">Upload startup logo</div>
                            <div class="image-upload-sub">PNG, SVG — Max 2MB</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cover Image</label>
                        <div class="image-upload-area" onclick="this.querySelector('input').click()">
                            <input type="file" name="cover_image" accept="image/*" style="display:none;">
                            <div class="image-upload-icon"><i class="fas fa-image"></i></div>
                            <div class="image-upload-text">Upload cover/banner image</div>
                            <div class="image-upload-sub">JPG, PNG — Max 4MB, 1200×630px</div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">
                <i class="fas fa-save"></i> Add to Portfolio
            </button>
        </div>
    </div>
</form>
@endsection
