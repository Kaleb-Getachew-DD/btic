@extends('layouts.admin')
@section('title', 'Create Article')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.news.index') }}">News</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Create Article</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Create Article</h1>
        <p class="page-subtitle">Write and publish a new news article or blog post</p>
    </div>
    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to News
    </a>
</div>

<form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;">

        {{-- Main Content --}}
        <div>
            <div class="admin-form-section">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-heading"></i></div>
                    <div class="admin-form-section-title">Article Content</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="form-group">
                        <label class="form-label">Title <span class="required">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" placeholder="Enter a compelling article title..." required>
                        @error('title')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Excerpt <span style="color:var(--text-muted);font-weight:400;">(Short summary for listings)</span></label>
                        <textarea name="excerpt" class="form-control" rows="2" placeholder="Brief summary shown in article listings...">{{ old('excerpt') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Content <span class="required">*</span></label>
                        <div class="editor-toolbar">
                            <button type="button" class="editor-btn" data-cmd="bold" title="Bold"><i class="fas fa-bold"></i></button>
                            <button type="button" class="editor-btn" data-cmd="italic" title="Italic"><i class="fas fa-italic"></i></button>
                            <button type="button" class="editor-btn" data-cmd="underline" title="Underline"><i class="fas fa-underline"></i></button>
                            <button type="button" class="editor-btn" data-cmd="formatBlock" data-value="h2" title="Heading 2">H2</button>
                            <button type="button" class="editor-btn" data-cmd="formatBlock" data-value="h3" title="Heading 3">H3</button>
                            <button type="button" class="editor-btn" data-cmd="insertUnorderedList" title="Bullet List"><i class="fas fa-list-ul"></i></button>
                            <button type="button" class="editor-btn" data-cmd="insertOrderedList" title="Numbered List"><i class="fas fa-list-ol"></i></button>
                            <button type="button" class="editor-btn" data-cmd="createLink" title="Link"><i class="fas fa-link"></i></button>
                            <button type="button" class="editor-btn" data-cmd="removeFormat" title="Clear Format"><i class="fas fa-eraser"></i></button>
                        </div>
                        <div class="editor-area" contenteditable="true" data-target="content_hidden">{{ old('content') }}</div>
                        <textarea name="content" id="content_hidden" style="display:none;" required>{{ old('content') }}</textarea>
                        @error('content')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-search"></i></div>
                    <div class="admin-form-section-title">SEO Settings</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="SEO title (leave blank to use article title)">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Meta Description</label>
                            <input type="text" name="meta_description" class="form-control" value="{{ old('meta_description') }}" placeholder="Brief SEO description...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-cog"></i></div>
                    <div class="admin-form-section-title">Publish Settings</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="form-group">
                        <label class="form-toggle">
                            <div class="toggle-switch">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                            <span class="toggle-label">Publish Immediately</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-toggle">
                            <div class="toggle-switch">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                            <span class="toggle-label">Mark as Featured</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="e.g. Announcements, Events">
                        <div class="form-hint">Common: Announcements, Success Stories, Events, Partnerships</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tags</label>
                        <input type="text" name="tags" class="form-control" value="{{ old('tags') }}" placeholder="tag1, tag2, tag3" data-tags>
                        <div class="form-hint">Comma-separated tags</div>
                    </div>
                </div>
            </div>

            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-image"></i></div>
                    <div class="admin-form-section-title">Cover Image</div>
                </div>
                <div class="admin-form-section-body">
                    <div class="image-upload-area" onclick="this.querySelector('input').click()">
                        <input type="file" name="cover_image" accept="image/*" style="display:none;" data-preview="coverPreview">
                        <div class="image-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="image-upload-text">Click to upload cover image</div>
                        <div class="image-upload-sub">JPG, PNG, WebP — Max 3MB</div>
                        <img id="coverPreview" class="image-preview" style="display:none;">
                    </div>
                </div>
            </div>

            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary" style="flex:1;">
                    <i class="fas fa-save"></i> Save Article
                </button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
