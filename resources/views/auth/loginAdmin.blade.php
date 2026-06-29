<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Admin</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    @if ($errors->any())
        <script>
            alert("{{ $errors->first() }}");
        </script>
    @endif
    <div class="flex items-center justify-center min-h-screen">
        <div class="max-w-sm w-full bg-white p-8 rounded-2xl shadow-lg">
            <p class="text-center">Selamat Datang Admin</p>
            <h1 class="text-2xl font-bold text-center mb-6 ">Login</h1>
            <form action="{{ route('admin.login.post') }}" class="space-y-2" method="POST">
                @csrf
                <input type="email" class="border p-2 w-full" placeholder="Email" name="email">
                <input type="password" class="border p-2 w-full" placeholder="password" name="password">
                <button type="submit"
                    class="bg-blue-500 p-2 w-full text-white hover:bg-blue-600 cursor-pointer">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
