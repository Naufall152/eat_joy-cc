@extends('admin.layout')

@section('title','Dashboard')
@section('page_title','Dashboard Admin')
@section('page_subtitle','Ringkasan kontrol: user, subscription, konten menu & blog.')

@section('content')
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="cardx">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="text-muted small">Total Users</div>
                    <div class="fs-3 fw-bold">{{ $totalUsers }}</div>
                </div>
                <i class="bi bi-people fs-2 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="cardx">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="text-muted small">User Premium</div>
                    <div class="fs-3 fw-bold">{{ $paidUsers }}</div>
                </div>
                <i class="bi bi-stars fs-2 text-warning"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="cardx">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="text-muted small">Total Resep</div>
                    <div class="fs-3 fw-bold">{{ $totalRecipes }}</div>
                </div>
                <i class="bi bi-journal-text fs-2 text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="cardx">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="text-muted small">Total Blog</div>
                    <div class="fs-3 fw-bold">{{ $totalBlogs }}</div>
                </div>
                <i class="bi bi-newspaper fs-2 text-info"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="cardx">
            <div class="fw-bold mb-2">User Terbaru</div>
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Plan</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $u)
                            <tr>
                                <td class="fw-semibold">{{ $u->username }}</td>
                                <td class="text-muted small">{{ $u->email }}</td>
                                <td>
                                    <span class="badge text-bg-light">
                                        {{ strtoupper($u->subscription_plan ?? 'free') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge text-bg-light">{{ strtoupper($u->role) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-muted">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-eatjoy mt-2">Kelola Users</a>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="cardx">
            <div class="fw-bold mb-2">Order Terbaru (Midtrans)</div>

            @if($recentOrders->count() === 0)
                <div class="text-muted">Belum ada order / tabel order belum dipakai.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Plan</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $o)
                                <tr>
                                    <td class="fw-semibold">{{ $o->order_id }}</td>
                                    <td>{{ $o->plan }}</td>
                                    <td><span class="badge text-bg-light">{{ $o->status }}</span></td>
                                    <td>Rp {{ number_format($o->gross_amount, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="mt-2 small text-muted">
                Ringkas status:
                @foreach($orderSummary as $st => $ct)
                    <span class="badge text-bg-light">{{ $st }}: {{ $ct }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
