<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;
        $products = Product::search($q)->paginate(12)->withQueryString();
        return view('search.index', compact('products', 'q'));
    }
}
