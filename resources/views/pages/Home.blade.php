@extends('layout.layout_customer')
@section('ContentCustomer')
    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
    {{-- carousel --}}
    <div class="mb-5">

        <div class="relative w-full overflow-hidden rounded-xl">

            {{-- CONTAINER --}}
            <div id="carousel" class="flex gap-4 transition-transform duration-500 ease-in-out items-center">

                @php
                    $cloneCount = min(2, $banners->count());
                @endphp

                {{-- Clone Belakang --}}
                @if ($banners->count() > 0)
                    @for ($i = $banners->count() - $cloneCount; $i < $banners->count(); $i++)
                        @if (isset($banners[$i]))
                            @php
                                $banner = $banners[$i];
                            @endphp

                            <div class="slide-item flex-none w-[75%] sm:w-[65%] md:w-[55%] lg:w-[35%]">
                                <div class="w-full aspect-[16/9] bg-gray-200 rounded-xl overflow-hidden">
                                    <img src="{{ asset('storage/' . $banner->image) }}"
                                        class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                </div>
                            </div>
                        @endif
                    @endfor
                @endif

                {{-- Banner Asli --}}
                @foreach ($banners as $banner)
                    @php
                        $link = null;

                        if ($banner->product_id) {
                            $link = route('products.show', $banner->product_id);
                        } elseif ($banner->link) {
                            $link = $banner->link;
                        }
                    @endphp

                    <div class="flex-none w-[75%] sm:w-[65%] md:w-[55%] lg:w-[35%]">

                        <div class="w-full aspect-[16/9] bg-gray-200 rounded-xl overflow-hidden">

                            @if ($link)
                                <a href="{{ $link }}">
                            @endif

                            <img src="{{ asset('storage/' . $banner->image) }}"
                                class="w-full h-full object-cover hover:scale-105 transition duration-300">

                            @if ($link)
                                </a>
                            @endif

                        </div>

                    </div>
                @endforeach

                {{-- Clone Depan --}}
                @if ($banners->count() > 0)
                    @for ($i = 0; $i < $cloneCount; $i++)
                        @if (isset($banners[$i]))
                            @php
                                $banner = $banners[$i];
                            @endphp

                            <div class="slide-item flex-none w-[75%] sm:w-[65%] md:w-[55%] lg:w-[35%]">

                                <div class="w-full aspect-[16/9] bg-gray-200 rounded-xl overflow-hidden">

                                    <img src="{{ asset('storage/' . $banner->image) }}"
                                        class="w-full h-full object-cover hover:scale-105 transition duration-300">

                                </div>

                            </div>
                        @endif
                    @endfor
                @endif

            </div>

            {{-- BUTTON LEFT --}}
            <button onclick="prevSlide()"
                class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 text-white px-3 py-1 rounded hover:bg-black/60">
                ‹
            </button>

            {{-- BUTTON RIGHT --}}
            <button onclick="nextSlide()"
                class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 text-white px-3 py-1 rounded hover:bg-black/60">
                ›
            </button>

        </div>

    </div>
    {{-- pilih Category --}}

    @if ($categorys->count() > 0)
        <div class="flex gap-2 overflow-x-auto mb-6 pb-2">
            @foreach ($categorys as $category)
                <button class="px-2 py-1 bg-white border rounded-full text-sm  ">

                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    @else
        <div class="flex items-center justify-center text-center">
            <h1 class="font-semibold text-red-500 text-sm">Category tidak tersedia...</h1>

        </div>
    @endif
    <div class="mb-6">
        <label class="block text-xs text-gray-500">Rating</label>
        <div class="flex gap-2 mt-2">
            <button class="px-3 py-1 rounded bg-gray-100 text-sm hover:bg-gray-200">
                4★ & up
            </button>
            <button class="px-3 py-1 rounded bg-gray-100 text-sm hover:bg-gray-200">
                3★ & up
            </button>
        </div>
    </div>

    <!-- Products Grid -->
    @if ($products->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-3">

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
                            <span class="block mt-2 font-semibold text-blue-600 text-base sm:text-xl ">
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
    @else
        <div class="flex flex-col items-center justify-center min-h-[30vh] text-center ">
            <h1 class="text-red-500 text-xl font-semibold">Barang Tidak tersedia...</h1>
            <p class="text-gray-400 text-sm mt-2">
                Coba kategori lain atau cek lagi nanti
            </p>
        </div>
    @endif
    {{-- JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const carousel = document.getElementById('carousel');

            if (!carousel) return;

            const slides = carousel.children;

            const cloneCount = 2;

            let index = cloneCount;

            const totalSlides = slides.length;

            let autoSlide;

            function getSlideWidth() {

                const gap = 16;

                return slides[0].offsetWidth + gap;
            }

            function updateSlide(animate = true) {

                if (animate) {

                    carousel.style.transition =
                        'transform 0.5s ease-in-out';

                } else {

                    carousel.style.transition = 'none';
                }

                const slideWidth = getSlideWidth();

                carousel.style.transform =
                    `translateX(-${index * slideWidth}px)`;
            }

            // posisi awal
            updateSlide(false);

            function nextSlide() {

                index++;

                updateSlide(true);

                // reset depan
                if (index >= totalSlides - cloneCount) {

                    setTimeout(() => {

                        index = cloneCount;

                        updateSlide(false);

                    }, 500);
                }
            }

            function prevSlide() {

                index--;

                updateSlide(true);

                // reset belakang
                if (index < cloneCount) {

                    setTimeout(() => {

                        index = totalSlides - (cloneCount * 2);

                        updateSlide(false);

                    }, 500);
                }
            }

            // expose ke button
            window.nextSlide = nextSlide;
            window.prevSlide = prevSlide;

            // auto slide
            function startAutoSlide() {

                autoSlide = setInterval(() => {

                    nextSlide();

                }, 4000);
            }

            startAutoSlide();

        });
    </script>
@endsection
