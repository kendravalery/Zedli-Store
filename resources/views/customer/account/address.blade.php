@extends('layout.layout_customer')
@section('ContentCustomer')
    <div x-data="{
        openModal: false,
        openModalEdit: false,
        editData: {},

        cities: [],
        districts: [],
        villages: [],


        async openEdit(address) {
            this.editData = address;
            this.cities = await api('/get-cities/' + address.province);
            this.districts = await api('/get-districts/' + address.city);
            this.villages = await api('/get-villages/' + address.district);
            this.openModalEdit = true;
        }
    }" class="flex gap-5">

        @include('customer.components.account_sidebar')
        <main class="flex-1  bg-white p-5 rounded-xl">
            <div class="mb-8">
                <div class="flex flex-wrap items-center justify-between mb-8 border-b gap-3 pb-2">
                    <div>
                        <h1 class="text-2xl font-bold">Manage Addres</h1>
                        <p class="text-sm text-gray-500">manage your address</p>
                    </div>
                    <a href="#" @click="openModal = true" class="p-2 bg-blue-500 text-white hover:bg-blue-600 rounded">+
                        Add Address</a>
                </div>
                <div class="bg-gray-100 px-4 py-2 rounded  space-y-4">
                    @foreach ($addresses as $address)
                        <div class="bg-white p-4 rounded shadow-sm flex justify-between items-start">
                            <div>
                                <div class="font-semibold">
                                    {{ $address->receiver_name }}
                                    <span class="text-gray-500">({{ $address->phone }})</span>
                                    @if ($address->is_default)
                                        <span class="ml-3 text-xs bg-green-100 text-green-700 p-1 rounded">
                                            Alamat utama
                                        </span>
                                    @endif
                                </div>
                                <div class="text-gray-700 mt-2">
                                    {{ $address->full_address }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    {{ optional(\Laravolt\Indonesia\Models\Village::where('code', $address->village)->first())->name }}
                                    {{ optional(\Laravolt\Indonesia\Models\District::where('code', $address->district)->first())->name }},
                                    {{ optional(\Laravolt\Indonesia\Models\City::where('code', $address->city)->first())->name }},
                                    {{ optional(\Laravolt\Indonesia\Models\Province::where('code', $address->province)->first())->name }},
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $address->postal_code }}
                                </div>
                            </div>
                            <div class="flex  flex-col gap-2 items-end">
                                <div class="flex gap-3">
                                    <form action="{{ route('customer.Address.delete', $address->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-700 cursor-pointer"
                                            onclick="return confirm('Apakah anda ingin mengapus alamat ini?');">Hapus</button>
                                    </form>
                                    <button @click="openEdit(@js($address))"
                                        class="text-yellow-500 cursor-pointer"> Edit</button>
                                </div>

                                @if (!$address->is_default)
                                    <form action="{{ route('customer.Address.default', $address->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-blue-600 hover:blue-700  font-medium cursor-pointer">Jadikan
                                            alamat utama</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Modal --}}
            <div x-show="openModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black/50">
                <div @click.away="openModal = false" x-transition class="bg-white w-full max-w-md p-6 rounded-xl shadow-lg">
                    <form action="{{ route('customer.Address.store') }}" method="POST" class="space-y-2">
                        @csrf
                        <div>
                            <input type="text" name="receiver_name" id="" placeholder="Nama penerima"
                                value="{{ auth()->user()->name }}" class="border p-1 rounded w-full">
                        </div>
                        <div>
                            <input type="text" name="phone" id="" placeholder="nomor hp"
                                class="border p-1 rounded w-full">
                        </div>
                        <div>

                            <textarea name="full_address" id="" cols="30" rows="10" placeholder="Alamat lengkap"
                                class="border p-1 rounded w-full"></textarea>
                        </div>


                        <div>
                            <select name="province" id="province" class="border p-1 rounded w-full">
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->code }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <select id="city" name="city" class="border p-1 rounded w-full">
                                <option value="">Pilih kota / kabupaten</option>
                            </select>
                        </div>

                        <div>
                            <select id="district" name="district" class="border p-1 rounded w-full">
                                <option value="">Pilih kecamatan</option>
                            </select>
                        </div>

                        <div>
                            <select id="village" name="village" class="border p-1 rounded w-full">
                                <option value="">Pilih Desa / Kelurahan</option>
                            </select>
                        </div>
                        <div>
                            <input type="text" name="postal_code" id="" class="border p-1 rounded w-full"
                                placeholder="kode pos">
                        </div>
                        <button type="submit"
                            class="rounded text-white p-2 cursor-pointer bg-blue-500 hover:bg-blue-600">Simpan</button>
                    </form>
                </div>
            </div>
            {{-- Modal untuk di edit --}}
            <div x-show="openModalEdit" class="fixed inset-0 flex items-center justify-center z-50  bg-black/50">
                <div @click.away="openModalEdit = false" class="bg-white w-full max-w-md rounded-xl shaodw-lg p-6">
                    <form :action="`/manage-account/update/${editData.id}`" method="POST" class="space-y-2">
                        @csrf
                        @method('PUT')
                        <div>
                            <input type="text" name="receiver_name" x-model="editData.receiver_name"
                                placeholder="Nama penerima" class="border p-1 rounded w-full">
                        </div>
                        <div>
                            <input type="text" name="phone" id="" placeholder="nomor hp"
                                x-model="editData.phone" class="border p-1 rounded w-full">
                        </div>
                        <div>
                            <textarea name="full_address" id="" cols="30" rows="10" placeholder="Alamat lengkap"
                                x-model="editData.full_address" class="border p-1 rounded w-full"></textarea>
                        </div>

                        <div>
                            <select name="province" class="border p-1 rounded w-full" x-model="editData.province"
                                @change="cities = await api('/get-cities/' + editData.province);
                            districts = '';
                            villages = '';
                            editData.city = '';
                            editData.district = '';
                            editData.village = '';
                            ">
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->code }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Select kota --}}
                        <div>
                            <select name="city" class="border p-1 rounded w-full" x-model="editData.city"
                                @change="districts = await api('/get-districts/' + editData.city);
                            villages = [];
                            editData.district = '';
                            editData.village = '';
                            ">
                                <option value="">Pilih kota / kabupaten</option>
                                <template x-for="city in cities" :key="city.code">
                                    <option :value="city.code" x-text="city.name"></option>
                                </template>

                            </select>
                        </div>
                        {{-- select kecamatan --}}
                        <div>
                            <select name="district" class="border p-1 rounded w-full" x-model="editData.district"
                                @change="villages = await api('/get-villages/' + editData.district);
                            editData.village = '';">
                                <option value="">Pilih kecamatan</option>
                                <template x-for="district in districts" :key="district.code">
                                    <option :value="district.code" x-text="district.name"></option>
                                </template>
                            </select>
                        </div>
                        {{-- select desa --}}
                        <div>
                            <select name="village" class="border p-1 rounded w-full" x-model="editData.village">
                                <option value="">Pilih Desa / Kelurahan</option>
                                <template x-for="village in villages" :key="village.code">
                                    <option :value="village.code" x-text="village.name"></option>
                                </template>
                            </select>
                        </div>
                        <div>
                            <input type="text" name="postal_code" id="" class="border p-1 rounded w-full"
                                x-model="editData.postal_code" placeholder="kode pos">
                        </div>
                        <button type="submit"
                            class="rounded text-white p-2 cursor-pointer bg-yellow-500 hover:bg-yellow-600">Simpan</button>
                        {{-- <button class="text-yellow-500 cursor-pointer">Edit</button> --}}
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script>
        const api = (url) =>
            fetch(url).then(r => r.json());

        document.addEventListener('DOMContentLoaded', () => {
            const province = document.getElementById('province');
            const city = document.getElementById('city');
            const district = document.getElementById('district');
            const village = document.getElementById('village');

            province.addEventListener('change', async function() {
                city.innerHTML = '<option>Loading...</option>';
                district.innerHTML = '<option value="">Pilih Kecamatan</option>';
                village.innerHTML = '<option value="">Pilih Desa / Kelurahan</option>';

                const data = await api('/get-cities/' + this.value);

                city.innerHTML = '<option value="">Pilih kota / kabupaten</option>';
                data.forEach(item => {
                    city.innerHTML += `<option value="${item.code}">${item.name}</option>`;
                });
            });

            city.addEventListener('change', async function() {
                const data = await api('/get-districts/' + this.value);

                district.innerHTML = '<option value="">Pilih Kecamatan</option>';
                data.forEach(item => {
                    district.innerHTML += `<option value="${item.code}">${item.name}</option>`;
                });
            });

            district.addEventListener('change', async function() {
                const data = await api('/get-villages/' + this.value);

                village.innerHTML = '<option value="">Pilih Desa / Kelurahan</option>';
                data.forEach(item => {
                    village.innerHTML += `<option value="${item.code}">${item.name}</option>`;
                });
            });
        });
    </script>
@endsection
