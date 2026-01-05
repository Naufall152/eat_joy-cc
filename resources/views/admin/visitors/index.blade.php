@extends('admin.layout')
@php $pageTitle='Traffic Pengunjung'; @endphp

@section('content')
<div class="card card-soft">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="fw-bold"><i class="bi bi-graph-up"></i> Traffic Pengunjung (14 Hari Terakhir)</div>
        <div class="text-muted small">
            Total: <span class="fw-semibold">{{ collect($values ?? [])->sum() }}</span>
        </div>
    </div>

    <div class="card-body">
        {{-- CHART --}}
        <div class="mb-4">
            <canvas id="visitorsChart" height="90"></canvas>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @forelse(($labels ?? []) as $i => $d)
                    <tr>
                        <td class="fw-semibold">{{ \Carbon\Carbon::parse($d)->format('d M Y') }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $values[$i] ?? 0 }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center text-muted py-4">
                            Belum ada data visitor logs.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-muted small mt-3">
            *Data diambil dari tabel <code>visitor_logs</code> dan dikelompokkan per hari.
        </div>
    </div>
</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($labels ?? []);
    const values = @json($values ?? []);

    const ctx = document.getElementById('visitorsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels.map(d => {
                const dt = new Date(d);
                return dt.toLocaleDateString('id-ID', { day:'2-digit', month:'short' });
            }),
            datasets: [{
                label: 'Kunjungan',
                data: values,
                tension: 0.35,
                fill: true,
                borderWidth: 2,
                pointRadius: 3,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: { enabled: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
