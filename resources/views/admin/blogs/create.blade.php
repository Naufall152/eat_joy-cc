@extends('admin.layout')

@section('title','Tambah Blog')
@section('page_title','Tambah Blog')
@section('page_subtitle','Buat artikel baru.')

@section('content')
<div class="cardx">
    <form method="POST" action="{{ route('admin.blogs.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Judul</label>
            <input name="title" class="form-control" value="{{ old('title') }}" required>
            @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Excerpt (opsional)</label>
            <input name="excerpt" class="form-control" value="{{ old('excerpt') }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Image URL (opsional)</label>
            <input name="image_url" class="form-control" value="{{ old('image_url') }}">
        </div>

        <div class="row g-2">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tanggal Publish (opsional)</label>
                <input type="date" name="published_at" class="form-control" value="{{ old('published_at') }}">
            </div>
            <div class="col-md-6 mb-3 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_published" id="pub" value="1" checked>
                    <label class="form-check-label fw-semibold" for="pub">Published</label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Content</label>
            <textarea name="content" class="form-control" rows="10" required>{{ old('content') }}</textarea>
            @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-eatjoy">Simpan</button>
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-light">Batal</a>
    </form>
</div>
@endsection
