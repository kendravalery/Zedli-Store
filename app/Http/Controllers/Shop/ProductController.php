<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with('images', 'category')->findOrFail($id);

        $isWishlist = false;
        if (Auth::check()) {
            $isWishlist = Wishlist::where('product_id', $product->id)->exists();
        }
        return view('products.show', compact('product','isWishlist'));
    }
}
