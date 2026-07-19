<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        session([
            'checkout_note' => $request->note,
            'shipping' => $request->shipping,
        ]);
        $user = Auth::user();
        $defaultAddress = Address::where('user_id', $user->id)->where('is_default', true)->first();
        $cartItems = CartItem::with('product.images')->where('user_id', $user->id)->where('is_selected', true)->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        return view('payment.index', compact('cartItems', 'total', 'defaultAddress'));
    }
    public function pay()
    {
        //nanti
    }
}
