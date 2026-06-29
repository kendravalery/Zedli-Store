@extends('layout.layout_admin')
@section('ContentAdmin')
    <div>
        <h1 class="text-2xl font-bold mb-4">Categories</h1>

    </div>

    <button onclick="openModal()" class="bg-blue-500 text-white px-4 py-2 mb-4">+ Tambah Category</button>

    <table class="bg-gray-200">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">No</th>
                <th class="p-2">Name</th>
                <th class="p-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $i => $cat)
                <tr class="border-t text-center ">
                    <td class="p-2 ">{{ $i + 1 }}</td>
                    <td class="p-2 ">{{ $cat->name }}</td>
                    <td class="p-2 ">
                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST">
                            @csrf
                            @method('Delete')
                            <button class="bg-red-500 text-white px-2 py-1 rounded-lg">
                                Delete
                            </button>

                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    {{-- ================= MODAL ================= --}}
    <div id="modal"
        class="fixed inset-0 hidden items-center justify-center z-50
           bg-black/30 backdrop-blur-sm transition-all duration-200">

        <div class="bg-white w-[400px] rounded-2xl shadow-xl p-6
                transform scale-95 opacity-0 transition-all duration-200"
            id="modalContent">

            {{-- TITLE --}}
            <h2 class="text-xl font-semibold mb-4">Tambah Category</h2>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <input type="text" name="name" placeholder="Nama Category"
                    class="border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200
                       outline-none p-2 w-full mb-4 rounded-lg">

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded-lg">
                        Batal
                    </button>

                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg">
                        Save
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        const modal = document.getElementById('modal');
        const content = document.getElementById('modalContent');

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 150);
        }
    </script>
@endsection
