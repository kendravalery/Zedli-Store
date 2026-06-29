@extends('layout.layout_admin')

@section('ContentAdmin')
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white rounded-lg">
        <h1 class="text-2xl font-bold">Kelola Produk</h1>
        <p></p>
    </div>
    <h1 class="text-2xl font-bold mb-4">Products</h1>

    <a href="{{ route('admin.products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
        + Add Product
    </a>

    <table class="w-full mt-5 bg-white shadow rounded overflow-hidden">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">Name</th>
                <th class="p-3">Image</th>
                <th class="p-3">Price</th>
                <th class="p-3">Stock</th>
                <th class="p-3">Category</th>
                <th class="p-3">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($products as $product)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $product->name }}</td>

                    {{-- <td class="p-3">
                        @if ($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}"
                                class="w-12 h-12 object-cover rounded cursor-pointer" onclick="openImageModal(this.src)">
                        @else
                            <span class="text-gray-400 text-sm">No Image</span>
                        @endif
                    </td> --}}
                    <td class="p-2 flex gap-2 ">
                        @foreach ($product->images as $img)
                            <img src="{{ asset('storage/' . $img->path) }}"
                                class="w-12 h-12 object-cover rounded cursor-pointer" onclick="openImageModal(this.src)">
                        @endforeach
                    </td>
                    <td class="p-3">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>

                    <td class="p-3">{{ $product->stock }}</td>

                    <td class="p-3">
                        {{ $product->category->name ?? '-' }}
                    </td>

                    <td class="p-3 space-x-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 hover:underline">
                            Edit
                        </a>

                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:underline">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-4 text-gray-400">
                        Belum ada produk
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Image Modal --}}
    <div id="imageModal" class="fixed inset-0 hidden items-center justify-center backdrop-blur-sm z-50">
        <div class="relative">
            <img id="modalImage" alt="" class="max-w-3xl max-h-[88vh] rounded shadow-lg">

            <button onclick="closeImageModal()"
                class="absolute -top-3 -right-3 bg-red-500 text-white w-8 h-8 rounded-full ">X</button>
        </div>
    </div>
    <script>
        function openImageModal(src) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');

            img.src = src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');

            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target.id === 'imageModal') {
                closeImageModal();
            }
        });
    </script>
@endsection
