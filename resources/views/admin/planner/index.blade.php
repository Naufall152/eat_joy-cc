@extends('admin.layout')
@php $pageTitle='Daily Planner'; @endphp

@section('content')
<div class="card card-soft">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="fw-bold"><i class="bi bi-calendar-check"></i> Daily Planner Template</div>
        <a href="{{ route('admin.planner.create') }}" class="btn btn-primary-soft">
            <i class="bi bi-plus-circle"></i> Tambah Template
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                <tr>
                    <th>Plan</th>
                    <th>Day</th>
                    <th>Title</th>
                    <th style="width:200px;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td class="fw-semibold">{{ $item->plan }}</td>
                        <td>{{ $item->day_number }}</td>
                        <td class="text-muted">{{ $item->title ?? '-' }}</td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.daily-planner.edit',$item) }}">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form class="d-inline" method="POST" action="{{ route('admin.daily-planner.destroy',$item) }}"
                                  onsubmit="return confirm('Hapus template ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada template.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
