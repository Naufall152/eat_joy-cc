@extends('admin.layout')

@section('title','Detail User')
@section('page_title','Detail User')
@section('page_subtitle','Lihat data akun & subscription user.')

@section('content')
<div class="cardx">
    <div class="row g-3">
        <div class="col-md-6">
            <div class="text-muted small">Nickname</div>
            <div class="fw-bold">{{ $user->nickname ?? '-' }}</div>
        </div>
        <div class="col-md-6">
            <div class="text-muted small">Username</div>
            <div class="fw-bold">{{ $user->username }}</div>
        </div>
        <div class="col-md-6">
            <div class="text-muted small">Email</div>
            <div class="fw-bold">{{ $user->email }}</div>
        </div>
        <div class="col-md-3">
            <div class="text-muted small">Role</div>
            <div class="fw-bold">{{ strtoupper($user->role) }}</div>
        </div>
        <div class="col-md-3">
            <div class="text-muted small">Subscription</div>
            <div class="fw-bold">{{ strtoupper($user->subscription_plan ?? 'free') }}</div>
        </div>
        <div class="col-12">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
