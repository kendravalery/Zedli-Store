@extends('layout.layout_admin')
@section('ContentAdmin')
    {{-- <div class="max-w-3xl mx-auto">
        <div class="bg-gray-100 shadow-md p-6 leading-relaxed break-word">Selamat datangdi Dashboard penjual</div>
    </div> --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow text-white p-6">
        <h1 class="text-2xl font-bold">Halo : {{ auth()->User()->name }}</h1>
        <p class="mt-2">Selamat datang di dashboard</p>
    </div><p>customer adalah raja</p>
@endsection
