<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=], initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
    <script>
        function ConfirmLogout() {
            return confirm('Apakah Anda ingin Logout ?');
        }
    </script>
</head>

<body class="bg-gray-50 text-gray-800 ">
    {{-- NAVBAR --}}
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex  items-center h-20 gap-4">

                <div class="flex items-center gap-4 shrink-0">
                    <a href="/" class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-blue-500 text-white rounded-lg flex items-center justify-center font-bold ">
                            Tk</div><span class="font-semibold text-lg tracking-light">Tokline</span>
                    </a>
                    <nav class="hidden md:flex items-center gap-5">
                        <a href="#"
                            class="px-3  py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">Home</a>
                    </nav>
                </div>
                {{-- UNTUK SEARCH --}}
                <div class="flex-1 px-4">
                    <a href="{{ route('login') }}" class="max-w-xl mx-auto relative">
                        <input type="search" placeholder="Cari produk"
                            class="w-full pl-4 py-2.5 pr-24 border border-gray-200 rounded-full  focus:outline-none focus:ring-blue-300 text-sm">
                        <button type="submit"
                            class="absolute right-1 top-1/2 -translate-y-1/2 bg-blue-600 text-white px-4 py-1.5 rounded-full hover:bg-blue-700">Cari</button>
                    </a>
                </div>
                <div class="flex items-center gap-2 shirnk-0">
                    {{-- akun --}}
                    <a href="#"
                        class="relative inline-flex items-center px-3 py-2 rounded-md hover:bg-gray-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 7h14l-2-7M9 21a1 1 0 11-2 0 1 1 0 012 0zm8 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs px-1 rounded-full">3</span>
                    </a>
                    {{-- Acount Dropdown --}}
                    <div class="relative">
                        <div class="bg-gray-100 p-1 rounded-lg ">
                            <div>
                                <a href="{{ route('login') }}">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Ini bagian Main  --}}
    <main class="flex-1 p-6  overflow-auto">

    </main>
    {{-- SEMENTARA SEMENTARA SEMENTARA --}}
    </script>

</body>

</html>
