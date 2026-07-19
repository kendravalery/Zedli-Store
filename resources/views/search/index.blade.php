@extends('layout.layout_customer')
@section('ContentCustomer')
    <div class="flex flex-col lg:flex-row min-h-screen">
        <aside class="w-full lg:w-72 lg:min-h-screen p-4 bg-white border-r border-slate-200 shadow-lg">
            <p class="font-semibold text-gray-600 text-xl mb-2">Filter</p>
            <div class="flex items-center justify-between mb-2">
                <p>Availability</p>
                <a class="text-blue-600 text-sm" href="{{ route('search', ['q' => request('q')]) }}">Reset</a>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <button class="border border-slate-300 p-1 text-sm text-center rounded-full  hover:bg-blue-50 transition">All
                    items</button>
                <button
                    class="border border-slate-300 p-1 text-sm text-center rounded-full  hover:bg-blue-50 transition">ready
                    stock</button>
                <button class="border border-slate-300 p-1 text-sm text-center rounded-full  hover:bg-blue-50 transition">pre
                    order</button>
            </div>

        </aside>
        <main class="flex flex-col flex-1 p-4 overflow-y-auto">
            <div>
                <p class="text-gray-600 mb-2 font-semibold ">Search Result for "{{ $q }}"</p>

            </div>
            @if ($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-3">

                    @foreach ($products as $product)
                        <a href="{{ route('products.show', $product->id) }}">
                            <article
                                class="bg-white rounded-xl p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-200 group relative">

                                <!-- Image -->
                                <div class="h-40 sm:h-50 rounded-md bg-gray-100 overflow-hidden">
                                    @if ($product->images->count() > 0)
                                        <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt=""
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-200">
                                    @else
                                        <img src="{{ asset('gambar/default.jpg') }}" class="w-full h-full object-cover">
                                    @endif
                                </div>

                                <!-- Title -->
                                <h4 class="mt-3 font-medium line-clamp-2 text-sm sm:text-base">
                                    {{ $product->name }}
                                </h4>

                                <!-- Rating -->
                                <div class="flex items-center gap-1 text-xs text-yellow-500 mt-1">
                                    ⭐ 4.8 <span class="text-gray-400">({{ $product->stock }})</span>
                                </div>

                                <div class="flex items-center justify-between gap-3">

                                    <!-- Price -->
                                    <span class="block mt-4 font-semibold text-blue-600 text-base sm:text-xl ">
                                        {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs mt-4">
                                        Terjual {{ $product->sold ?? 0 }}x
                                    </span>
                                </div>
                            </article>
                        </a>
                    @endforeach

                </div>
                {{ $products->links('vendor.pagination.pagination-numbersOnly') }}
            @else
                <div class="flex flex-col items-center justify-center min-h-[30vh] text-center ">
                    <h1 class="text-red-500 text-xl font-semibold">Barang Tidak ditemukan...</h1>
                    <p class="text-gray-400 text-sm mt-2">

                    </p>
                </div>
            @endif
        </main>
    </div>
@endsection
