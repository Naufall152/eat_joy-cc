<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Menu - Premium Starter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root{
            --primary:#2E7D32;
            --secondary:#4CAF50;
            --bg:#f6fbf6;
            --shadow: 0 12px 30px rgba(46,125,50,.12);
        }
        body{ background: linear-gradient(135deg,#fff,var(--bg)); min-height:100vh; }
        .wrap{ max-width: 920px; }
        .cardx{ border:none; border-radius:18px; box-shadow: var(--shadow); overflow:hidden; background:#fff; }
        .head{
            background: linear-gradient(135deg,var(--secondary),var(--primary));
            color:#fff;
        }
        .btn-primary{ background: linear-gradient(135deg,var(--secondary),var(--primary)); border:none; }
        .chip{ background: rgba(76,175,80,.12); color: var(--primary); font-weight:700; border-radius:999px; padding:6px 12px; }
        .thumb{ width:100%; max-height: 260px; object-fit:cover; border-radius: 14px; background:#e9f5ea; }
        .mini{ font-size:.9rem; color:#666; }
    </style>
</head>
<body>

<nav class="navbar py-3 bg-white border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-egg-fried fs-4" style="color:var(--primary)"></i>
            <strong>EatJoy</strong>
            <span class="chip">STARTER</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('recipes.my') }}" class="btn btn-light border">
                <i class="bi bi-journal-text me-1"></i>My Menu
            </a>
            <a href="{{ route('dashboard.premium.starter') }}" class="btn btn-light border">
                <i class="bi bi-house me-1"></i>Dashboard
            </a>
        </div>
    </div>
</nav>

<div class="container py-5 wrap">
    @if($errors->any())
        <div class="alert alert-danger">
            <div class="fw-bold mb-1">Ada error:</div>
            <ul class="mb-0">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="cardx">
        <div class="p-4 head">
            <h3 class="fw-bold mb-1"><i class="bi bi-plus-circle me-2"></i>Create New Menu</h3>
            <div class="opacity-75">Buat menu diet versi kamu (premium starter).</div>
        </div>

        <div class="p-4">
            <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Nama Menu</label>
                        <input type="text" class="form-control" name="title"
                               value="{{ old('title') }}" placeholder="Contoh: Salad Ayam Panggang" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Kalori</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="calories"
                                   value="{{ old('calories', 300) }}" min="0" max="9999" required>
                            <span class="input-group-text">kcal</span>
                        </div>
                        <div class="mini mt-1"><i class="bi bi-info-circle me-1"></i>Rekomendasi 300–600 kcal</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="4"
                                  placeholder="Deskripsikan menu..." required>{{ old('description') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Visibility</label>
                        <select class="form-select" name="visibility" required>
                            <option value="private" {{ old('visibility','private')==='private' ? 'selected':'' }}>Private (hanya kamu)</option>
                            <option value="public"  {{ old('visibility')==='public' ? 'selected':'' }}>Public</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Type</label>
                        <select class="form-select" name="type">
                            <option value="regular" {{ old('type','regular')==='regular' ? 'selected':'' }}>Regular</option>
                            <option value="premium" {{ old('type')==='premium' ? 'selected':'' }}>Premium</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Gambar Menu</label>
                        <input type="file" class="form-control" name="image" id="imageInput" accept="image/*">
                        <div class="mini mt-1">JPG/PNG/WEBP maks 5MB</div>

                        <div class="mt-3" id="previewWrap" style="display:none;">
                            <img class="thumb" id="previewImg" src="" alt="preview">
                            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="clearPreview()">
                                <i class="bi bi-trash me-1"></i>Remove
                            </button>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Bahan-bahan</label>
                        <div id="ingredientsWrap">
                            <div class="d-flex gap-2 mb-2">
                                <input class="form-control" name="ingredients[]" placeholder="Contoh: 150g dada ayam">
                                <button type="button" class="btn btn-light border" onclick="addIngredient()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mini">Klik + untuk menambah bahan.</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Cara Membuat</label>
                        <div id="instructionsWrap">
                            <div class="d-flex gap-2 mb-2">
                                <input class="form-control" name="instructions[]" placeholder="Contoh: Panggang ayam 15 menit">
                                <button type="button" class="btn btn-light border" onclick="addInstruction()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mini">Klik + untuk menambah langkah.</div>
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <a href="{{ route('recipes.my') }}" class="btn btn-light border w-50">
                            <i class="bi bi-arrow-left me-1"></i>Batal
                        </a>
                        <button class="btn btn-primary w-50">
                            <i class="bi bi-check-circle me-1"></i>Publish Menu
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const previewWrap = document.getElementById('previewWrap');
    const previewImg  = document.getElementById('previewImg');

    imageInput.addEventListener('change', function(){
        const f = this.files && this.files[0];
        if(!f){ clearPreview(); return; }
        const url = URL.createObjectURL(f);
        previewImg.src = url;
        previewWrap.style.display = 'block';
    });

    function clearPreview(){
        imageInput.value = '';
        previewImg.src = '';
        previewWrap.style.display = 'none';
    }

    function addIngredient(){
        const wrap = document.getElementById('ingredientsWrap');
        const row = document.createElement('div');
        row.className = 'd-flex gap-2 mb-2';
        row.innerHTML = `
            <input class="form-control" name="ingredients[]" placeholder="Bahan...">
            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">
                <i class="bi bi-x"></i>
            </button>
        `;
        wrap.appendChild(row);
    }

    function addInstruction(){
        const wrap = document.getElementById('instructionsWrap');
        const row = document.createElement('div');
        row.className = 'd-flex gap-2 mb-2';
        row.innerHTML = `
            <input class="form-control" name="instructions[]" placeholder="Langkah...">
            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">
                <i class="bi bi-x"></i>
            </button>
        `;
        wrap.appendChild(row);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
