<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    private function planView(string $viewBase): string
    {
    $plan = Auth::user()->subscription_plan ?? '';

    // ✅ normalisasi biar starter-plus / starter plus / StarterPlus tetap kebaca
    $plan = strtolower($plan);
    $plan = str_replace([' ', '-'], '_', $plan);

    return match ($plan) {
        'starter_plus' => "recipes.starter_plus.$viewBase", // UNGU
        'starter'      => "recipes.starter.$viewBase",      // HIJAU
        default        => "recipes.$viewBase",              // fallback kalau free/others
        };
    }

    private function ensureOwner(Recipe $recipe): void
    {
        if ((int)$recipe->user_id !== (int)Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke menu ini.');
        }
    }

    public function myRecipes(Request $request)
    {
        $q = Recipe::query()->where('user_id', Auth::id());

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $q->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        // Filter visibility
        if ($request->filled('visibility') && in_array($request->visibility, ['public', 'private'], true)) {
            $q->where('visibility', $request->visibility);
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') $q->orderBy('created_at', 'asc');
        else $q->orderBy('created_at', 'desc');

        $userRecipes = $q->paginate(8)->withQueryString();

        return view($this->planView('my-recipes'), compact('userRecipes'));
    }

    public function create()
    {
        return view($this->planView('create'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required','string','max:120'],
            'calories' => ['required','numeric','min:0','max:9999'],
            'description' => ['required','string','max:2000'],
            'visibility' => ['required','in:public,private'],
            'type' => ['nullable','in:regular,premium'],
            'ingredients' => ['nullable','array'],
            'ingredients.*' => ['nullable','string','max:255'],
            'instructions' => ['nullable','array'],
            'instructions.*' => ['nullable','string','max:255'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],
        ]);

        // rapihin array (hapus yang kosong)
        $ingredients = collect($request->input('ingredients', []))
            ->map(fn($v) => trim((string)$v))
            ->filter(fn($v) => $v !== '')
            ->values()
            ->all();

        $instructions = collect($request->input('instructions', []))
            ->map(fn($v) => trim((string)$v))
            ->filter(fn($v) => $v !== '')
            ->values()
            ->all();

        $imagePath = null;
        if ($request->hasFile('image')) {
            // ✅ simpan ke storage/app/public/recipes
            $imagePath = $request->file('image')->store('recipes', 'public'); // contoh: recipes/xxx.jpg
        }

        $recipe = Recipe::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'calories' => $validated['calories'],
            'description' => $validated['description'],
            'visibility' => $validated['visibility'],
            'type' => $validated['type'] ?? 'regular',
            'ingredients' => $ingredients,
            'instructions' => $instructions,
            'image' => $imagePath, // simpan path TANPA "storage/"
        ]);

        return redirect()
            ->route('recipes.show', $recipe->id)
            ->with('success', '✅ Menu berhasil dibuat!');
    }

    public function show(Recipe $recipe)
    {
        $this->ensureOwner($recipe);
        return view($this->planView('show'), compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        $this->ensureOwner($recipe);
        return view($this->planView('edit'), compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $this->ensureOwner($recipe);

        $validated = $request->validate([
            'title' => ['required','string','max:120'],
            'calories' => ['required','numeric','min:0','max:9999'],
            'description' => ['required','string','max:2000'],
            'visibility' => ['required','in:public,private'],
            'type' => ['nullable','in:regular,premium'],
            'ingredients' => ['nullable','array'],
            'ingredients.*' => ['nullable','string','max:255'],
            'instructions' => ['nullable','array'],
            'instructions.*' => ['nullable','string','max:255'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],
        ]);

        $ingredients = collect($request->input('ingredients', []))
            ->map(fn($v) => trim((string)$v))
            ->filter(fn($v) => $v !== '')
            ->values()
            ->all();

        $instructions = collect($request->input('instructions', []))
            ->map(fn($v) => trim((string)$v))
            ->filter(fn($v) => $v !== '')
            ->values()
            ->all();

        // replace image kalau upload baru
        if ($request->hasFile('image')) {
            if (!empty($recipe->image)) {
                Storage::disk('public')->delete($recipe->image);
            }
            $recipe->image = $request->file('image')->store('recipes', 'public');
        }

        $recipe->title = $validated['title'];
        $recipe->calories = $validated['calories'];
        $recipe->description = $validated['description'];
        $recipe->visibility = $validated['visibility'];
        $recipe->type = $validated['type'] ?? $recipe->type ?? 'regular';
        $recipe->ingredients = $ingredients;
        $recipe->instructions = $instructions;
        $recipe->save();

        return redirect()
            ->route('recipes.show', $recipe->id)
            ->with('success', '✅ Menu berhasil diperbarui!');
    }

    public function destroy(Recipe $recipe)
    {
        $this->ensureOwner($recipe);

        if (!empty($recipe->image)) {
            Storage::disk('public')->delete($recipe->image);
        }

        $recipe->delete();

        return redirect()
            ->route('recipes.my')
            ->with('success', '🗑️ Menu berhasil dihapus!');
    }
}
