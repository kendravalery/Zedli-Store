<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    @if ($errors->any())
        <script>
            alert("{{ $errors->first() }}");
        </script>
    @endif
    <div class="flex items-center justify-center min-h-screen ">
        <div class="bg-white shadow-lg  max-w-sm  rounded-2xl  p-8 w-full">
            <p class="text-center">selamat datang di <a href="{{ route('home') }}" class="text-blue-500">Zedli Store</a>
            </p>
            <h1 class="text-2xl font-bold text-center mb-6">Login</h1>
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <input type="email" name="email" placeholder="Email" class="border p-3 w-full rounded" required>

                <input type="password" name="password" placeholder="Password" class="border p-3 w-full" required>

                <button type="submit"
                    class="bg-blue-500 text-white p-2 w-full hover:bg-blue-600 cursor-pointer">Login</button>
            </form>
            <p class="text-center text-sm mt-4">
                Belum Punya akun ?
                <a href="/register" class="text-blue-500 hover:underline">register</a>
            </p>
        </div>
    </div>
</body>

</html>
