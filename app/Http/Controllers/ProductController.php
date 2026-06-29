<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        //  VALIDASI
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',

            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpg,png,webp,png|max:5000',
        ]);

        $user = $request->user();
        //  SIMPAN PRODUCT
        $product = Product::create([
            'user_id' => $user->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,

            // checkbox
            'is_active' => $request->has('is_active'),
            'is_limited' => $request->has('is_limited'),
            'limited_quantity' => $request->limited_quantity,
        ]);

        //  HANDLE MULTIPLE IMAGE
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'is_primary' => $index === 0, // gambar pertama jadi utama
                    'position' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = Product::with('images', 'category')->findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',

            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpg,png,webp,jpeg|max:5000',
        ]);

        // UPDATE PRODUCT
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,

            'is_active' => $request->has('is_active'),
            'is_limited' => $request->has('is_limited'),
            'limited_quantity' => $request->limited_quantity,
        ]);

        //  HANDLE IMAGE BARU (INI YANG KURANG)
        if ($request->hasFile('images')) {
            // ambil posisi terakhir
            $lastPosition = $product->images()->max('position') ?? 0;

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'is_primary' => false, // jangan override utama
                    'position' => $lastPosition + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $product->images()->delete();

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk dihapus');
    }
    public function deleteImage($id)
    {
        // Ambil data gambar
        $image = ProductImage::findOrFail($id);

        // Hapus file dari storage
        if ($image->path && Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        // Hapus record di database
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus');
    }
}
