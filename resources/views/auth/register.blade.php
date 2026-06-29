<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50">
    <div class="flex items-center justify-center min-h-screen">
        {{-- bagian card --}}
        <div class="max-w-sm rounded-2xl bg-white p-8 w-full shadow-lg">
            <h1 class="mb-6 text-center font-bold text-2xl">Register</h1>
            <form action="{{ route('register') }}" method="POST" class="space-y-2">
                @csrf
                <div>
                    <input type="text" name="name" placeholder="Name" class="border p-2 w-full">
                </div>
                <div>
                    <input type="email" name="email" placeholder="Email" class="border p-2 w-full">
                </div>
                <div>
                    <input type="password" name="password" placeholder="Password" class="border p-2 w-full">
                </div>
                <div>
                    <input type="password" name="password_confirmation" placeholder="confirm password"
                        class="border p-2 w-full">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white cursor-pointer hover:bg-blue-600  p-2">Register</button>
            </form>
            <p class="text-sm  mt-4 text-center">
                Sudah punya akun ? 
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Kembali ke login</a>
            </p>
        </div>
    </div>
</body>

</html>
