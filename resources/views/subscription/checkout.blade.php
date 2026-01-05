<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout - EatJoy</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --primary: #6C63FF;
            --secondary: #4A90E2;
            --accent: #FF6584;
            --dark: #2D3436;
            --light: #F8F9FF;
            --gradient: linear-gradient(135deg, #6C63FF 0%, #4A90E2 100%);
            --card-shadow: 0 20px 40px rgba(108, 99, 255, 0.12);
        }

        * { font-family: 'Poppins', sans-serif; }

        body {
            background: linear-gradient(135deg, #f5f7ff 0%, #f0f2ff 100%);
            min-height: 100vh;
            padding: 40px 0;
        }

        .card {
            border: none;
            border-radius: 18px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .card-header {
            background: var(--gradient);
            color: white;
            padding: 24px;
            border: none;
        }

        .btn-pay {
            background: var(--gradient);
            color: white;
            border: none;
            height: 52px;
            border-radius: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            transition: 0.2s ease;
        }

        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(108, 99, 255, 0.25);
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .meta {
            background: var(--light);
            border-radius: 12px;
            padding: 14px 16px;
            flex: 1;
            min-width: 160px;
        }

        .meta small { color: #777; }
        .meta strong { color: var(--dark); }

        .note {
            font-size: 0.92rem;
            color: #666;
        }

        .badge-plan {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.25);
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 600;
        }
    </style>
</head>

<body>
<div class="container" style="max-width: 820px;">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h3 class="mb-1 fw-bold">Checkout Premium</h3>
                    <div class="opacity-90">Selesaikan pembayaran untuk mengaktifkan paket kamu.</div>
                </div>
                <div class="badge-plan">
                    {{ strtoupper(str_replace('_', ' ', $plan)) }}
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="meta-row mb-4">
                <div class="meta">
                    <small>Paket</small><br>
                    <strong>{{ strtoupper(str_replace('_', ' ', $plan)) }}</strong>
                </div>
                <div class="meta">
                    <small>Total</small><br>
                    <strong>Rp {{ number_format($price, 0, ',', '.') }}</strong>
                </div>
                <div class="meta">
                    <small>Status</small><br>
                    <strong>Menunggu Pembayaran</strong>
                </div>
            </div>

            <button id="pay-button" class="btn-pay">
                <i class="bi bi-credit-card-2-front"></i>
                Bayar Sekarang (Midtrans)
            </button>

            <div class="mt-3 note">
                <i class="bi bi-info-circle"></i>
                Kamu akan diarahkan ke popup pembayaran Midtrans (Sandbox). Pilih metode pembayaran simulasi.
            </div>

            <div class="mt-4">
                <a href="{{ route('subscription.plans') }}" class="text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Kembali ke Paket
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Midtrans Snap --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        window.snap.pay(@json($snapToken), {
            onSuccess: function (result) {
                // pembayaran sukses
                window.location.href = "{{ route('subscription.plans') }}?pay=success";
            },
            onPending: function (result) {
                // pending
                window.location.href = "{{ route('subscription.plans') }}?pay=pending";
            },
            onError: function (result) {
                // gagal
                alert("Pembayaran gagal. Coba lagi ya.");
            },
            onClose: function () {
                // user nutup popup
                console.log("Popup pembayaran ditutup.");
            }
        });
    });
</script>

</body>
</html>
