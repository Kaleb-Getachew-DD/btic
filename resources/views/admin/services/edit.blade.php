{{-- FILE: resources/views/admin/services/edit.blade.php --}}
@extends('layouts.admin')
@section('title','Edit Service')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Edit</span>
@endsection

@section('content')
<div class="page-header">
    <div><h1 class="page-title">Edit: {{ $service->title }}</h1></div>
    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">
        <div class="admin-form-section">
            <div class="admin-form-section-header">
                <div class="admin-form-section-icon"><i class="fas fa-concierge-bell"></i></div>
                <div class="admin-form-section-title">Service Details</div>
            </div>
            <div class="admin-form-section-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Title <span class="required">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title',$service->title) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control" value="{{ old('category',$service->category) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Icon</label>
                        <input type="text" name="icon" class="form-control" value="{{ old('icon',$service->icon) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$service->sort_order) }}" min="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Description <span class="required">*</span></label>
                    <textarea name="description" class="form-control" rows="3" required>{{ old('description',$service->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Features (one per line)</label>
                    <textarea name="features" class="form-control" rows="5">{{ old('features', is_array($service->features) ? implode("\n",$service->features) : '') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-toggle">
                        <div class="toggle-switch">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active',$service->is_active) ? 'checked':'' }}>
                            <span class="toggle-slider"></span>
                        </div>
                        <span class="toggle-label">Active</span>
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
                    @if($service->image)
                        <img src="{{ asset('storage/'.$service->image) }}" alt="" style="width:100%;max-height:100px;object-fit:cover;border-radius:var(--radius-sm);margin-bottom:10px;">
                    @endif
                    <div class="image-upload-area" onclick="this.querySelector('input').click()">
                        <input type="file" name="image" accept="image/*" style="display:none;" data-preview="editSvcImgPreview">
                        <div class="image-upload-icon"><i class="fas fa-image"></i></div>
                        <div class="image-upload-text">{{ $service->image ? 'Change image' : 'Upload image' }}</div>
                        <img id="editSvcImgPreview" class="image-preview" style="display:none;">
                    </div>
                </div>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary" style="flex:1;"><i class="fas fa-save"></i> Update</button>
                </form>
                <form method="POST" action="{{ route('admin.services.destroy',$service) }}" onsubmit="return confirm('Delete this service?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection
