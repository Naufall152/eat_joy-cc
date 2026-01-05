<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(12);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image_url' => 'nullable|string|max:500',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(6);
        $data['is_published'] = $request->boolean('is_published');

        Blog::create($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog berhasil dibuat.');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image_url' => 'nullable|string|max:500',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog berhasil diupdate.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return back()->with('success', 'Blog berhasil dihapus.');
    }
}
