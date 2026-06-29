@extends('layout.layout_customer')
@section('ContentCustomer')
    <div class="flex flex-col lg:flex-row gap-5">
        @include('customer.components.account_sidebar')
        <main class="flex-1 bg-white p-5 rounded-xl">
            <div class="mb-8">
                <h1 class="text-2xl font-bold">Manage Account</h1>
                <p class="text-sm text-gray-500">Update Your profile information</p>
            </div>
            <form action="{{ route('customer.manage.account.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block mb-2  text-sm font-medium">name : </label>
                    <input
                        class="w-full border border-gray-200 rounded p-2 focus:ring-1 focus:ring-blue-300 focus:outline-none"
                        type="text" value="{{ auth()->user()->name }}" name="name">
                </div>
                <div>
                    <label class="block mb-2  text-sm font-medium">Username : </label>
                    <input type="text" name="username"
                        class="w-full p-2 rounded  border border-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-300"
                        value="{{ auth()->user()->username }}">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium">Phone :</label>
                    <input type="tel"
                        class="w-full border border-gray-200 p-2 rounded focus:ring-1 focus:outline-none focus:ring-blue-300"
                        value="{{ auth()->user()->phone }}" name="phone">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium">Gender :</label>
                    <select name="gender"
                        class="w-full p-2 rounded border  border-gray-200 focus:outline-none focus:ring-blue-300 focus:ring-1">
                        <option value=""></option>
                        <option value="male" {{ auth()->user()->gender == 'male' ? 'selected' : '' }}> Male</option>
                        <option value="female" {{ auth()->user()->gender == 'female' ? 'selected' : '' }}> Female</option>
                        <option value="other" {{ auth()->user()->gender == 'other' ? 'selected' : '' }}> Other</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium">Birth Date :</label>
                    <input type="date" value="{{ auth()->user()->birth_date?->format('Y-m-d') }}" name="birth_date"
                        class="w-full p-2 rounded border border-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-300">
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg">Save
                        Changes</button>
                </div>
            </form>
        </main>
    </div>
@endsection
