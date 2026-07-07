<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role->name === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        $products = Product::latest()->withsum('orderItems as sold', 'quantity')->get();
        $categorys = Category::all();
        $banners = Banner::where('is_active', true)->get();
        return view('pages.Home', compact('products', 'categorys', 'banners'));
    }
    public function about(){
        
    }
}
