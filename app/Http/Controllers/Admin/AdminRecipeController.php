<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class AdminRecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::latest()->paginate(12);
        return view('admin.recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('admin.recipes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'calories' => 'required|numeric|min:0|max:5000',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'is_premium' => 'nullable|boolean', // kalau kamu punya field premium
        ]);

        $data['is_premium'] = $request->boolean('is_premium');

        Recipe::create($data);
        return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil dibuat.');
    }

    public function edit(Recipe $recipe)
    {
        return view('admin.recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'calories' => 'required|numeric|min:0|max:5000',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'is_premium' => 'nullable|boolean',
        ]);

        $data['is_premium'] = $request->boolean('is_premium');

        $recipe->update($data);
        return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil diupdate.');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return back()->with('success', 'Resep berhasil dihapus.');
    }
}
