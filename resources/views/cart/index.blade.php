@extends('layout.layout_customer')

@section('ContentCustomer')
    <div class="flex flex-col lg:flex-row gap-6">
        <div class="flex-1">

            <div class="max-w-5xl mx-auto px-3 md:px-0 pb-24">
                {{--
                <h1 class="text-2xl font-bold mb-2"><a href="javascript:history.back()">
                        <- </a> Keranjang Saya </h1> --}}
                <h1 class="text-2xl font-bold mb-2"><a href="{{ route('home') }}"><- </a> Keranjang Saya </h1>

                @if ($cartItems->isEmpty())
                    <div class="bg-white p-6 rounded-xl shadow text-gray-500">
                        Keranjang masih kosong
                    </div>
                @else
                    {{-- SELECT ALL --}}
                    <label class="flex items-center gap-2 mb-4 cursor-pointer">

                        <input type="checkbox" id="select-all" class="w-5 h-5 accent-blue-500 cursor-pointer">

                        <span class="text-sm">Pilih semua</span>

                    </label>

                    {{-- LIST --}}
                    <div class="space-y-3">

                        @foreach ($cartItems as $item)
                            <div class="bg-white p-4 rounded-xl shadow">

                                <div class="flex gap-3">

                                    {{-- CHECKBOX --}}
                                    <label class="cursor-pointer mt-1">

                                        <input type="checkbox"
                                            class="item-checkbox w-5 h-5 accent-blue-500 cursor-pointer mt-1"
                                            data-id="{{ $item->id }}"
                                            data-price="{{ $item->product->price * $item->quantity }}"
                                            {{ $item->is_selected ? 'checked' : '' }}>
                                    </label>

                                    {{-- CONTENT --}}
                                    <div class="flex-1">

                                        {{-- TOP --}}
                                        <div class="flex gap-3">

                                            <img src="{{ asset('storage/' . $item->product->images->first()->path) }}"
                                                class="w-16 h-16 object-cover rounded">

                                            <div class="flex-1">
                                                <h2 class="font-semibold text-sm md:text-base">
                                                    {{ $item->product->name }}
                                                </h2>

                                                <p class="text-xs text-gray-500">
                                                    {{ $item->quantity }} x Rp
                                                    {{ number_format($item->product->price, 0, ',', '.') }}
                                                </p>
                                            </div>

                                        </div>

                                        {{-- BOTTOM --}}
                                        <div
                                            class="mt-3 flex flex-col md:flex-row md:justify-between md:items-center gap-2">

                                            <span class="font-bold text-blue-600">
                                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                            </span>

                                            <div class="flex items-center gap-2">

                                                <form action="{{ route('cart.decrease', $item->product_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="px-2 py-1 bg-gray-200 rounded">-</button>
                                                </form>

                                                <form action="{{ route('cart.increase', $item->product_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="px-2 py-1 bg-gray-200 rounded">+</button>
                                                </form>

                                                <form action="{{ route('cart.remove', $item->product_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-red-500 text-sm">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="lg:w-[400px]  w-full ">
            <div class="lg:sticky lg:top-43">

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
                    <div class="mb-4">

                        <span class="font-bold">Total</span>

                        <span id="total-price" class="font-bold text-xl text-blue-600">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>


                    {{-- DESKTOP CHECKOUT --}}

                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounde cursor-pointer w-full">
                            Checkout
                        </button>
                    </form>
                </div>

            </div>
            {{-- MOBILE STICKY CHECKOUT --}}
            <div
                class="fixed bottom-0 left-0 right-0 bg-white border-t shadow p-4 flex justify-between items-center md:hidden z-50 ">

                <span id="total-price-mobile" class="font-bold text-blue-600 hover:bg-blue-700"></span>
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded cursor-pointer">
                        Checkout
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const selectAll = document.getElementById('select-all');

        function updateTotal() {
            let total = 0;

            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseInt(cb.dataset.price);
                }
            });

            const formatted = 'Rp ' + total.toLocaleString('id-ID');

            document.getElementById('total-price').innerText = formatted;

            const mobile = document.getElementById('total-price-mobile');
            if (mobile) mobile.innerText = formatted;
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {

                fetch(`/cart/select/${this.dataset.id}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        is_selected: this.checked
                    })
                }).then(() => {
                    updateTotal();
                    updateSelectAll();
                });

            });
        });

        if (selectAll) {
            selectAll.addEventListener('change', function() {

                fetch('/cart/select-all', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        is_selected: this.checked
                    })
                }).then(() => {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    updateTotal();
                });

            });
        }

        function updateSelectAll() {
            if (!selectAll) return;

            const allChecked = [...checkboxes].every(cb => cb.checked);
            selectAll.checked = allChecked;
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateTotal();
            updateSelectAll();
        });
    </script>

@endsection
