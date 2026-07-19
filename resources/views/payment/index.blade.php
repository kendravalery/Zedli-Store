@extends('layout.layout_customer')

@section('ContentCustomer')
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-500"><a href="{{ route('checkout.back') }}"><- </a>Metode Pembayaran</h1>
            <div class="bg-white p-4 rounded-xl mb-2">

                {{-- juga pake alpine --}}
            </div>

            <h1 class="text-2xl font-bold text-gray-500">Detail Pesanan </h1>
            @foreach ($cartItems as $item)
                <div class="rounded overflow-hidden border border-gray-200 mb-4">
                    <div class="bg-gray-200 p-2">
                        Estimasi tiba: 5 - 7 Juli 2026 // masih dummy
                    </div>
                    <div class="bg-white p-3 ">

                        <div class="flex gap-2">
                            <img src="{{ asset('storage/' . $item->product->images->first()->path) }}" width="80"
                                class="rounded-lg">
                            <div class="flex flex-col">
                                <p class="font-medium mb-2">{{ $item->product->name }}</p>

                                <p>{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
        <div class="lg:w-[400px]  w-full ">
            <div class="lg:sticky lg:top-38">

                <div class="p-3 bg-white rounded">
                    <span class="text-2xl font-bold text-gray-500 "> Voucer dan promo <P></P></span>
                    <select name="" id="" class="p-2 border my-3 rounded hover:shadow-lg border-gray-300">
                        <option value=""></option>
                        <option value="">lagi belum ada fitur diskon nih</option>
                    </select>
                    <span></span>
                </div>
                {{-- TOTAL --}}
                <div class="mt-5 bg-white p-4 rounded shadow ">

                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Sub Total</span>
                            <span>RP...</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Ongkir</span>
                            <span>RP...</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Diskon</span>
                            <span>RP...</span>
                        </div>
                        <div class="mb-4">

                            <span>Total : </span>

                            <span id="total-price" class="font-bold text-xl text-blue-600">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>


                    {{-- DESKTOP Pay --}}

                    <form action="#" method="POST">
                        @csrf
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded cursor-pointer w-full">
                            Pay
                        </button>
                    </form>
                </div>

            </div>
            {{-- MOBILE STICKY Pay --}}
            <div
                class="fixed bottom-0 left-0 right-0 bg-white border-t shadow p-4 flex justify-between items-center md:hidden z-50 ">

                <span id="total-price-mobile" class="font-bold text-blue-600 hover:bg-blue-700"></span>
                <form action="#" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded cursor-pointer">
                        Pay
                    </button>
                </form>
            </div>

        </div>

    </div>
@endsection
