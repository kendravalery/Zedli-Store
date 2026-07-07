<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $user = Auth::user();
        $defaultAddress = Address::where('user_id', $user->id)->where('is_default', true)->first();
        $addresses = Address::where('user_id', $user->id)->get();
        $cartItems = CartItem::with('product.images')->where('user_id', $user->id)->where('is_selected', true)->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'pilih minimal satu produk');
        }
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        return view('checkout.index', compact('cartItems', 'total', 'addresses', 'defaultAddress'));
    }
    public function continueToPayment()
    {
        return redirect()->route('payment.index');
    }
}
