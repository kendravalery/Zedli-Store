@extends('layout.layout_customer')

@section('ContentCustomer')
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-500">Detail Pengiriman</h1>
            <div class="bg-white p-4 rounded-xl mb-2">
                <div class="border-b flex gap-10 p-2 border-gray-300">
                    <div>
                        <p class="text-lg font-bold text-gray-600">
                           kontol:
                        </p>
                    </div>
                    <div>
                        <button class="text-yellow-400 hover:text-yellow-500 cursor-pointer">
                            Ganti alamat
                        </button>
                        {{-- pake alpine --}}
                    </div>
                </div>
                {{-- tambahin pengulangan dan ada sebagai alamat utama --}}
                <div class="flex gap-50 mb-2 p-2 border-b border-gray-300">

                    <div class="text-sm">
                        {{ optional(\Laravolt\Indonesia\Models\Village::where('code', $defaultAddress->village)->first())->name }}
                        {{ optional(\Laravolt\Indonesia\Models\District::where('code', $defaultAddress->district)->first())->name }},
                        {{ optional(\Laravolt\Indonesia\Models\City::where('code', $defaultAddress->city)->first())->name }},
                        {{ optional(\Laravolt\Indonesia\Models\Province::where('code', $defaultAddress->province)->first())->name }},
                        {{ $defaultAddress->postal_code }}
                        {{ $defaultAddress->phone }}
                    </div>

                </div>

                <label class="block text-sm  mb-2">Notes : </label>
                <textarea name="Note" class="w-full border border-gray-300 rounded p-2" rows="3"
                    placeholder="Catatan Untuk Penjual (opsional)"></textarea>
                {{-- <input type="textarea" class="border border-gray-300 p-2 "> --}}
                <p class="text-lg font-bold text-gray-600">
                    Metode pengiriman :</p>
                <div class="p-2 border border-gray-300">Pilih Metode</div>
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

                            <p>{{ $item->product->name }}</p>

                            <p>{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>

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


                    {{-- DESKTOP CHECKOUT --}}

                    <form action="{{ route('payment.index') }}" method="POST">
                        @csrf
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded cursor-pointer w-full">
                            continue to payment
                        </button>
                    </form>
                </div>

            </div>
            {{-- MOBILE STICKY CHECKOUT --}}
            <div
                class="fixed bottom-0 left-0 right-0 bg-white border-t shadow p-4 flex justify-between items-center md:hidden z-50 ">

                <span id="total-price-mobile" class="font-bold text-blue-600 hover:bg-blue-700"></span>
                <form action="{{ route('payment.index') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded cursor-pointer">
                        continue to payment
                    </button>
                </form>
            </div>

        </div>

    </div>
@endsection
