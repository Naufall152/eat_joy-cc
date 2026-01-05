<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Menu - Premium Starter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root{
            --primary:#2E7D32;
            --secondary:#4CAF50;
            --bg:#f6fbf6;
            --card: 0 10px 25px rgba(46,125,50,.12);
        }
        body{ background: linear-gradient(135deg,#ffffff, var(--bg)); min-height:100vh; }
        .topbar{
            background: #fff; border-bottom: 3px solid rgba(76,175,80,.25);
        }
        .badge-plan{
            background: linear-gradient(135deg,var(--secondary),var(--primary));
            color:#fff; border-radius:999px; padding:6px 14px; font-weight:700; font-size:.85rem;
        }
        .cardx{
            border:none; border-radius:18px; box-shadow: var(--card);
            overflow:hidden; background:#fff;
        }
        .thumb{
            width:100%; height:170px; object-fit:cover; background:#e9f5ea;
        }
        .btn-primary{
            background: linear-gradient(135deg,var(--secondary),var(--primary));
            border:none;
        }
        .btn-outline-primary{
            border-color: var(--primary);
            color: var(--primary);
        }
        .btn-outline-primary:hover{
            background: var(--primary);
            border-color: var(--primary);
        }
    </style>
</head>
<body>

<nav class="navbar topbar py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-egg-fried fs-4" style="color:var(--primary)"></i>
            <strong>EatJoy</strong>
            <span class="badge-plan"><i class="bi bi-star-fill me-1"></i>STARTER</span>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('dashboard.premium.starter') }}" class="btn btn-light border">
                <i class="bi bi-house me-1"></i>Dashboard
            </a>
            <a href="{{ route('recipes.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Buat Menu
            </a>
        </div>
    </div>
</nav>

<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
        </div>
    @endif

    <div class="cardx mb-4">
        <div class="p-4">
            <h3 class="fw-bold mb-1"><i class="bi bi-journal-text me-2" style="color:var(--primary)"></i>My Menu</h3>
            <div class="text-muted">Kelola semua menu diet yang kamu buat (CRUD).</div>

            <form class="row g-2 mt-3" method="GET" action="{{ route('recipes.my') }}">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search"
                           value="{{ request('search') }}" placeholder="Cari menu...">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="visibility">
                        <option value="">Semua</option>
                        <option value="public"  {{ request('visibility')==='public' ? 'selected':'' }}>Public</option>
                        <option value="private" {{ request('visibility')==='private' ? 'selected':'' }}>Private</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <select class="form-select" name="sort">
                        <option value="newest" {{ request('sort','newest')==='newest' ? 'selected':'' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort')==='oldest' ? 'selected':'' }}>Terlama</option>
                    </select>
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($userRecipes->count() === 0)
        <div class="cardx">
            <div class="p-5 text-center">
                <i class="bi bi-journal-x display-6 text-muted"></i>
                <h5 class="mt-3 mb-1 fw-bold">Belum ada menu yang dibuat</h5>
                <p class="text-muted mb-3">Mulai buat menu diet pertamamu sekarang.</p>
                <a href="{{ route('recipes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Buat Menu
                </a>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach($userRecipes as $recipe)
                <div class="col-md-6 col-lg-4">
                    <div class="cardx h-100">
                        <img class="thumb" src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}">

                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div class="fw-bold">{{ $recipe->title }}</div>
                                <span class="badge {{ $recipe->visibility==='public' ? 'bg-success':'bg-secondary' }}">
                                    {{ strtoupper($recipe->visibility) }}
                                </span>
                            </div>
                            <div class="text-muted small mt-1">
                                <i class="bi bi-fire me-1"></i>{{ $recipe->calories }} kcal
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                                <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-light border btn-sm w-100">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>
                            </div>

                            <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" class="mt-2"
                                  onsubmit="return confirm('Yakin hapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm w-100">
                                    <i class="bi bi-trash me-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $userRecipes->links() }}
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
