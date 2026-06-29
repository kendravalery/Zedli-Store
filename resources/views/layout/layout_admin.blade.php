<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    @vite('resources/css/app.css')
    <script>
        function ConfirmLogout() {
            return confirm("Apakah Anda Ingin Logout ? ");
        }
    </script>
</head>

<body>
    <div class="flex min-h-screen">
        <aside class="w-72 bg-gray-100 border-r border-slate-200 p-4 sticky top-0 h-screen flex flex-col">
            {{-- < ini cukup penting --}}
            <div class="p-6 text-black font-bold text-2xl">Dashboard Admin</div>
            <nav class="flex-1 px-4 space-y-2">

                <div class="bg-white rounded-b-sm mb-3 hover:bg-gray-50">
                    <a href="{{ route('admin.dashboard') }}">
                        <div class="text-center text-black p-1">Dashboard</div>
                    </a>
                </div>

                <div class="bg-white rounded-b-sm mb-3 hover:bg-gray-50">
                    <a href="{{ route('admin.products.index') }}">
                        <div class="text-center text-black p-1">Products</div>
                    </a>
                </div>

                <div class="bg-white rounded-b-sm mb-3 hover:bg-gray-50">
                    <a href="{{route('admin.categories.index')}}">
                        <div class="text-center text-black p-1">Categories</div>
                    </a>
                </div>

                <div class="bg-white rounded-b-sm mb-3 hover:bg-gray-50">
                    <a href="{{route('admin.orders.index')}}">
                        <div class="text-center text-black p-1">Orders</div>
                    </a>
                </div>

                <div class="bg-white rounded-b-sm mb-3 hover:bg-gray-50">
                    <a href="{{route('admin.reviews.index')}}">
                        <div class="text-center text-black p-1">Reviews</div>
                    </a>
                </div>
                <div class="bg-white rounded-b-sm mb-3 hover:bg-gray-50">
                    <a href="{{route('admin.banners.index')}}">
                        <div class="text-center text-black p-1">Banner</div>
                    </a>
                </div>

            </nav>
            <div class="mt-auto pt-6 border-t border-slate-100">
                <form action="{{ route('logout') }}" method="POST" onsubmit="return ConfirmLogout()">
                    @csrf
                    <input type="submit"
                        class="w-full text-center bg-white p-1 text-red-500 hover:bg-gray-50 cursor-pointer"
                        value="Logout">
                </form>
            </div>

        </aside>
        <main class="flex flex-col flex-1 overflow-y-auto p-6 ">
            @yield('ContentAdmin')
        </main>
    </div>
</body>

</html>
