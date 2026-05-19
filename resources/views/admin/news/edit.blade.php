@extends('layouts.admin')
@section('title', 'Edit Article')
@section('breadcrumb')
    <span class="topbar-breadcrumb-item"><a href="{{ route('admin.news.index') }}">News</a></span>
    <span class="topbar-breadcrumb-sep">/</span>
    <span class="topbar-breadcrumb-item current">Edit</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Article</h1>
        <p class="page-subtitle truncate" style="max-width:500px;">{{ $news->title }}</p>
    </div>
    <div class="page-actions">
        @if($news->is_published)
            <a href="{{ route('news.show', $news->slug) }}" class="btn btn-secondary btn-sm" target="_blank">
                <i class="fas fa-external-link-alt"></i> View Live
            </a>
        @endif
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;">
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
                            value="{{ old('title', $news->title) }}" required>
                        @error('title')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Excerpt</label>
                        <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $news->excerpt) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Content <span class="required">*</span></label>
                        <div class="editor-toolbar">
                            <button type="button" class="editor-btn" data-cmd="bold"><i class="fas fa-bold"></i></button>
                            <button type="button" class="editor-btn" data-cmd="italic"><i class="fas fa-italic"></i></button>
                            <button type="button" class="editor-btn" data-cmd="underline"><i class="fas fa-underline"></i></button>
                            <button type="button" class="editor-btn" data-cmd="formatBlock" data-value="h2">H2</button>
                            <button type="button" class="editor-btn" data-cmd="formatBlock" data-value="h3">H3</button>
                            <button type="button" class="editor-btn" data-cmd="insertUnorderedList"><i class="fas fa-list-ul"></i></button>
                            <button type="button" class="editor-btn" data-cmd="insertOrderedList"><i class="fas fa-list-ol"></i></button>
                            <button type="button" class="editor-btn" data-cmd="removeFormat"><i class="fas fa-eraser"></i></button>
                        </div>
                        <div class="editor-area" contenteditable="true" data-target="content_hidden">{!! old('content', $news->content) !!}</div>
                        <textarea name="content" id="content_hidden" style="display:none;" required>{{ old('content', $news->content) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

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
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                            <span class="toggle-label">Published</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-toggle">
                            <div class="toggle-switch">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                            <span class="toggle-label">Featured</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control" value="{{ old('category', $news->category) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tags</label>
                        <input type="text" name="tags" class="form-control"
                            value="{{ old('tags', is_array($news->tags) ? implode(', ', $news->tags) : $news->tags) }}"
                            placeholder="tag1, tag2" data-tags>
                    </div>
                </div>
            </div>

            <div class="admin-form-section" style="margin-bottom:16px;">
                <div class="admin-form-section-header">
                    <div class="admin-form-section-icon"><i class="fas fa-image"></i></div>
                    <div class="admin-form-section-title">Cover Image</div>
                </div>
                <div class="admin-form-section-body">
                    @if($news->cover_image)
                        <img src="{{ asset('storage/'.$news->cover_image) }}" alt="Current cover" class="image-preview" style="display:block;margin-bottom:12px;">
                        <p style="font-size:0.75rem;color:var(--text-muted);margin-bottom:8px;">Upload new image to replace</p>
                    @endif
                    <div class="image-upload-area" onclick="this.querySelector('input').click()">
                        <input type="file" name="cover_image" accept="image/*" style="display:none;" data-preview="newCoverPreview">
                        <div class="image-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="image-upload-text">Click to change cover image</div>
                        <img id="newCoverPreview" class="image-preview" style="display:none;">
                    </div>
                </div>
            </div>
            </form>
            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary" style="flex:1;"><i class="fas fa-save"></i> Update</button>
                <form method="POST" action="{{ route('admin.news.destroy', $news) }}" onsubmit="return confirm('Delete this article permanently?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection
