<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add($id)
    {
        $product = Product::with('images')->findOrFail($id);

        $user = Auth::user();

        $cart = CartItem::firstOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $id,
            ],
            [
                'quantity' => 0,
            ],
        );

        $cart->increment('quantity');

        return back()->with('success', 'Masuk Keranjang');
    }

    public function index()
    {
        $user = auth::user();

        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();
        $total = 0;
        foreach ($cartItems as $item) {
            if ($item->is_selected) {
                $total += $item->product->price * $item->quantity;
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function remove($id)
    {
        $user = auth::user();

        CartItem::where('user_id', $user->id)->where('product_id', $id)->delete();

        return back()->with('success', 'Item dihapus');
    }
    public function increase($id)
    {
        $user = auth::user();
        $cart = CartItem::where('user_id', $user->id)->where('product_id', $id)->firstOrFail();
        $cart->increment('quantity');
        return back();
    }
    public function decrease($id)
    {
        $user = auth::user();

        $cart = CartItem::where('user_id', $user->id)->where('product_id', $id)->firstOrFail();

        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        } else {
            $cart->delete(); // kalao 1 terus dikurangin = hapus
        }
        return back();
    }
    public function selectAll(Request $request)
    {
        $user = auth::user();
        CartItem::where('user_id', $user->id)->update(['is_selected' => $request->is_selected]);

        return response()->json(['success' => true]);
    }
    public function toggleSelect(Request $request, $id)
    {
        $user = auth::user();
        $item = CartItem::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $item->is_selected = $request->is_selected;
        $item->save();

        return response()->json(['success' => true]);
    }
   
}
