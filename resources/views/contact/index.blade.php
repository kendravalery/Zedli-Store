@extends('layout.layout_customer')
@section('ContentCustomer')
    @if (session('success'))
        <script>
            alert(@js(session('success')));
        </script>
    @endif
    <div class="flex flex-col justify-center items-center">
        <div class="mb-7 ">
            <h1 class="font-semibold text-3xl ">Customer Service</h1>
        </div>
        <div class="w-full max-w-2xl">
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="flex items-center justify-center flex-col mb-2">
                    <div class="mb-2">
                        <label class="block text-center">Name</label>
                        <input type="text" name="name" id="" class="border-b border-gray-300 p-2 rounded"
                            required required>
                    </div>
                    <div class="mb-2">
                        <label class="block text-center">E-mail</label>
                        <input type="email" name="email" id="" class="border-b border-gray-300 p-2 rounded"
                            required>
                    </div>
                    <div class="mb-2">
                        <label class="block text-center">Subject</label>
                        <input type="text" name="subject" id="" class="border-b border-gray-300 p-2 rounded">
                    </div>
                </div>
                <div class="mb-2 block text-center ">
                    <label class="mb-2 block">Message</label>
                    <textarea name="message" id="" class="border w-full  border-gray-300 p-2 rounded" required></textarea>
                    <button type="submit" class="cursor-pointer border-b border-gray-300 p-2">Submit</button>
                </div>
            </form>
        </div>
        <div class="text-gray-500  ">
            <p class="text-center">Anda dapat menanyakan dan mengrkitik website kami.</p>
            <p>jika ada kesalahan atau bug jangan ragu untuk menghubungi kami </p>

        </div>
    </div>
@endsection
