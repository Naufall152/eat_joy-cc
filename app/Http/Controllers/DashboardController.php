<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function guestView()
    {
        $recipes = Recipe::where('type', 'regular')
            ->where('visibility', 'public')
            ->limit(8)
            ->get(['id', 'title', 'description', 'calories', 'image']);

        // ✅ bikin URL gambar biar view gampang
        $recipes->transform(function ($r) {
            $r->image_url = $this->resolveRecipeImageUrl($r);
            return $r;
        });

        $features = [
            [
                'icon' => 'bi-egg-fried',
                'title' => '25+ Menu Diet',
                'description' => 'Resep sehat dengan kalori terkontrol'
            ],
            [
                'icon' => 'bi-calculator',
                'title' => 'Kalkulator BMI',
                'description' => 'Hitung indeks massa tubuh Anda'
            ],
            [
                'icon' => 'bi-calendar-check',
                'title' => 'Daily Planner',
                'description' => 'Rencanakan diet harian Anda'
            ],
            [
                'icon' => 'bi-robot',
                'title' => 'AI Assistant',
                'description' => 'Konsultasi dengan AI tentang diet'
            ]
        ];

        $testimonials = [
            [
                'name' => 'Rina S.',
                'text' => 'Turun 10kg dalam 3 bulan dengan menu dari EJOY!',
                'avatar' => '👩'
            ],
            [
                'name' => 'Budi W.',
                'text' => 'Daily planner-nya sangat membantu menjaga konsistensi diet.',
                'avatar' => '👨'
            ],
            [
                'name' => 'Sari D.',
                'text' => 'Resepnya mudah diikuti dan bahan-bahannya terjangkau.',
                'avatar' => '👩‍⚕️'
            ]
        ];

        return view('dashboard.guest', compact('recipes', 'features', 'testimonials'));
    }

    public function userDashboard(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // AUTO REDIRECT berdasarkan subscription plan
        if ($user->subscription_plan === 'starter') {
            return app(PremiumController::class)->premiumStarterDashboard();
        } elseif ($user->subscription_plan === 'starter_plus') {
            return app(PremiumController::class)->premiumStarterPlusDashboard();
        }

        // Jika free user, tampilkan dashboard biasa
        // ✅ kita ambil jadi boolean dan dikirim ke blade sebagai $firstLogin
        $firstLogin = (bool) $request->session()->pull('first_login', false);

        // ✅ paginate biar links() jalan
        $recipes = Recipe::where('type', 'regular')
            ->where('visibility', 'public')
            ->latest()
            ->paginate(6);

        // ✅ bikin URL gambar untuk tiap item paginator
        $recipes->getCollection()->transform(function ($r) {
            $r->image_url = $this->resolveRecipeImageUrl($r);
            return $r;
        });

        $blogs = $this->getBlogArticles();

        // ✅ kirim firstLogin (bukan cuma session)
        return view('dashboard.user', compact('recipes', 'blogs', 'user', 'firstLogin'));
    }

    /**
     * ✅ Resolver URL gambar recipe
     * - kalau kamu punya kolom image_url (full URL) -> pakai itu
     * - kalau pakai storage (kolom image) -> asset('storage/...')
     * - fallback placeholder
     */
    private function resolveRecipeImageUrl($recipe): string
    {
        // Kalau ada kolom image_url di tabel, pakai prioritas paling atas
        if (isset($recipe->image_url) && !empty($recipe->image_url)) {
            return $recipe->image_url;
        }

        // Kolom image = path storage (contoh: recipes/xxx.jpg)
        if (!empty($recipe->image)) {
            return asset('storage/' . $recipe->image);
        }

        // Placeholder taruh di public/images/placeholder-food.jpg
        return asset('images/placeholder-food.jpg');
    }

    private function getBlogArticles()
    {
        return [
            ['title' => '10 Tips Diet Sehat untuk Pemula', 'url' => '#', 'date' => '2024-01-15'],
            ['title' => 'Mengatur Pola Makan yang Benar', 'url' => '#', 'date' => '2024-01-10'],
            ['title' => 'Olahraga Terbaik untuk Menurunkan Berat Badan', 'url' => '#', 'date' => '2024-01-05'],
            ['title' => 'Menu Diet 1500 Kalori Per Hari', 'url' => '#', 'date' => '2024-01-01'],
            ['title' => 'Hindari 5 Makanan Ini Saat Diet', 'url' => '#', 'date' => '2023-12-28'],
        ];
    }
}
