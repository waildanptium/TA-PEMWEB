<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.kategori.index', [
            'categories' => Category::withCount('products')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:100|unique:categories,name']);
        Category::create(['name' => $data['name'], 'slug' => Str::slug($data['name'])]);

        return back()->with('success', 'Kategori ditambahkan.');
    }

    public function destroy(Category $kategori)
    {
        if ($kategori->products()->exists()) {
            return back()->with('error', 'Kategori masih memiliki produk.');
        }
        $kategori->delete();

        return back()->with('success', 'Kategori dihapus.');
    }
}