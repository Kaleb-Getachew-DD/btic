{{-- FILE: resources/views/admin/settings/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Settings')
@section('breadcrumb')<span class="topbar-breadcrumb-item current">Settings</span>@endsection

@section('content')
<div class="page-header">
    <div><h1 class="page-title">Website Settings</h1><p class="page-subtitle">Customize all aspects of the public website</p></div>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf
    <div class="settings-grid">
        {{-- Nav --}}
        <div class="settings-nav">
            <div class="settings-nav-item active" data-tab="tab-general"><i class="fas fa-globe"></i> General</div>
            <div class="settings-nav-item" data-tab="tab-hero"><i class="fas fa-star"></i> Hero Section</div>
            <div class="settings-nav-item" data-tab="tab-stats"><i class="fas fa-chart-bar"></i> Stats</div>
            <div class="settings-nav-item" data-tab="tab-contact"><i class="fas fa-envelope"></i> Contact</div>
            <div class="settings-nav-item" data-tab="tab-social"><i class="fas fa-share-alt"></i> Social Media</div>
            <div class="settings-nav-item" data-tab="tab-branding"><i class="fas fa-palette"></i> Branding</div>
        </div>

        <div>
            {{-- General Tab --}}
            <div id="tab-general" class="settings-tab">
                <div class="admin-form-section">
                    <div class="admin-form-section-header">
                        <div class="admin-form-section-icon"><i class="fas fa-globe"></i></div>
                        <div class="admin-form-section-title">General Information</div>
                    </div>
                    <div class="admin-form-section-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Site Name</label>
                                <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name']->value ?? 'DDU BTIC' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Site Tagline</label>
                                <input type="text" name="site_tagline" class="form-control" value="{{ $settings['site_tagline']->value ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Site Description</label>
                            <textarea name="site_description" class="form-control" rows="3">{{ $settings['site_description']->value ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div style="margin-top:16px;"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Settings</button></div>
            </div>

            {{-- Hero Tab --}}
            <div id="tab-hero" class="settings-tab" style="display:none;">
                <div class="admin-form-section">
                    <div class="admin-form-section-header">
                        <div class="admin-form-section-icon"><i class="fas fa-star"></i></div>
                        <div class="admin-form-section-title">Hero Section</div>
                    </div>
                    <div class="admin-form-section-body">
                        <div class="form-group">
                            <label class="form-label">Hero Title</label>
                            <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title']->value ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Hero Subtitle</label>
                            <textarea name="hero_subtitle" class="form-control" rows="3">{{ $settings['hero_subtitle']->value ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div style="margin-top:16px;"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button></div>
            </div>

            {{-- Stats Tab --}}
            <div id="tab-stats" class="settings-tab" style="display:none;">
                <div class="admin-form-section">
                    <div class="admin-form-section-header">
                        <div class="admin-form-section-icon"><i class="fas fa-chart-bar"></i></div>
                        <div class="admin-form-section-title">Homepage Statistics</div>
                    </div>
                    <div class="admin-form-section-body">
                        <div class="form-grid">
                            <div class="form-group"><label class="form-label">Startups Incubated</label><input type="text" name="stats_startups" class="form-control" value="{{ $settings['stats_startups']->value ?? '60+' }}"></div>
                            <div class="form-group"><label class="form-label">Cohorts Completed</label><input type="text" name="stats_cohorts" class="form-control" value="{{ $settings['stats_cohorts']->value ?? '6' }}"></div>
                            <div class="form-group"><label class="form-label">Jobs Created</label><input type="text" name="stats_jobs" class="form-control" value="{{ $settings['stats_jobs']->value ?? '300+' }}"></div>
                            <div class="form-group"><label class="form-label">Funding Raised</label><input type="text" name="stats_funding" class="form-control" value="{{ $settings['stats_funding']->value ?? '$1M+' }}"></div>
                        </div>
                    </div>
                </div>
                <div style="margin-top:16px;"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button></div>
            </div>

            {{-- Contact Tab --}}
            <div id="tab-contact" class="settings-tab" style="display:none;">
                <div class="admin-form-section">
                    <div class="admin-form-section-header">
                        <div class="admin-form-section-icon"><i class="fas fa-envelope"></i></div>
                        <div class="admin-form-section-title">Contact Information</div>
                    </div>
                    <div class="admin-form-section-body">
                        <div class="form-grid">
                            <div class="form-group"><label class="form-label">Contact Email</label><input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email']->value ?? '' }}"></div>
                            <div class="form-group"><label class="form-label">Contact Phone</label><input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone']->value ?? '' }}"></div>
                        </div>
                        <div class="form-group"><label class="form-label">Physical Address</label><textarea name="contact_address" class="form-control" rows="2">{{ $settings['contact_address']->value ?? '' }}</textarea></div>
                    </div>
                </div>
                <div style="margin-top:16px;"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button></div>
            </div>

            {{-- Social Tab --}}
            <div id="tab-social" class="settings-tab" style="display:none;">
                <div class="admin-form-section">
                    <div class="admin-form-section-header">
                        <div class="admin-form-section-icon"><i class="fas fa-share-alt"></i></div>
                        <div class="admin-form-section-title">Social Media Links</div>
                    </div>
                    <div class="admin-form-section-body">
                        <div class="form-grid">
                            <div class="form-group"><label class="form-label"><i class="fab fa-facebook" style="color:#1877F2;margin-right:6px;"></i>Facebook</label><input type="url" name="facebook_url" class="form-control" value="{{ $settings['facebook_url']->value ?? '' }}" placeholder="https://facebook.com/..."></div>
                            <div class="form-group"><label class="form-label"><i class="fab fa-twitter" style="color:#1DA1F2;margin-right:6px;"></i>Twitter</label><input type="url" name="twitter_url" class="form-control" value="{{ $settings['twitter_url']->value ?? '' }}" placeholder="https://twitter.com/..."></div>
                            <div class="form-group"><label class="form-label"><i class="fab fa-linkedin" style="color:#0A66C2;margin-right:6px;"></i>LinkedIn</label><input type="url" name="linkedin_url" class="form-control" value="{{ $settings['linkedin_url']->value ?? '' }}" placeholder="https://linkedin.com/..."></div>
                            <div class="form-group"><label class="form-label"><i class="fab fa-youtube" style="color:#FF0000;margin-right:6px;"></i>YouTube</label><input type="url" name="youtube_url" class="form-control" value="{{ $settings['youtube_url']->value ?? '' }}" placeholder="https://youtube.com/..."></div>
                        </div>
                    </div>
                </div>
                <div style="margin-top:16px;"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button></div>
            </div>

            {{-- Branding Tab --}}
            <div id="tab-branding" class="settings-tab" style="display:none;">
                <div class="admin-form-section">
                    <div class="admin-form-section-header">
                        <div class="admin-form-section-icon"><i class="fas fa-palette"></i></div>
                        <div class="admin-form-section-title">Logo & Branding</div>
                    </div>
                    <div class="admin-form-section-body">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Site Logo</label>
                                @if($settings['site_logo']->value ?? null)
                                    <img src="{{ asset('storage/'.($settings['site_logo']->value)) }}" alt="Logo" style="height:60px;margin-bottom:10px;border:1px solid var(--border);border-radius:6px;padding:8px;">
                                @endif
                                <div class="image-upload-area" onclick="this.querySelector('input').click()">
                                    <input type="file" name="site_logo" accept="image/*" style="display:none;">
                                    <div class="image-upload-icon"><i class="fas fa-building"></i></div>
                                    <div class="image-upload-text">Upload site logo</div>
                                    <div class="image-upload-sub">PNG, SVG — Max 2MB</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Favicon</label>
                                <div class="image-upload-area" onclick="this.querySelector('input').click()">
                                    <input type="file" name="site_favicon" accept="image/*,image/x-icon" style="display:none;">
                                    <div class="image-upload-icon"><i class="fas fa-globe"></i></div>
                                    <div class="image-upload-text">Upload favicon</div>
                                    <div class="image-upload-sub">ICO, PNG — 32×32px</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top:16px;"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button></div>
            </div>
        </div>
    </div>
</form>
@endsection
