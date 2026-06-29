@extends('layout.layout_admin')

@section('ContentAdmin')
    <h1 class="text-xl font-bold mb-4">Tambah Banner</h1>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="image" id="imageInput" accept="image/*" class="border p-1">
        </div>
        <div class="mt-3">
            <img id="previewImage" class="w-48 h-32 object-cover hidden rounded border">
        </div>
        <div class="mb-3">
            <label>Pilih Produk (opsional)</label>
            <select name="product_id" class="border p-2 w-full">
                <option value="">-- Tidak ada --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Link (opsional)</label>
            <input type="text" name="link" class="border p-2 w-full" placeholder="https://...">
        </div>

        <button class="bg-green-500 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
    <a href="{{ route('admin.banners.index') }}"><-batal </a>

            <script>
                document.getElementById('imageInput').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    const preview = document.getElementById('previewImage');

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                        };

                        reader.readAsDataURL(file);
                    }
                });
            </script>
        @endsection
