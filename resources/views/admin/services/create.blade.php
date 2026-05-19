{{-- FILE: resources/views/admin/services/create.blade.php --}}
@extends('layouts.admin')
@section('title','Add Service')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Add Service</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Add New Service</h1>
    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">
        <div class="admin-form-section">
            <div class="admin-form-section-header">
                <div class="admin-form-section-icon"><i class="fas fa-concierge-bell"></i></div>
                <div class="admin-form-section-title">Service Details</div>
            </div>
            <div class="admin-form-section-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Service Title <span class="required">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" placeholder="e.g. Mentorship & Coaching" required>
                        @error('title')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control"
                            value="{{ old('category') }}" placeholder="e.g. Advisory, Infrastructure">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Font Awesome Icon</label>
                        <input type="text" name="icon" class="form-control"
                            value="{{ old('icon','fa-star') }}" placeholder="e.g. fa-users, fa-coins">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control"
                            value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Description <span class="required">*</span></label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                        rows="3" required>{{ old('description') }}</textarea>
                    @error('description')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Features (one per line)</label>
                    <textarea name="features" class="form-control" rows="5"
                        placeholder="Expert mentor matching&#10;Weekly coaching sessions&#10;Peer learning circles">{{ old('features') }}</textarea>
                    <div class="form-hint">Enter one feature per line</div>
                </div>
                <div class="form-group">
                    <label class="form-toggle">
                        <div class="toggle-switch">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active',true) ? 'checked':'' }}>
                            <span class="toggle-slider"></span>
                        </div>
                        <span class="toggle-label">Show on website</span>
                    </label>
                </div>
            </div>
        </div>

        <div>
            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-image"></i></div>
                    <div class="admin-form-section-title">Image</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="image-upload-area" onclick="this.querySelector('input').click()">
                        <input type="file" name="image" accept="image/*" style="display:none;" data-preview="svcImgPreview">
                        <div class="image-upload-icon"><i class="fas fa-image"></i></div>
                        <div class="image-upload-text">Upload service image</div>
                        <div class="image-upload-sub">JPG, PNG — Max 3MB</div>
                        <img id="svcImgPreview" class="image-preview" style="display:none;">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">
                <i class="fas fa-save"></i> Add Service
            </button>
        </div>
    </div>
</form>
@endsection
