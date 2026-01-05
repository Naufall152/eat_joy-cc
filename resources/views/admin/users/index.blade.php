@extends('admin.layout')

@section('title','Users')
@section('page_title','Users & Subscription')
@section('page_subtitle','Admin bisa melihat daftar user + status subscription mereka.')

@section('content')
<div class="cardx">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="fw-bold">Daftar User</div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Nickname</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Plan</th>
                    <th>Join</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td class="fw-semibold">{{ $u->nickname ?? '-' }}</td>
                    <td>{{ $u->username }}</td>
                    <td class="text-muted small">{{ $u->email }}</td>
                    <td><span class="badge text-bg-light">{{ strtoupper($u->role) }}</span></td>
                    <td><span class="badge text-bg-light">{{ strtoupper($u->subscription_plan ?? 'FREE') }}</span></td>
                    <td class="text-muted small">{{ $u->created_at->format('d M Y') }}</td>
                    <td>
                        <a class="btn btn-sm btn-eatjoy" href="{{ route('admin.users.show', $u->id) }}">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
</div>
@endsection
