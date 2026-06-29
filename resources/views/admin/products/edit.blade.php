@extends('layout.layout_admin')

@section('ContentAdmin')
<h1 class="text-2xl font-bold mb-4">Edit Product</h1>

{{-- FORM UPDATE UTAMA --}}
<form action="{{ route('admin.products.update', $product->id) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input name="name"
        value="{{ old('name', $product->name) }}"
        class="border p-2 w-full mb-2"
        required>

    <textarea name="description"
        class="border p-2 w-full mb-2">{{ old('description', $product->description) }}</textarea>

    <input type="number" step="0.01"
        name="price"
        value="{{ old('price', $product->price) }}"
        class="border p-2 w-full mb-2"
        required>

    <input type="number"
        name="stock"
        value="{{ old('stock', $product->stock) }}"
        class="border p-2 w-full mb-2"
        required>

    <select name="category_id" class="border p-2 w-full mb-2" required>
        <option value="">-- Pilih Category --</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}"
                {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>

    <input type="file"
        name="images[]"
        multiple
        onchange="previewImages(event)"
        class="border p-2 w-full mb-2">

    <div id="preview" class="grid grid-cols-3 gap-3 mt-3"></div>

    <label class="flex items-center gap-2 mb-2">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1"
            {{ $product->is_active ? 'checked' : '' }}>
        Active Product
    </label>

    <label class="flex items-center gap-2 mb-2">
        <input type="hidden" name="is_limited" value="0">
        <input type="checkbox" name="is_limited" value="1"
            {{ $product->is_limited ? 'checked' : '' }}>
        Limited Product
    </label>

    <input type="number"
        name="limited_quantity"
        value="{{ old('limited_quantity', $product->limited_quantity) }}"
        class="border p-2 w-full mb-2">

    <button type="submit"
        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
        Update Product
    </button>
</form>

{{-- GAMBAR LAMA, DI LUAR FORM UPDATE --}}
<div class="mb-3 mt-6">
    <p class="font-semibold">Gambar Saat Ini:</p>

    <div class="grid grid-cols-3 gap-3 mt-2">
        @foreach ($product->images as $img)
            <div class="relative">
                <img src="{{ asset('storage/' . $img->path) }}"
                    class="w-full h-32 object-cover rounded shadow">

                <form action="{{ route('admin.products.image.delete', $img->id) }}"
                      method="POST"
                      class="absolute top-1 right-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('hapus gambar ini?')"
                        class="bg-red-500 text-white text-xs px-2 py-1 rounded">
                        X
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</div>

<a href="{{ route('admin.products.index') }}" class="text-blue-500 block mt-3">
    ← Kembali
</a>

<script>
let selectedFiles = [];

function previewImages(event) {
    selectedFiles = Array.from(event.target.files);

    if (selectedFiles.length > 10) {
        alert("Maksimal 10 gambar!");
        event.target.value = "";
        selectedFiles = [];
        return;
    }

    renderPreview();
}

function renderPreview() {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';

    selectedFiles.forEach((file) => {
        const reader = new FileReader();

        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = "relative";
            div.innerHTML = `<img src="${e.target.result}" class="w-full h-32 object-cover rounded shadow">`;
            preview.appendChild(div);
        };

        reader.readAsDataURL(file);
    });
}
</script>
@endsection
