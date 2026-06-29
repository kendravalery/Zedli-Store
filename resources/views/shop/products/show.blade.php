@extends('layout.layout_customer')

@section('ContentCustomer')
    <main class="max-w-7xl mx-auto p-6 bg-white">
        <div class="mb-5 hover:-translate-1 transition">
            <a href="{{ route('home') }}"><- kembali</a>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <div class="h-80 bg-gray-100 rounded-lg overflow-hidden">
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
                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="border   px-6 py-2 rounded hover:bg-gray-100">
                            +  wishlist
                        </button>
                    </form>
                     <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class=" border  px-6 py-2 rounded hover:bg-gray-100">
                            + Keranjang
                        </button>
                    </form>



                    <button class="border px-6 py-2 rounded  bg-blue-600 hover:bg-blue-700 text-white">
                        Beli Sekarang
                    </button>

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
