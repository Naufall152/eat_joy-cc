@extends('admin.layout')
@php $pageTitle='Resep Menu'; @endphp

@section('content')
<div class="card card-soft">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="fw-bold"><i class="bi bi-egg-fried"></i> Resep Menu</div>
        <a href="{{ route('admin.recipes.create') }}" class="btn btn-primary-soft">
            <i class="bi bi-plus-circle"></i> Tambah Resep
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kalori</th>
                    <th>Premium</th>
                    <th>Plan</th>
                    <th style="width:200px;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($recipes as $recipe)
                    <tr>
                        <td class="fw-semibold">{{ $recipe->title }}</td>
                        <td>{{ $recipe->calories }}</td>
                        <td>
                            @if($recipe->is_premium ?? false)
                                <span class="badge bg-warning text-dark">Premium</span>
                            @else
                                <span class="badge bg-success">Free</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $recipe->premium_plan ?? '-' }}</td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.recipes.edit',$recipe) }}">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form class="d-inline" method="POST" action="{{ route('admin.recipes.destroy',$recipe) }}"
                                  onsubmit="return confirm('Hapus resep ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada resep.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $recipes->links() }}
        </div>
    </div>
</div>
@endsection
