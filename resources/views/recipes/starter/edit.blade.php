<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Premium Starter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root{ --primary:#2E7D32; --secondary:#4CAF50; --bg:#f6fbf6; --shadow:0 12px 30px rgba(46,125,50,.12); }
        body{ background: linear-gradient(135deg,#fff,var(--bg)); min-height:100vh; }
        .wrap{ max-width: 920px; }
        .cardx{ border:none; border-radius:18px; box-shadow:var(--shadow); overflow:hidden; background:#fff; }
        .head{ background: linear-gradient(135deg,var(--secondary),var(--primary)); color:#fff; }
        .btn-primary{ background: linear-gradient(135deg,var(--secondary),var(--primary)); border:none; }
        .thumb{ width:100%; max-height: 260px; object-fit:cover; border-radius:14px; background:#e9f5ea; }
        .mini{ font-size:.9rem; color:#666; }
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
            <a href="{{ route('recipes.show',$recipe->id) }}" class="btn btn-light border"><i class="bi bi-eye me-1"></i>Detail</a>
        </div>
    </div>
</nav>

<div class="container py-5 wrap">
    @if($errors->any())
        <div class="alert alert-danger">
            <div class="fw-bold mb-1">Ada error:</div>
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="cardx">
        <div class="p-4 head">
            <h3 class="fw-bold mb-1"><i class="bi bi-pencil-square me-2"></i>Edit Menu</h3>
            <div class="opacity-75">Perbarui menu diet yang kamu buat.</div>
        </div>

        <div class="p-4">
            <form action="{{ route('recipes.update',$recipe->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Nama Menu</label>
                        <input type="text" class="form-control" name="title"
                               value="{{ old('title',$recipe->title) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Kalori</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="calories"
                                   value="{{ old('calories',$recipe->calories) }}" min="0" max="9999" required>
                            <span class="input-group-text">kcal</span>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="4" required>{{ old('description',$recipe->description) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Visibility</label>
                        <select class="form-select" name="visibility" required>
                            <option value="private" {{ old('visibility',$recipe->visibility)==='private' ? 'selected':'' }}>Private</option>
                            <option value="public"  {{ old('visibility',$recipe->visibility)==='public' ? 'selected':'' }}>Public</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Type</label>
                        <select class="form-select" name="type">
                            <option value="regular" {{ old('type',$recipe->type)==='regular' ? 'selected':'' }}>Regular</option>
                            <option value="premium" {{ old('type',$recipe->type)==='premium' ? 'selected':'' }}>Premium</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Gambar Menu</label>

                        <div class="mb-2">
                            <div class="mini mb-1">Current:</div>
                            <img class="thumb" src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}">
                        </div>

                        <input type="file" class="form-control" name="image" id="imageInput" accept="image/*">
                        <div class="mini mt-1">Upload baru kalau mau ganti.</div>

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
                            @php
                                $ings = old('ingredients', $recipe->ingredients ?? []);
                                if (!is_array($ings)) $ings = [];
                                if (count($ings)===0) $ings = [''];
                            @endphp
                            @foreach($ings as $i)
                                <div class="d-flex gap-2 mb-2">
                                    <input class="form-control" name="ingredients[]" value="{{ $i }}" placeholder="Bahan...">
                                    <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-light border" onclick="addIngredient()">
                            <i class="bi bi-plus me-1"></i>Tambah Bahan
                        </button>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Cara Membuat</label>
                        <div id="instructionsWrap">
                            @php
                                $ins = old('instructions', $recipe->instructions ?? []);
                                if (!is_array($ins)) $ins = [];
                                if (count($ins)===0) $ins = [''];
                            @endphp
                            @foreach($ins as $s)
                                <div class="d-flex gap-2 mb-2">
                                    <input class="form-control" name="instructions[]" value="{{ $s }}" placeholder="Langkah...">
                                    <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-light border" onclick="addInstruction()">
                            <i class="bi bi-plus me-1"></i>Tambah Langkah
                        </button>
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <a href="{{ route('recipes.show',$recipe->id) }}" class="btn btn-light border w-50">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <button class="btn btn-primary w-50">
                            <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
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
            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
        `;
        wrap.appendChild(row);
    }

    function addInstruction(){
        const wrap = document.getElementById('instructionsWrap');
        const row = document.createElement('div');
        row.className = 'd-flex gap-2 mb-2';
        row.innerHTML = `
            <input class="form-control" name="instructions[]" placeholder="Langkah...">
            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
        `;
        wrap.appendChild(row);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
