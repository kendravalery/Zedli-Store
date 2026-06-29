@extends('layout.layout_admin')

@section('ContentAdmin')
    <h1 class="text-2xl font-bold mb-4">Add Product</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- NAME --}}
        <input name="name" placeholder="Product Name" class="border p-2 w-full mb-2" required>

        {{-- DESCRIPTION --}}
        <textarea name="description" placeholder="Description" class="border p-2 w-full mb-2"></textarea>

        {{-- PRICE --}}
        <input type="number" step="0.01" name="price" placeholder="Price" class="border p-2 w-full mb-2" required>

        {{-- STOCK --}}
        <input type="number" name="stock" placeholder="Stock" class="border p-2 w-full mb-2" required>

        {{-- CATEGORY --}}
        <select name="category_id" class="border p-2 w-full mb-2" required>
            <option value="">-- Pilih Category --</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>

        {{-- MULTIPLE IMAGE --}}
        <input type="file" name="images[]" multiple onchange="previewImages(event)" class="border p-2 w-full mb-2">

        {{-- Preview --}}
        <div id="preview" class="grid grid-cols-3 gap-3 mt-3"></div>
        {{-- IS ACTIVE --}}
        <label class="flex items-center gap-2 mb-2">
            <input type="checkbox" name="is_active" value="1" checked>
            Active Product
        </label>

        {{-- IS LIMITED --}}
        <label class="flex items-center gap-2 mb-2">
            <input type="checkbox" name="is_limited" value="1">
            Limited Product
        </label>

        {{-- LIMITED QTY --}}
        <input type="number" name="limited_quantity" placeholder="Limited Quantity" class="border p-2 w-full mb-2">

        <button class="bg-green-500 text-white px-4 py-2">
            Save Product
        </button>
    </form>

    <a href="{{ route('admin.products.index') }}" class="text-blue-500">
        ← Kembali
    </a>
    <script>
        let selectedFiles = [];

        function previewImages(event) {
            let files = Array.from(event.target.files);

            if (files.length > 10) {
                alert("Maksimal 10 gambar!");
                event.target.value = "";
                return;
            }

            selectedFiles = files;
            renderPreview();
        }

        function renderPreview() {
            let preview = document.getElementById('preview');
            preview.innerHTML = '';

            selectedFiles.forEach((file, index) => {


                let reader = new FileReader();

                reader.onload = function(e) {
                    let div = document.createElement('div');
                    div.className = "relative";


                    div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded shadow">

                    <button type="button"
                       onclick="removeImage(${index})"
                        class="absolute top-1 right-1 bg-red-500 text-white text-xs px-2 py-1 rounded">
                        X
                    </button>
                `;

                    preview.appendChild(div);
                };

                reader.readAsDataURL(file);
            });
        }

        function removeImage(index) {
            selectedFiles.splice(index, 1);

            let input = document.querySelector('input[name="images[]"]');

            let dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));

            input.files = dataTransfer.files;

            if (selectedFiles.length === 0) {
                input.value = "";
            }

            renderPreview();
        }
    </script>
@endsection
