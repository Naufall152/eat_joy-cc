@extends('admin.layout')
@php $pageTitle='Edit Blog'; @endphp

@section('content')
<div class="card card-soft">
    <div class="card-header fw-bold">
        <i class="bi bi-pencil"></i> Edit Blog
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.blogs.update', $blog) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Judul</label>
                <input class="form-control" name="title" value="{{ old('title', $blog->title) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Thumbnail URL</label>
                <input class="form-control" name="thumbnail_url" value="{{ old('thumbnail_url', $blog->thumbnail_url) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Excerpt</label>
                <textarea class="form-control" rows="2" name="excerpt">{{ old('excerpt', $blog->excerpt) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Konten</label>
                <textarea class="form-control" rows="8" name="content" required>{{ old('content', $blog->content) }}</textarea>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Published At</label>
                    <input type="datetime-local" class="form-control" name="published_at"
                        value="{{ old('published_at', optional($blog->published_at)->format('Y-m-d\TH:i')) }}">
                </div>

                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_published" value="1"
                            {{ old('is_published', $blog->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold">Published</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-soft">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button class="btn btn-primary-soft" type="submit">
                    <i class="bi bi-check-circle"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
