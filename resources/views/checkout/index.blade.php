@extends('layout.layout_customer')

@section('ContentCustomer')
    <div>
        <div class="">
            alamat pengiriman
            {{-- /tambahin pengulangan dan ada sebagai alamat utama --}}
            <label class="block text-sm font-medium mb-2">Notes</label>
            <input type="text" class="border p-2 ">
        </div>

        <h1>Detail pengiriman</h1>
        @foreach ($cartItems as $item)
            <div class="bg-white p-2 rounded mt-2">

                <div>
                    <img src="{{ asset('storage/' . $item->product->images->first()->path) }}" width="80">

                    <p>{{ $item->product->name }}</p>

                    <p>{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>

                </div>

                <h2>Total : Rp {{ number_format($total, 0, ',', '.') }}</h2>
            </div>
        @endforeach
    </div>
@endsection
