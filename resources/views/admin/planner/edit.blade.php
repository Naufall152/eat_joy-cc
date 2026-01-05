@extends('admin.layout')
@php ( $pageTitle='Edit Daily Planner' ); @endphp

@section('content')
<div class="card card-soft">
    <div class="card-header fw-bold"><i class="bi bi-pencil"></i> Edit Daily Planner</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.daily-planner.update', $item) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Plan</label>
                    <select class="form-select" name="plan" required>
                        <option value="starter" {{ old('plan',$item->plan)==='starter'?'selected':'' }}>starter</option>
                        <option value="starter_plus" {{ old('plan',$item->plan)==='starter_plus'?'selected':'' }}>starter_plus</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Day Number</label>
                    <input type="number" class="form-control" name="day_number" required value="{{ old('day_number',$item->day_number) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Title</label>
                    <input class="form-control" name="title" value="{{ old('title',$item->title) }}">
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label fw-semibold">Breakfast</label>
                <textarea class="form-control" rows="2" name="breakfast">{{ old('breakfast',$item->breakfast) }}</textarea>
            </div>
            <div class="mt-3">
                <label class="form-label fw-semibold">Lunch</label>
                <textarea class="form-control" rows="2" name="lunch">{{ old('lunch',$item->lunch) }}</textarea>
            </div>
            <div class="mt-3">
                <label class="form-label fw-semibold">Dinner</label>
                <textarea class="form-control" rows="2" name="dinner">{{ old('dinner',$item->dinner) }}</textarea>
            </div>
            <div class="mt-3">
                <label class="form-label fw-semibold">Snack</label>
                <textarea class="form-control" rows="2" name="snack">{{ old('snack',$item->snack) }}</textarea>
            </div>
            <div class="mt-3">
                <label class="form-label fw-semibold">Notes</label>
                <textarea class="form-control" rows="2" name="notes">{{ old('notes',$item->notes) }}</textarea>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('admin.daily-planner.index') }}" class="btn btn-outline-soft">
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
