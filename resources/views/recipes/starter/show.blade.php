<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Menu - Premium Starter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root{ --primary:#2E7D32; --secondary:#4CAF50; --bg:#f6fbf6; --shadow:0 12px 30px rgba(46,125,50,.12); }
        body{ background: linear-gradient(135deg,#fff,var(--bg)); min-height:100vh; }
        .wrap{ max-width: 980px; }
        .cardx{ border:none; border-radius:18px; box-shadow:var(--shadow); overflow:hidden; background:#fff; }
        .hero{ width:100%; max-height: 360px; object-fit:cover; background:#e9f5ea; }
        .btn-primary{ background: linear-gradient(135deg,var(--secondary),var(--primary)); border:none; }
        .mini{ font-size:.95rem; color:#666; }
    </style>
</head>
<body>

<nav class="navbar py-3 bg-white border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-egg-fried fs-4" style="color:var(--primary)"></i>
            <strong>EatJoy</strong>
            <span class="badge text-bg-success">STARTER</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('recipes.my') }}" class="btn btn-light border"><i class="bi bi-journal-text me-1"></i>My Menu</a>
            <a href="{{ route('recipes.edit',$recipe->id) }}" class="btn btn-primary"><i class="bi bi-pencil-square me-1"></i>Edit</a>
        </div>
    </div>
</nav>

<div class="container py-5 wrap">
    @if(session('success'))
        <div class="alert alert-success"><i class="bi bi-check-circle me-1"></i>{{ session('success') }}</div>
    @endif

    <div class="cardx">
        <img class="hero" src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}">

        <div class="p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                <div>
                    <h2 class="fw-bold mb-1">{{ $recipe->title }}</h2>
                    <div class="mini">
                        <span class="badge bg-success me-2">{{ strtoupper($recipe->visibility) }}</span>
                        <span class="badge bg-dark">{{ strtoupper($recipe->type ?? 'regular') }}</span>
                    </div>
                </div>

                <div class="text-end">
                    <div class="fw-bold" style="color:var(--primary)"><i class="bi bi-fire me-1"></i>{{ $recipe->calories }} kcal</div>
                    <div class="mini">Kalori per serving</div>
                </div>
            </div>

            <hr>

            <h5 class="fw-bold mb-2">Deskripsi</h5>
            <p class="mb-4">{{ $recipe->description }}</p>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 border rounded-3">
                        <h6 class="fw-bold mb-2"><i class="bi bi-basket2 me-1" style="color:var(--primary)"></i>Bahan-bahan</h6>
                        @if(is_array($recipe->ingredients) && count($recipe->ingredients))
                            <ul class="mb-0">
                                @foreach($recipe->ingredients as $i) <li>{{ $i }}</li> @endforeach
                            </ul>
                        @else
                            <div class="text-muted">-</div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 border rounded-3">
                        <h6 class="fw-bold mb-2"><i class="bi bi-list-check me-1" style="color:var(--primary)"></i>Cara Membuat</h6>
                        @if(is_array($recipe->instructions) && count($recipe->instructions))
                            <ol class="mb-0">
                                @foreach($recipe->instructions as $s) <li>{{ $s }}</li> @endforeach
                            </ol>
                        @else
                            <div class="text-muted">-</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('recipes.my') }}" class="btn btn-light border w-50">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>

                <form action="{{ route('recipes.destroy',$recipe->id) }}" method="POST" class="w-50"
                      onsubmit="return confirm('Yakin hapus menu ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger w-100">
                        <i class="bi bi-trash me-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
