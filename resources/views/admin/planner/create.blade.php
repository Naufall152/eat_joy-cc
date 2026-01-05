@extends('admin.layout')
@php $pageTitle='Tambah Template Planner'; @endphp

@section('content')
<div class="card card-soft">
  <div class="card-header fw-bold">
    <i class="bi bi-plus-circle"></i> Tambah Template
  </div>

  <div class="card-body">
    <form method="POST" action="{{ route('admin.planner.store') }}">
      @csrf

      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label fw-bold">Plan</label>
          <select name="plan" class="form-select" required>
            <option value="starter">Starter</option>
            <option value="starter_plus">StarterPlus</option>
          </select>
        </div>

        <div class="col-md-4">
          <label class="form-label fw-bold">Day (1-31)</label>
          <input type="number" name="day_number" class="form-control" min="1" max="31" required>
        </div>

        <div class="col-md-4">
          <label class="form-label fw-bold">Title</label>
          <input name="title" class="form-control" required>
        </div>
      </div>

      <div class="mt-3">
        <label class="form-label fw-bold">Tasks (1 baris = 1 task)</label>
        <textarea name="tasks" rows="6" class="form-control" placeholder="Contoh:&#10;07:00 - Sarapan&#10;12:00 - Makan siang" required></textarea>
      </div>

      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary">
          <i class="bi bi-check2"></i> Simpan
        </button>
        <a href="{{ route('admin.planner.index') }}" class="btn btn-light">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
