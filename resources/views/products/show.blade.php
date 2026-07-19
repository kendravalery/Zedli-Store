@extends('layout.layout_customer')

@section('ContentCustomer')
    <main class="max-w-7xl mx-auto p-6 bg-white">
        <div class="mb-5 hover:-translate-1 transition">
            <a href="{{ route('home') }}"><- kembali</a>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <div class="h-110 bg-gray-100 rounded-lg overflow-hidden">
                    @if ($product->images->count() > 0)
                        <img id="mainImg" src="{{ asset('storage/' . $product->images->first()->path) }}"
                            class="w-full h-full object-contain bg-white">
                    @else
                        <img src="{{ asset('gambar/default.jpg') }}" class="w-full h-full object-contain bg-white">
                    @endif
                </div>

                <div class="flex gap-2 mt-3">
                    @foreach ($product->images as $img)
                        <img src="{{ asset('storage/' . $img->path) }}"
                            onclick="document.getElementById('mainImg').src=this.src"
                            class="w-16 h-16 object-cover rounded cursor-pointer border hover:opacity-80 hover:scale-105 transition">
                    @endforeach
                </div>
            </div>
            <div>
                <h1 class="text-xl font-semibold">
                    {{ $product->name }}
                </h1>

                <p class="text-2xl text-blue-600 font-bold mt-2">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <div class="mt-4 text-gray-600 text-sm">
                    <h1 class="font-bold mb-3">Deskripsi : </h1>
                    <p id="desc" class="line-clamp-3">
                        {{ $product->description ?? 'Belum ada deskripsi' }}
                    </p>
                    <button id="toggleBtn" class="text-blue-600 text-sm mt-2">
                        Lihat selengkapnya
                    </button>
                </div>


                <div class="mt-6 flex gap-3">
                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                        @csrf

                        <button type="submit" class="border px-6 py-2 rounded hover:bg-gray-100 flex gap-2 items-center">

                            <svg class="w-5 h-5 {{ $isWishlist ? 'text-red-500 fill-red-500' : 'text-gray-500 fill-none' }}"
                                viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                <path stroke="currentColor" stroke-width="50"
                                    d="M512 898.56l-9.813-4.693C485.546 884.906 85.333 679.68 85.333 384c0-115.626 53.76-202.666 147.2-239.36C325.546 108.373 435.2 132.266 512 203.52c76.8-71.253 186.88-95.146 279.466-58.88C884.906 181.333 938.666 268.373 938.666 384c0 295.68-400.213 501.333-416.853 509.866z" />
                            </svg>

                            Wishlist
                        </button>
                    </form>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class=" border  px-6 py-2 rounded hover:bg-gray-100">
                            + Keranjang
                        </button>
                    </form>

                    {{-- <button class="border px-6 py-2 rounded  bg-blue-600 hover:bg-blue-700 text-white">
                        Beli Sekarang
                    </button> --}}
                </div>

            </div>
        </div>
    </main>
    <script>
        const desc = document.getElementById('desc');
        const btn = document.getElementById('toggleBtn');

        let expanded = false;

        btn.addEventListener('click', function() {
            expanded = !expanded;

            if (expanded) {
                desc.classList.remove('line-clamp-3');
                btn.innerText = 'Sembunyikan';
            } else {
                desc.classList.add('line-clamp-3');
                btn.innerText = 'Lihat selengkapnya';
            }
        });
    </script>
@endsection
