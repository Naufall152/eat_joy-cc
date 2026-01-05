@extends('admin.layout')
@php $pageTitle='Edit Resep'; @endphp

@section('content')
<div class="card card-soft">
    <div class="card-header fw-bold"><i class="bi bi-pencil"></i> Edit Resep</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.recipes.update', $recipe) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Judul</label>
                <input class="form-control" name="title" required value="{{ old('title',$recipe->title) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Kalori</label>
                <input type="number" class="form-control" name="calories" required value="{{ old('calories',$recipe->calories) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea class="form-control" rows="3" name="description" required>{{ old('description',$recipe->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Ingredients</label>
                <textarea class="form-control" rows="4" name="ingredients" required>{{ old('ingredients',$recipe->ingredients) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Instructions</label>
                <textarea class="form-control" rows="5" name="instructions" required>{{ old('instructions',$recipe->instructions) }}</textarea>
            </div>

            <hr>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_premium" value="1"
                               {{ old('is_premium', $recipe->is_premium ?? false) ? 'checked':'' }}>
                        <label class="form-check-label fw-semibold">Resep Premium?</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Premium Plan</label>
                    <select class="form-select" name="premium_plan">
                        <option value="">-</option>
                        <option value="starter" {{ old('premium_plan',$recipe->premium_plan ?? '')==='starter'?'selected':'' }}>starter</option>
                        <option value="starter_plus" {{ old('premium_plan',$recipe->premium_plan ?? '')==='starter_plus'?'selected':'' }}>starter_plus</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('admin.recipes.index') }}" class="btn btn-outline-soft">
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
