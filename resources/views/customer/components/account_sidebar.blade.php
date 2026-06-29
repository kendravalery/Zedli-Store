<div>
    <aside class="w-72 bg-white p-5 rounded-xl shadow-sm">
        <div class="flex items-center gap-3 pb-5 mb-5 border-b">
            <div>
                @if (auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt=""
                        class="rounded-full w-16 h-16 object-cover border">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt=""
                        class="object-cover h-16 w-16 rounded-full">
                @endif

            </div>
            <div>
                <h1 class="text-lg font-bold ">
                    {{ Auth::user()->name }}
                </h1>
                <p class="text-sm text-gray-400 break-all">
                    {{ Auth::user()->email }}
                </p>
            </div>
        </div>


        <div class="flex flex-col gap-2">

            <a href="{{ route('customer.profile') }}">My Account</a>
            <a href="{{ route('customer.manage.account') }}">Manage account</a>
            <a href="{{ route('customer.address') }}">Address</a>
            <a href="{{ route('Wishlist.index') }}">Wishlist</a>
            <a href="#">Orders</a>

        </div>

    </aside>
</div>
