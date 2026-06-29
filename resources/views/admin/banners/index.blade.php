@extends('layout.layout_admin')
@section('ContentAdmin')
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow text-white p-6 ">
        <h1 class="text-2xl font-bold">Dashboard Kelola Banner</h1>
    </div>
    <h1 class="text-xl font-bold mb-4 my-5">Banner</h1>
    <a href="{{ route('admin.banners.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">+Tambah
        banner</a>
    <table class="w-full bg-white rounded shadow">
        <thead>
            <tr class="border-b">
                <th class="p-2">Gambar</th>
                <th class="p-2">Produk</th>
                <th class="p-2">Link</th>
                <th class="p-2">Status</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banners as $banner)
                <tr class="border-b text-center">
                    <td class="p-2"><img src="{{ asset('storage/' . $banner->image) }}"
                            class="w-32 h-16 object-cover mx-auto">
                    </td>
                    <td class="">{{ $banner->product?->name ?? '-' }}</td>
                    <td>{{ $banner->link ?? '--' }}</td>
                    <td>
                        <form action="{{ route('admin.banners.toggle', $banner->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="px-3 py-1 rounded text-white text-sm {{ $banner->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                        </form>
                    </td>
                    <td class="p-7 flex gap-2 justify-center">

                        <a href="{{ route('admin.banners.edit', $banner->id) }}"
                            class="bg-yellow-400 px-2 py-1 rounded text-white text-sm">
                            Edit
                        </a>

                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus banner?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 px-2 py-1 rounded text-white text-sm">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
