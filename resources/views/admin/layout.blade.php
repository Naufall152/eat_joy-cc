<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - EatJoy</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --primary:#4CAF50;
            --secondary:#2196F3;
            --accent:#FF9800;
            --bg:#f5f7ff;
            --card:#ffffff;
            --dark:#2D3436;
            --muted:#6c757d;
            --shadow:0 12px 30px rgba(0,0,0,0.08);
        }
        *{ font-family:'Poppins',sans-serif; }
        body{ background:var(--bg); }
        .admin-shell{ display:flex; min-height:100vh; }
        .sidebar{
            width:280px; background:linear-gradient(180deg, var(--primary), var(--secondary));
            color:white; padding:22px; position:sticky; top:0; height:100vh;
        }
        .brand{
            font-weight:800; font-size:1.4rem; display:flex; gap:10px; align-items:center;
            margin-bottom:18px;
        }
        .nav-pill{
            display:flex; align-items:center; gap:12px;
            padding:12px 14px; border-radius:14px;
            color:rgba(255,255,255,.9); text-decoration:none;
            margin-bottom:10px; transition:.2s;
            background:rgba(255,255,255,.08);
        }
        .nav-pill:hover{ background:rgba(255,255,255,.16); color:white; transform:translateY(-1px); }
        .nav-pill.active{ background:rgba(255,255,255,.22); color:white; box-shadow:0 10px 18px rgba(0,0,0,.12); }
        .main{ flex:1; padding:28px; }
        .topbar{
            background:white; border-radius:18px; box-shadow:var(--shadow);
            padding:16px 18px; display:flex; justify-content:space-between; align-items:center;
            margin-bottom:18px;
        }
        .cardx{
            background:var(--card); border-radius:18px; box-shadow:var(--shadow);
            padding:18px;
        }
        .badge-soft{
            background:rgba(76,175,80,.12); color:var(--primary);
            padding:6px 10px; border-radius:999px; font-weight:600; font-size:.85rem;
        }
        .btn-eatjoy{
            background:linear-gradient(135deg, var(--primary), var(--secondary));
            color:white; border:none; border-radius:12px; padding:10px 14px;
            font-weight:600;
        }
        .btn-eatjoy:hover{ opacity:.95; }
        .table thead th{ background:#f3f6ff; border-bottom:none; }
        .table td, .table th{ vertical-align:middle; }
    </style>
</head>
<body>
<div class="admin-shell">
    <aside class="sidebar">
        <div class="brand">
            <i class="bi bi-egg-fried"></i> EatJoy Admin
        </div>
        <div class="mb-3 small opacity-75">
            Login sebagai: <strong>{{ Auth::user()->username }}</strong><br>
            <span class="badge-soft">Role: ADMIN</span>
        </div>

        @php
            $r = request()->route() ? request()->route()->getName() : '';
        @endphp

        <a class="nav-pill {{ str_starts_with($r,'admin.dashboard') ? 'active':'' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a class="nav-pill {{ str_starts_with($r,'admin.users') ? 'active':'' }}" href="{{ route('admin.users.index') }}">
            <i class="bi bi-people"></i> Users & Subscription
        </a>
        <a class="nav-pill {{ str_starts_with($r,'admin.recipes') ? 'active':'' }}" href="{{ route('admin.recipes.index') }}">
            <i class="bi bi-journal-text"></i> Resep Menu
        </a>
        <a class="nav-pill {{ str_starts_with($r,'admin.blogs') ? 'active':'' }}" href="{{ route('admin.blogs.index') }}">
            <i class="bi bi-newspaper"></i> Artikel / Blog
        </a>
        <a class="nav-pill {{ str_starts_with($r,'admin.planner') ? 'active':'' }}" href="{{ route('admin.planner.index') }}">
            <i class="bi bi-calendar2-week"></i> Daily Planner
        </a>

        <a class="nav-pill {{ str_starts_with($r,'admin.visitors') ? 'active':'' }}" href="{{ route('admin.visitors.index') }}">
            <i class="bi bi-graph-up"></i> Grafik Pengunjung
        </a>

        <hr class="border-white opacity-25 my-3">

        <a class="nav-pill" href="{{ route('dashboard.user') }}">
            <i class="bi bi-house"></i> Kembali ke User
        </a>

        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button class="nav-pill w-100 border-0 text-start" style="background:rgba(255,255,255,.08);">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <div class="fw-bold">@yield('page_title','Admin Panel')</div>
                <div class="text-muted small">@yield('page_subtitle','Kelola konten EatJoy untuk semua dashboard user.')</div>
            </div>
            <div class="d-flex gap-2 align-items-center">
                @if(session('success'))
                    <span class="badge-soft">{{ session('success') }}</span>
                @endif
            </div>
        </div>

        @yield('content')
    </main>
</div>

<a href="{{ route('dashboard.user') }}" class="btn btn-sm btn-light">Preview User Free</a>
<a href="{{ route('dashboard.premium.starter') }}" class="btn btn-sm btn-light">Preview Starter</a>
<a href="{{ route('dashboard.premium.starter.plus') }}" class="btn btn-sm btn-light">Preview Starter+</a>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
