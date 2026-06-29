<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zedli</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        function ConfirmLogout() {
            return confirm('Apakah Anda ingin Logout ?');
        }
    </script>
</head>

<body class="bg-gray-100 text-gray-800 ">
    {{-- NAVBAR --}}
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between py-3  gap-4">

                <div class="flex items-center gap-4 shrink-0">
                    <a href="/" class="flex items-center gap-1">
                        <div
                            class="w-10 h-10 bg-blue-500 text-white rounded-lg flex items-center justify-center font-bold ">
                            Zi</div>
                        <span class="font-semibold text-lg tracking-light hidden sm:inline">Zedli</span>
                    </a>
                    <nav class="hidden md:flex items-center gap-5">
                        {{-- <a href="/"
                            class="px-3  py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">Home</a> --}}
                    </nav>
                </div>

                {{-- UNTUK SEARCH --}}
                <div class="w-full order-3 md:order-none md:flex-1 px-1">
                    <form action="#" class="max-w-xl mx-auto relative">
                        <input type="search" placeholder="Cari produk"
                            class="w-full pl-4 py-2.5 pr-20 border border-gray-200 rounded-full  focus:outline-none focus:ring-blue-300 text-sm">
                        <button type="submit"
                            class="absolute right-1 top-1/2 -translate-y-1/2 bg-blue-600 text-white px-4 py-1.5 rounded-full hover:bg-blue-700">Cari</button>
                    </form>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    {{-- akun --}}
                    <a href="{{ route('cart.index') }}"
                        class="relative inline-flex items-center px-3 py-2 rounded-md hover:bg-gray-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 7h14l-2-7M9 21a1 1 0 11-2 0 1 1 0 012 0zm8 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>

                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs px-1 rounded-full">
                            {{ $cartCount }}
                        </span>
                    </a>
                    {{-- Acount Dropdown --}}
                    <div class="relative">
                        @guest
                            <div class="flex items-center gap-2">
                                <a href="{{ route('login') }}" class="px-3 py-2 text-sm rounded-md hover:bg-gray-100">Login
                                </a>
                                <a href="{{ route('register') }}"
                                    class="px-3 py-2 text-sm rounded-md bg-blue-500 hover:bg-blue-600 text-white">Register</a>
                            </div>
                        @endguest

                        @auth
                            <button id="accBtn"
                                class="flex items-center gap-2 px-3 rounded-md hover:bg-gray-100 py-2 transition">
                                @if (auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                        class="w-8 h-8 rounded-full border">
                                    <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}"
                                        alt="avatar"class="w-8 h-8 rounded-full" />
                                    <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                                @endif
                            </button>

                            <div id="accMenu"
                                class="absolute right-0 mt-2 w-44 rounded-sm shadow-lg bg-white border border-gray-200 z-50"
                                style="display:none;">

                                <a href="{{ route('customer.profile') }}" class="block px-4 py-2 hover:bg-gray-50">My
                                    acount</a>

                                <a href="{{ route('customer.address') }}"
                                    class="block px-4 py-2 hover:bg-gray-50">Address</a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-50">Orders</a>
                                {{-- <a href="#" class="block px-4 py-2 hover:bg-gray-50">Pengaturan</a> --}}

                                <div class="border-t border-gray-100 my-1"></div>

                                <form action="{{ route('logout') }}" method="POST" onsubmit="return ConfirmLogout()">
                                    @csrf

                                    <input type="submit"value="Logout"
                                        class="w-full text-left px-4 text-sm hover:bg-red-50  text-red-500 py-2">
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Ini bagian Main  --}}
    <main class="flex-1  overflow-auto">
        <div class="max-w-7xl mx-auto p-4 sm:p-6">
            @yield('ContentCustomer')
        </div>
    </main>
    <script>
        const accBtn = document.getElementById('accBtn');
        const accMenu = document.getElementById('accMenu');

        accBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            accMenu.style.display =
                accMenu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', (e) => {
            if (!accMenu.contains(e.target) && !accBtn.contains(e.target)) {
                accMenu.style.display = 'none';
            }
        });
    </script>

</body>

</html>
