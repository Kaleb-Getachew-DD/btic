{{-- FILE: resources/views/admin/startups/edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'Edit Startup')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.startups.index') }}">Startups</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Edit</span>
@endsection

@section('content')
<div class="page-header">
    <div><h1 class="page-title">Edit: {{ $startup->name }}</h1></div>
    <div class="page-actions">
        <a href="{{ route('startups.show',$startup->slug) }}" class="btn btn-secondary btn-sm" target="_blank"><i class="fas fa-external-link-alt"></i> View Live</a>
        <a href="{{ route('admin.startups.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<form method="POST" action="{{ route('admin.startups.update',$startup) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">
        <div>
            <div class="admin-form-section">
                <div class="admin-form-section-header"><div class="admin-form-section-icon"><i class="fas fa-info-circle"></i></div><div class="admin-form-section-title">Basic Information</div></div>
                <div class="admin-form-section-body">
                    <div class="form-grid">
                        <div class="form-group"><label class="form-label">Name <span class="required">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name',$startup->name) }}" required></div>
                        <div class="form-group"><label class="form-label">Tagline</label><input type="text" name="tagline" class="form-control" value="{{ old('tagline',$startup->tagline) }}"></div>
                        <div class="form-group">
                            <label class="form-label">Sector <span class="required">*</span></label>
                            <select name="sector" class="form-control" required>
                                @foreach(['AgriTech','HealthTech','EdTech','FinTech','LogisticsTech','CleanTech','E-commerce','Mobile & Apps','SaaS/Software','Manufacturing','Other'] as $sector)
                                    <option value="{{ $sector }}" {{ old('sector',$startup->sector) === $sector ? 'selected' : '' }}>{{ $sector }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stage <span class="required">*</span></label>
                            <select name="stage" class="form-control" required>
                                @foreach(['idea'=>'Idea','prototype'=>'Prototype','mvp'=>'MVP','early_traction'=>'Early Traction','growth'=>'Growth'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('stage',$startup->stage) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group"><label class="form-label">Cohort Batch</label><input type="text" name="cohort_batch" class="form-control" value="{{ old('cohort_batch',$startup->cohort_batch) }}"></div>
                        <div class="form-group"><label class="form-label">Founded Year</label><input type="text" name="founded_year" class="form-control" value="{{ old('founded_year',$startup->founded_year) }}"></div>
                        <div class="form-group"><label class="form-label">Location</label><input type="text" name="location" class="form-control" value="{{ old('location',$startup->location) }}"></div>
                        <div class="form-group"><label class="form-label">Team Size</label><input type="number" name="team_size" class="form-control" value="{{ old('team_size',$startup->team_size) }}" min="1"></div>
                    </div>
                    <div class="form-group"><label class="form-label">Description <span class="required">*</span></label><textarea name="description" class="form-control" rows="3" required>{{ old('description',$startup->description) }}</textarea></div>
                    <div class="form-group"><label class="form-label">Full Story</label><textarea name="full_story" class="form-control" rows="5">{{ old('full_story',$startup->full_story) }}</textarea></div>
                </div>
            </div>
            <div class="admin-form-section">
                <div class="admin-form-section-header"><div class="admin-form-section-icon"><i class="fas fa-user"></i></div><div class="admin-form-section-title">Founder Details</div></div>
                <div class="admin-form-section-body">
                    <div class="form-grid">
                        <div class="form-group"><label class="form-label">Founder Name <span class="required">*</span></label><input type="text" name="founder_name" class="form-control" value="{{ old('founder_name',$startup->founder_name) }}" required></div>
                        <div class="form-group"><label class="form-label">Founder Title</label><input type="text" name="founder_title" class="form-control" value="{{ old('founder_title',$startup->founder_title) }}"></div>
                    </div>
                    <div class="form-group"><label class="form-label">Founder Bio</label><textarea name="founder_bio" class="form-control" rows="3">{{ old('founder_bio',$startup->founder_bio) }}</textarea></div>
                    <div class="form-group">
                        <label class="form-label">Founder Photo</label>
                        @if($startup->founder_photo)<img src="{{ asset('storage/'.$startup->founder_photo) }}" alt="" style="width:60px;height:60px;border-radius:50%;object-fit:cover;margin-bottom:8px;border:2px solid var(--border);">@endif
                        <input type="file" name="founder_photo" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="admin-form-section">
                <div class="admin-form-section-header"><div class="admin-form-section-icon"><i class="fas fa-link"></i></div><div class="admin-form-section-title">Links & Social</div></div>
                <div class="admin-form-section-body">
                    <div class="form-grid">
                        <div class="form-group"><label class="form-label">Website</label><input type="url" name="website" class="form-control" value="{{ old('website',$startup->website) }}"></div>
                        <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email',$startup->email) }}"></div>
                        <div class="form-group"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone',$startup->phone) }}"></div>
                        <div class="form-group"><label class="form-label">LinkedIn</label><input type="url" name="linkedin" class="form-control" value="{{ old('linkedin',$startup->linkedin) }}"></div>
                        <div class="form-group"><label class="form-label">Twitter</label><input type="url" name="twitter" class="form-control" value="{{ old('twitter',$startup->twitter) }}"></div>
                        <div class="form-group"><label class="form-label">Facebook</label><input type="url" name="facebook" class="form-control" value="{{ old('facebook',$startup->facebook) }}"></div>
                    </div>
                </div>
            </div>
            <div class="admin-form-section">
                <div class="admin-form-section-header"><div class="admin-form-section-icon"><i class="fas fa-trophy"></i></div><div class="admin-form-section-title">Achievements</div></div>
                <div class="admin-form-section-body">
                    <div class="form-group">
                        <label class="form-label">Key Achievements (one per line)</label>
                        <textarea name="achievements" class="form-control" rows="4">{{ old('achievements', is_array($startup->achievements) ? implode("\n",$startup->achievements) : '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header"><div class="admin-form-section-icon"><i class="fas fa-toggle-on"></i></div><div class="admin-form-section-title">Visibility</div></div>
                <div class="admin-form-section-body">
                    <div class="form-group"><label class="form-toggle"><div class="toggle-switch"><input type="checkbox" name="is_active" value="1" {{ old('is_active',$startup->is_active) ? 'checked' : '' }}><span class="toggle-slider"></span></div><span class="toggle-label">Active</span></label></div>
                    <div class="form-group" style="margin-top:12px;"><label class="form-toggle"><div class="toggle-switch"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured',$startup->is_featured) ? 'checked' : '' }}><span class="toggle-slider"></span></div><span class="toggle-label">Featured</span></label></div>
                    <div class="form-group" style="margin-top:12px;"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$startup->sort_order) }}" min="0"></div>
                </div>
            </div>
            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header"><div class="admin-form-section-icon"><i class="fas fa-image"></i></div><div class="admin-form-section-title">Images</div></div>
                <div class="admin-form-section-body">
                    <div class="form-group">
                        <label class="form-label">Logo</label>
                        @if($startup->logo)<img src="{{ asset('storage/'.$startup->logo) }}" alt="" style="max-height:60px;margin-bottom:8px;border:1px solid var(--border);border-radius:6px;padding:4px;">@endif
                        <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cover Image</label>
                        @if($startup->cover_image)<img src="{{ asset('storage/'.$startup->cover_image) }}" alt="" style="max-height:80px;width:100%;object-fit:cover;margin-bottom:8px;border-radius:6px;">@endif
                        <input type="file" name="cover_image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary" style="flex:1;"><i class="fas fa-save"></i> Update</button>
                <form method="POST" action="{{ route('admin.startups.destroy',$startup) }}" onsubmit="return confirm('Delete this startup?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
</form>
@endsection
