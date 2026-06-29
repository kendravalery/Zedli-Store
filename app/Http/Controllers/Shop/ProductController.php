<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id){
        $product = Product::with('images' , 'category')->findOrFail($id);

        return view('shop.products.show' , compact('product'));
    }
}
