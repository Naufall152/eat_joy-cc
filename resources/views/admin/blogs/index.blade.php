@extends('admin.layout')

@section('title','Blog')
@section('page_title','Artikel / Blog')
@section('page_subtitle','CRUD artikel yang tampil di dashboard user.')

@section('content')
<div class="cardx">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="fw-bold">List Blog</div>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-eatjoy">
            <i class="bi bi-plus-circle"></i> Tambah Blog
        </a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Publish</th>
                    <th>Status</th>
                    <th>Updated</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $b)
                <tr>
                    <td class="fw-semibold">{{ $b->title }}</td>
                    <td>{{ $b->published_at ? $b->published_at->format('d M Y') : '-' }}</td>
                    <td>
                        <span class="badge text-bg-light">{{ $b->is_published ? 'PUBLISHED' : 'DRAFT' }}</span>
                    </td>
                    <td class="text-muted small">{{ $b->updated_at->format('d M Y') }}</td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.blogs.edit', $b->id) }}">Edit</a>
                        <form action="{{ route('admin.blogs.destroy', $b->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus blog ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $blogs->links() }}
</div>
@endsection
