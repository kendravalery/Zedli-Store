<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wishlists = Wishlist::with('product')->where('user_id', $user->id)->with('product.images')->get();
        return view('wishlist.index', compact('wishlists'));
    }
    public function wishlistAdd($id)
    {
        Wishlist::firstOrCreate(['user_id' => auth::id(), 'product_id' => $id]);
        return back();
    }
    public function wishlistDelete($id)
    {
        Wishlist::where('user_id', Auth::id())->where('product_id', $id)->delete();
        return back();
    }
}
