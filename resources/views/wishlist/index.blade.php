@extends('layout.layout_customer')
@section('ContentCustomer')
    <div class="flex flex-col lg:flex-row gap-5">
        @include('customer.components.account_sidebar')
        <main class="flex-1 bg-white p-5 rounded-xl">
            <div class="mb-8 border-b ">
                <h1 class="font-bold text-2xl mb-4">
                    Wishlist
                </h1>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 ">
                @if ($wishlists->count() > 0)
                    @foreach ($wishlists as $wishlist)
                        <article
                            class=" bg-white rounded shadow-sm hover:shadow-lg p-4 hover:-translate-y-1 transition duration-200 ">
                            <a href="{{ route('products.show', $wishlist->product->id) }}">
                                <div class="h-40 sm:h-48 rounded-sm bg-gray-100 overflow-hidden">
                                    @if ($wishlist->product->images->count())
                                        <img src="{{ asset('storage/' . $wishlist->product->images->first()->path) }}"
                                            class="w-full h-full object-cover hover:scale-105  transition duration-200">
                                    @else
                                        <img src="{{ asset('gambar/default.jpg') }}" alt="">
                                    @endif
                                </div>
                                <h4 class="mt-3 font-medium line-clamp-1">{{ $wishlist->product->name }}</h4>
                                <!-- Rating -->
                                <div class="flex items-center gap-1 text-xs text-yellow-500 mt-1">
                                    ⭐ 4.8 <span class="text-gray-400">({{ $wishlist->product->stock }})</span>
                                    <- DUMMY DULLU!!!! </div>
                                        <div class="flex items-end  gap-2">
                                            <span class="block  font-semibold text-blue-600 text-base sm:text-xl">
                                                Rp{{ number_format($wishlist->product->price, 0, ',', '.') }}
                                            </span>
                                            <p class="text-xs ">
                                                Terjual{{ $wishlist->product->sold ?? 0 }}x
                                            </p>
                                        </div>
                            </a>
                            <div class="flex justify-between ">
                                <form action="{{ route('cart.add', $wishlist->product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class=" border bg-blue-600  px-6 py-2 rounded hover:bg-blue-700 text-white mt-2 cursor-pointer rounded-xl">
                                        + Keranjang
                                    </button>
                                </form>

                                <form action="{{ route('wishlist.delete', $wishlist->product->id) }}" method="POST"
                                    onclick="return confirm('Apakah kamu yakin ingin menghapus {{ $wishlist->product->name }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="cursor-pointer bg-blue-600 hover:bg-blue-700 rounded-full p-3 mt-2 cursor"><img
                                            src="{{ asset('icon/clipart1120803.png') }}" width="13px" height="13px"
                                            alt=""></button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                @else
                    <div class="col-span-full flex items-center justify-center py-20">
                        <p class="font-semibold text-center">Wishlist Masih Kosong</p>
                    </div>
                @endif
            </div>

        </main>
    </div>
@endsection
