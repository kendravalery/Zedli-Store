<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::latest()->get();

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.banners.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['image' => 'required|image', 'product_id' => 'nullable|exists:products,id', 'link' => 'nullable|url']);

        if (!$request->product_id && !$request->link) {
            return back()
                ->withErrors([
                    'product_id' => 'Tidak boleh isi produk dan link bersamaan',
                ])
                ->withInput();
        }
        $path = $request->file('image')->store('banners', 'public');
        Banner::create([
            'image' => $path,
            'product_id' => $request->product_id,
            'link' => $request->link,
            'is_active' => true,
        ]);
        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil ditambah');
    }

    public function edit(string $id)
    {
        $banner = Banner::findorfail($id);
        $products = Product::all();

        return view('admin.banners.edit', compact('banner', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image',
            'product_id' => 'nullable|exists:products,id',
            'link' => 'nullable|url',
        ]);

        if ($request->product_id && $request->link) {
            return back()
                ->withErrors(['product_id' => 'Tidak boleh isi produk dan link bersamaan'])
                ->withInput();
        }
        // update gambar
        if ($request->hasFile('image')) {
            // hapus foto yang lama
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $path = $request->file('image')->store('banners', 'public');

            $banner->image = $path;
        }
        $banner->product_id = $request->product_id;

        $banner->link = $request->link;

        $banner->save();

        return back()->with('success', 'Banner berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findorFail($id);

        if ($banner->image && storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();

        return redirect()->back()->with('success', 'Baner sudah dihapus');
    }

    public function toggle($id)
    {
        $banner = Banner::findOrFail($id);

        $banner->is_active = !$banner->is_active;

        $banner->save();

        return back();
    }
}
