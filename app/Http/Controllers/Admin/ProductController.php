<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->q, fn ($q, $v) => $q->where(fn ($w) => $w->where('name', 'like', "%$v%")->orWhere('code', 'like', "%$v%")))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.produk.index', compact('products'));
    }

    public function create()
    {
        return view('admin.produk.form', ['product' => new Product, 'categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        Product::create($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk ditambahkan.');
    }

    public function edit(Product $produk)
    {
        return view('admin.produk.form', ['product' => $produk, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(Request $request, Product $produk)
    {
        $data = $this->validated($request, $produk->id);
        if ($request->hasFile('image')) {
            if ($produk->image) Storage::disk('public')->delete($produk->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $produk->update($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk diperbarui.');
    }

    public function destroy(Product $produk)
    {
        if (OrderItem::where('product_id', $produk->id)->exists()) {
            return back()->with('error', 'Produk sudah pernah terjual. Nonaktifkan saja, jangan dihapus.');
        }
        if ($produk->image) Storage::disk('public')->delete($produk->image);
        $produk->delete();

        return back()->with('success', 'Produk dihapus.');
    }

    private function validated(Request $request, $id = null): array
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'code'        => 'required|string|max:50|unique:products,code,' . $id,
            'name'        => 'required|string|max:150',
            'description' => 'nullable|string',
            'cost_price'  => 'required|integer|min:0',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        unset($data['image']);

        return $data;
    }
}