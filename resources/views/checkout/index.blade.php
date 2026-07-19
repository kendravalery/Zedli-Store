@extends('layout.layout_customer')

@section('ContentCustomer')
    <div x-data="{
        openModal: false,
        openShippingMethod: false,
        shippingName: '{{ session('shipping') == 'jne_reg'
            ? 'JNE Reguler'
            : (session('shipping') == 'jnt'
                ? 'J&T Express'
                : (session('shipping') == 'sicepat'
                    ? 'SiCepat REG'
                    : 'Pilih Metode')) }}'
    }" class="">
        <form action="{{ route('payment.index') }}" method="POST">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="flex-1">
                    @csrf
                    <h1 class="text-2xl font-bold text-gray-500"><a href="{{ route('cart.index') }}"><- </a> Detail Pengiriman
                    </h1>
                    <div class="bg-white p-4 rounded-xl mb-2">
                        <div class="flex items-center justify-between border-b  gap-10 p-2 border-gray-300">
                            <div>
                                <h2 class="text-lg font-bold text-gray-600">
                                    alamat pengiriman :
                                </h2>
                            </div>
                            <div>
                                <button type="button" @click="openModal = true"
                                    class="text-blue-600 hover:text-blue-700 cursor-pointer ">
                                    Ganti alamat
                                </button>
                                {{-- pake alpine --}}
                            </div>
                        </div>
                        {{-- tambahin pengulangan dan ada sebagai alamat utama --}}
                        <div class="flex justify-between mb-2 p-2 border-b border-gray-300">

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
                        <textarea name="note" class="w-full border border-gray-300 rounded p-2" rows="3"
                            placeholder="Catatan Untuk Penjual (opsional)">{{ session('checkout_note') }}</textarea>

                        {{-- <input type="textarea" class="border border-gray-300 p-2 "> --}}
                        <p class="text-lg font-bold text-gray-600">
                            Metode pengiriman :</p>
                        <div @click="openShippingMethod = true"
                            class="p-2 border rounded-xl cursor-pointer border-gray-300">
                            <p x-text="shippingName" class="hover:translate-x-2 transition duration-300">Pilih Metode</p>
                        </div>
                    </div>

                    <h1 class="text-2xl font-bold text-gray-500">Detail Pesanan </h1>
                    @foreach ($cartItems as $item)
                        <div class="rounded overflow-hidden border border-gray-200 mb-4">
                            <div class="bg-gray-200 p-2">
                                Estimasi tiba: 5 - 7 Juli 2026 // masih dummy
                            </div>
                            <div class="bg-white p-3 ">

                                <div class="flex gap-2">
                                    <img src="{{ asset('storage/' . $item->product->images->first()->path) }}"
                                        width="80" class="rounded-lg">
                                    <div class="flex flex-col">
                                        <p class="font-medium mb-3">{{ $item->product->name }}</p>

                                        <p>{{ $item->quantity }} x Rp
                                            {{ number_format($item->product->price, 0, ',', '.') }}
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
                            <select name="" id=""
                                class="p-2 border my-3 rounded hover:shadow-lg border-gray-300">
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


                            {{-- DESKTOP Continue to payment --}}
                            <button
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded cursor-pointer w-full">
                                Continue to payment
                            </button>

                        </div>
                    </div>
                    {{-- MOBILE STICKY Continue to payment --}}
                    <div
                        class="fixed bottom-0 left-0 right-0 bg-white border-t shadow p-4 flex justify-between items-center md:hidden z-50 ">

                        <span id="total-price-mobile" class="font-bold text-blue-600 hover:bg-blue-700"></span>


                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded cursor-pointer">
                            Continue to payment
                        </button>

                    </div>
                </div>
            </div>
            {{-- MODAL METODE PENGIRIMAN --}}
            <div x-show="openShippingMethod" class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 ">
                <div @click.away="openShippingMethod  = false" x-transition
                    class="bg-white w-full max-w-md p-6 rounded-xl shadow-lg">
                    <div class="border-b">
                        <div class=" border-gray-300 mb-2">Pengiriman </div>
                    </div>
                    <div class="p-3 space-y-3">
                        <label
                            class="flex justify-between items-center border rounded-xl p-3 cursor-pointer hover:blue-500">
                            <div>
                                <p class="font-semibold">JNE Reguler</p>
                                <p class="text-sm text-gray-500">Estimasi 2-4 hari</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold">Rp 18.000</p>
                                <input type="radio" name="shipping" id="jne_reg" value="jne_reg"
                                    {{ session('shipping') == 'jne_reg' ? 'checked' : '' }}
                                    @change="shippingName='JNE Reguler'; openShippingMethod=false">
                            </div>
                        </label>
                        <label
                            class="flex justify-between items-center border rounded-xl p-3 cursor-pointer hover:blue-500">
                            <div>
                                <p class="font-semibold">J&T Express</p>
                                <p class="text-sm text-gray-500">Estimasi 2-4 hari</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold">Rp 20.000</p>
                                <input type="radio" name="shipping" id="jnt" value="jnt"
                                    {{ session('shipping') == 'jnt' ? 'checked' : '' }}
                                    @change="shippingName='J&T Express'; openShippingMethod=false">
                            </div>
                        </label>
                        <label
                            class="flex justify-between items-center border rounded-xl p-3 cursor-pointer hover:blue-500">
                            <div>
                                <p class="font-semibold">SiCepat REG</p>
                                <p class="text-sm text-gray-500">Estimasi 2-5 hari</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold">Rp 19.000</p>
                                <input type="radio" name="shipping" id="sicepat" value="sicepat"
                                    {{ session('shipping') == 'sicepat' ? 'checked' : '' }}
                                    @change="shippingName='SiCepat REG'; openShippingMethod=false">
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </form>
        {{-- MODAL --}}
        <div x-show="openModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 ">
            <div @click.away="openModal = false" x-transition class="bg-white w-full max-w-md p-6 rounded-xl shadow-lg">
                <div class="space-y-2">
                    @foreach ($addresses as $address)
                        <div class="flex justify-between items-start border border-gray-300 p-3">
                            <div class="font-semibold">
                                {{ $address->receiver_name }}
                                <span class="text-gray-500">({{ $address->phone }})</span>
                                @if ($address->is_default)
                                    <span class="ml-3 text-xs bg-green-100 text-green-700 p-1 rounded">
                                        Alamat utama
                                    </span>
                                @endif
                            </div>
                            <div class="text-gray-700 mt2">
                                {{ $address->full_address }}
                            </div>
                            <div class="text-sm text-gray-500 mt-1">
                                {{ optional(\Laravolt\Indonesia\Models\Village::where('code', $address->village)->first())->name }}
                                {{ optional(\Laravolt\Indonesia\Models\District::where('code', $address->district)->first())->name }},
                                {{ optional(\Laravolt\Indonesia\Models\City::where('code', $address->city)->first())->name }},
                                {{ optional(\Laravolt\Indonesia\Models\Province::where('code', $address->province)->first())->name }},
                            </div>
                            <div class="flex flex-col gap-2 items-end">
                                @if (!$address->is_default)
                                    <form action="{{ route('customer.Address.default', $address->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-blue-600 hover:blue-700  font-medium cursor-pointer">Jadikan
                                            alamat utama</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
