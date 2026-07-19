<footer class="bg-white py-8">
    <div class="flex justify-center mb-5">
        <div class="mr-[30px]">
            <h2 class="text-2xl text-center">INFO</h2>
            <div class="font-thin ">
                <p class="text-smp  text-center "><a href="{{ route('about') }} ">about ZedliStore</a></p>
                <p class="text-smp  text-center"><a href="{{ route('contact.show') }}">contactUs</a></p>
                <p class="text-smp  text-center"><a href="{{ route('faq') }}">faq</a></p>
            </div>
        </div>
        <div class="ml-[30px] flex flex-col items-center">
            <h2 class=" text-2xl ">SNS</h2>
            <div class="flex gap-3 mt-2">
                <a href="#"> <img src="{{ asset('icon/twitter.png') }}" class="w-5 h-5 " height="17px"
                        width="17px" class="cursor-pointer"></a>
                <a href="#"> <img src="{{ asset('icon/instagram.png') }}" class="w-5 h-5" height="17px"
                        width="17px" class="cursor-pointer"></a>
                <a href="#"> <img src="{{ asset('icon/facebook-app-symbol.png') }}" class="w-5 h-5" height="17px"
                        width="17px" class="cursor-pointer"></a>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-4 text-center">
        <h2 class="font-mono text-sm">
            ©{{ date('Y') }}, ZEDLI STORE</h2>
    </div>

</footer>

{{-- LANJUT BUAT SEARCH SAMA KATEGORI , ATAU LANGSUNG API MIDTRANS ?    --}}
