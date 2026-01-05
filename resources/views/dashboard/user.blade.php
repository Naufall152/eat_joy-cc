@extends('layouts.app')

@section('content')
@include('components.navbar-user')

@if($firstLogin)
<div class="overlay" id="motivationOverlay"></div>
<div class="motivation-popup" id="motivationPopup">
    <div class="text-center">
        <i class="bi bi-trophy display-1 text-warning"></i>
        <h3 class="mt-3">Selamat Datang, {{ Auth::user()->nickname }}! 🎉</h3>
        <p class="lead">
            Target kamu: Turun
            <strong>{{ number_format(Auth::user()->weight_difference, 1) }} kg</strong>
        </p>
        <p>"Perjalanan 1000 mil dimulai dengan satu langkah. Kamu sudah memulainya!"</p>
        <button class="btn btn-primary mt-3" onclick="closeMotivationPopup()">Mulai Perjalanan Diet</button>
    </div>
</div>
@endif

<div class="container py-4">
    <div class="row">
        {{-- LEFT COLUMN --}}
        <div class="col-lg-8">

            {{-- ====== INI LOOP RECIPES (SUDAH DITAMBAH GAMBAR) ====== --}}
            <div class="row g-3">
                @forelse($recipes as $recipe)
                    @php
                        // ✅ Tentuin URL gambar (sesuaikan dengan kolom kamu)
                        // Prioritas: image_url -> storage image -> placeholder
                        $img = $recipe->image_url
                            ?? (!empty($recipe->image) ? asset('storage/'.$recipe->image) : null)
                            ?? asset('images/placeholder-food.jpg');
                    @endphp

                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            {{-- Thumbnail gambar --}}
                            <div class="ratio ratio-16x9 bg-light">
                                <img src="{{ $img }}"
                                     alt="{{ $recipe->title }}"
                                     style="width:100%;height:100%;object-fit:cover;">
                            </div>

                            <div class="card-body">
                                <div class="fw-semibold mb-1">{{ $recipe->title }}</div>
                                <div class="text-muted small mb-3">
                                    <i class="bi bi-fire"></i> {{ $recipe->calories ?? 0 }} kal
                                </div>

                                <button class="btn btn-primary view-recipe-detail w-100"
                                    data-id="{{ $recipe->id }}"
                                    data-title="{{ $recipe->title }}"
                                    data-calories="{{ $recipe->calories }}"
                                    data-description="{{ $recipe->description }}"
                                    data-image="{{ $img }}"
                                    data-ingredients='@json($recipe->ingredients)'
                                    data-instructions='@json($recipe->instructions)'>
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-muted">Belum ada menu.</div>
                @endforelse
            </div>

            {{-- ✅ Pagination bener (hapus hardcode 1..5 kamu) --}}
            <div class="mt-4">
                @if(method_exists($recipes,'links'))
                    {{ $recipes->links() }}
                @endif
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-4">
            {{-- Daily Personalized Menu (Premium Feature) --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Daily Personalized Menu</h5>
                    <div class="text-center py-4">
                        <i class="bi bi-lock display-4 text-muted"></i>
                        <p class="mt-3">Upgrade ke premium untuk mendapatkan menu personal harian!</p>
                        <a href="{{ route('subscription.plans') }}" class="btn btn-warning">
                            Upgrade Sekarang
                        </a>
                    </div>
                </div>
            </div>

            {{-- Blog Articles --}}
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Artikel Terbaru</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($blogs as $blog)
                        <li class="list-group-item">
                            <a href="{{ $blog['url'] }}" class="text-decoration-none">
                                <h6>{{ $blog['title'] }}</h6>
                                <small class="text-muted">{{ $blog['date'] }}</small>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- BMI Calculator --}}
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Kalkulator BMI</h5>
                    @include('components.bmi-calculator')
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.footer')

{{-- ====== MODAL: TAMBAH GAMBAR + RENDER LIST ====== --}}
<div class="modal fade" id="recipeDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                {{-- ✅ gambar di modal --}}
                <div class="ratio ratio-16x9 bg-light rounded overflow-hidden mb-3">
                    <img id="modalImage" src="" alt="" style="width:100%;height:100%;object-fit:cover;">
                </div>

                <p><i class="bi bi-fire"></i> <span id="modalCalories"></span> Kalori</p>

                <h6>Deskripsi:</h6>
                <p id="modalDescription"></p>

                <h6>Bahan-bahan:</h6>
                <div id="modalIngredients"></div>

                <h6 class="mt-3">Cara Membuat:</h6>
                <div id="modalInstructions"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function closeMotivationPopup() {
        document.getElementById('motivationPopup').style.display = 'none';
        document.getElementById('motivationOverlay').style.display = 'none';
    }

    function renderList(value){
        try { if (typeof value === 'string') value = JSON.parse(value); } catch(e){}
        if (Array.isArray(value)) {
            if (!value.length) return '<div class="text-muted">-</div>';
            return '<ul class="mb-0 ps-3">' + value.map(v => `<li>${escapeHtml(String(v))}</li>`).join('') + '</ul>';
        }
        if (!value) return '<div class="text-muted">-</div>';
        return `<div>${escapeHtml(String(value))}</div>`;
    }

    function escapeHtml(str){
        return str
            .replaceAll('&','&amp;')
            .replaceAll('<','&lt;')
            .replaceAll('>','&gt;')
            .replaceAll('"','&quot;')
            .replaceAll("'","&#039;");
    }

    document.addEventListener('DOMContentLoaded', function() {
        const recipeButtons = document.querySelectorAll('.view-recipe-detail');
        const modalEl = document.getElementById('recipeDetailModal');
        const modal = new bootstrap.Modal(modalEl);

        recipeButtons.forEach(button => {
            button.addEventListener('click', function() {
                modalEl.querySelector('.modal-title').textContent = this.dataset.title || '';
                document.getElementById('modalCalories').textContent = this.dataset.calories || '0';
                document.getElementById('modalDescription').textContent = this.dataset.description || '-';

                // ✅ set gambar modal
                const img = this.dataset.image || '';
                const imgEl = document.getElementById('modalImage');
                imgEl.src = img;
                imgEl.alt = this.dataset.title || '';

                // ✅ render list (biar ga mentah JSON string)
                document.getElementById('modalIngredients').innerHTML = renderList(this.dataset.ingredients);
                document.getElementById('modalInstructions').innerHTML = renderList(this.dataset.instructions);

                modal.show();
            });
        });

        // Auto show motivation popup on first login
        @if($firstLogin)
        setTimeout(() => {
            document.getElementById('motivationPopup').style.display = 'block';
            document.getElementById('motivationOverlay').style.display = 'block';
        }, 700);
        @endif
    });
</script>
@endsection
