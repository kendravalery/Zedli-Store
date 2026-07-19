@extends('layout.layout_customer')
@section('ContentCustomer')
    <div class="flex  flex-col items-center justify-center min-h-[70vh]">
        <div>
            <h1 class="font-semibold text-2xl p-3 mb-3">
                ZedliStore
            </h1>
        </div>
        <p class="mb-2">the smal e-commerce </p>
        <p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio provident, perspiciatis ratione iure suscipit id nam veniam nulla dolor qui iste ea? Veritatis autem molestias non quibusdam ut dolor! Accusantium!</p>

        <div class="mt-auto mb-3">
            <img src="{{ asset('profile/6abce44ba2ba2e2712ff78f3332fd747~tplv-tiktokx-cropcenter_1080_1080.jpeg') }}"
                alt=""  class="shadow-2xl rounded-lg h-46 w-46 ">
            <h2 class="my-3">Kendra VM </h2>
            <ul class="list-disc list-inside">
                <li>Owner</li>
                <li>Progammer</li>
            </ul>
        </div>
    </div>
@endsection
