@extends('layout.layout_admin')

@section('ContentAdmin')
    <h1 class="text-xl font-bold mb-4">Edit Banner</h1>

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        {{-- GAMBAR --}}
        <div class="mb-3">
            <label>Gambar Baru (opsional)</label>
            <input class="border" type="file" name="image" id="imageInput" accept="image/*">
        </div>

        {{-- PREVIEW --}}
        <div class="mt-3 mb-4">
            <img id="previewImage" src="{{ asset('storage/' . $banner->image) }}"
                class="w-48 h-32 object-cover rounded border">
        </div>

        {{-- PRODUCT --}}
        <div class="mb-3">
            <label>Pilih Produk</label>

            <select name="product_id" class="border p-2 w-full">
                <option value="">-- Tidak ada --</option>

                @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ $banner->product_id == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- LINK --}}
        <div class="mb-3">
            <label>Link</label>

            <input type="text" name="link" value="{{ $banner->link }}" class="border p-2 w-full">
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Update
        </button>
    </form>
    <a href="{{ route('admin.banners.index') }}">
        < Kembali</a>

            <script>
                document.getElementById('imageInput').addEventListener('change', function(event) {

                    const file = event.target.files[0];
                    const preview = document.getElementById('previewImage');

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            preview.src = e.target.result;
                        };

                        reader.readAsDataURL(file);
                    }
                });
            </script>
        @endsection
