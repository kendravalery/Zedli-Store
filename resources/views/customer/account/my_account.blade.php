@extends('layout.layout_customer')

@section('ContentCustomer')
    <div class="flex gap-5">

        @include('customer.components.account_sidebar')

        <main class="flex-1 bg-white p-5 rounded-xl">
            <div class="mb-8">
                <h1 class="text-2xl font-bold">My account</h1>
            </div>
            {{-- Profile --}}
            <div class="flex items-center gap-5 mb-10">
                <form id="photoForm" action="{{ route('customer.profile.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="relative w-24 h-24">

                        @if (auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                class="w-24 h-24 rounded-full object-cover border ">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}"
                                class="w-24 h-24 rounded-full border">
                        @endif
                        {{-- Profile edit --}}
                        <label for="profile_photo"
                            class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow cursor-pointer hover:bg-gray-100"><img
                                src="{{ asset('icon/4682658.png') }}" width="15" height="15" alt="">
                        </label>
                    </div>
                    {{-- Upload photo --}}

                    <input type="file" name="profile_photo" id="profile_photo" class="hidden"
                        onchange="document.getElementById('photoForm').submit()">
                </form>

                {{-- Info --}}
                <div>
                    <h2 class="text-xl font-semibold">
                        {{ auth()->user()->name }}
                    </h2>
                    <p class="text-gray-500">{{ auth()->user()->email }}</p>
                </div>
            </div>
            {{-- detail --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- NAME --}}
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Name
                    </label>

                    <input type="text" value="{{ auth()->user()->name }}"
                        class="w-full border border-gray-200 rounded-lg p-3 bg-gray-50" readonly>
                </div>

                {{-- USERNAME --}}
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Username
                    </label>

                    <input type="text" value="{{ auth()->user()->username }}"
                        class="w-full border border-gray-200 rounded-lg p-3 bg-gray-50" readonly>
                </div>

                {{-- EMAIL --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">
                        Email
                    </label>

                    <input type="text" value="{{ auth()->user()->email }}"
                        class="w-full border border-gray-200 rounded-lg p-3 bg-gray-50" readonly>
                </div>
            </div>
        </main>
    </div>
@endsection
