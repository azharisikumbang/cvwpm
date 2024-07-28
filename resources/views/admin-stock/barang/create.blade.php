@extends('app')

@section('title', 'Tambah Data Barang')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-web.index') => 'Panel Admin Stok',
route('admin-stock.barang.index') => 'Data Master Barang',
'#' => 'Tambah Barang Baru',
]])
@endsection

@section('content')
<div>
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-600 md:text-2xl mb-2">
        @yield('title')
    </h1>

    @session('success')
    <div class="sm:max-w-md w-full">
        <x-alert color="green" :message="$value" />
    </div>
    @endsession

    @if ($errors->any())
    <div class="sm:max-w-md w-full">
        @foreach ($errors->all() as $error)
        <x-alert color="yellow" :message="$error" />
        @endforeach
    </div>
    @endif

    <div x-data="data">
        <form method="POST" action="{{ route('admin-stock.barang.store') }}" class="w-full">
            @csrf

            <div class="flex p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Perhatian sebelum mengisi data barang:</span>
                    <ul class="mt-1.5 list-disc list-inside">
                        <li>Gudang Penyimpanan akan diisi otomatis agar data barang tidak menggangu gudang lain.</li>
                        <li>Kode barang akan dibuat oleh sistem per barang dan kemasan, yang dimulai dari '{{
                            $kodeBarang}}' dan seterusnya. </li>
                        <li>Jumlah satuan (pcs) per dus atau jumlah satuan per kotak akan menjadi rumus perhitungan
                            untuk menentukan stok akhir dalam satuan terkecil (pcs)</li>
                        <li>Mohon isi semua data dengan benar.</li>
                    </ul>
                </div>
            </div>

            <div class="flex justify-between w-full gap-8">
                <div class="w-1/3 space-y-4 md:space-y-6 ">
                    <div>
                        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                            Gudang Penyimpanan <span class="text-sm text-gray-500">(tidak dapat dirubah)</span></label>
                        <input
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                            type="text" value="{{ auth()->user()->gudangKerja()->nama }}" readonly>
                    </div>

                    <div>
                        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">Nama Barang </label>
                        <input placeholder="cukup isi nama barang tanpa menyebut kemasan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                            type="text" name="nama" autofocus required>
                    </div>

                    <div>
                        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">Satuan </label>
                        <input
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                            type="text" name="satuan" required list="list-satuan"
                            placeholder="Tambahkan jika tidak ada dalam list.." autocomplete="off">
                        <datalist id="list-satuan">
                            <option value="pcs">
                        </datalist>
                    </div>
                </div>
                <div class="w-2/3">
                    <div class="flex justify-between items-center pb-2 border-b">
                        <div class="block text-sm font-medium text-gray-900">
                            Kemasan Barang (total: <span x-text="varian.length"></span> item)
                        </div>
                        <div>
                            <button type="button" x-on:click="tambahKemasan()"
                                class="bg-gray-400 text-white text-sm w-full px-2 py-2 rounded focus:outline-none hover:bg-gray-500">Tambah
                                Kemasan Barang</button>
                        </div>
                    </div>
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 text-left">Nama Kemasan</th>
                                <th class="py-2 text-left">Pcs Per Dus</th>
                                <th class="py-2 text-left">Pcs Per Kotak</th>
                                <th class="py-2 text-left">Harga Satuan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbody-wrapper">
                            <template x-if="varian.length > 0">
                                <template x-for="item in varian">
                                    <tr class="border-b">
                                        <td class="py-2 px-2">
                                            <input type="text" placeholder="cth. 10gr, 20gr dsb."
                                                class="px-2 py-1 border rounded bg-gray-50 border border-gray-300 text-gray-900"
                                                :name="'kemasan[' + item + '][varian]'" min="0" value="" required>
                                        </td>
                                        <td class="py-2 px-2 text-center">
                                            <input type="text" value="0"
                                                class="w-16 px-2 py-1 border rounded bg-gray-50 border border-gray-300 text-gray-900"
                                                :name="'kemasan[' + item + '][satuan_per_dus]'" min="0" value=""
                                                required>
                                        </td>
                                        <td class="py-2 px-2">
                                            <input type="text" value="0"
                                                class="px-2 w-16 py-1 border rounded bg-gray-50 border border-gray-300 text-gray-900"
                                                :name="'kemasan[' + item + '][satuan_per_kotak]'" min="0" value=""
                                                required>
                                        </td>
                                        <td>
                                            <input type="number" step="1000"
                                                class="w-24 px-2 py-1 border rounded bg-gray-50 border border-gray-300 text-gray-900"
                                                :name="'kemasan[' + item + '][harga]'" min="0" value="0" required>
                                        </td>
                                        <td class="text-right">
                                            <button type="button" x-on:click="hapusKemasan(item)"
                                                class="rounded-lg bg-red-100 text-red-500 hover:text-red-700 focus:outline-none text-sm px-2 py-1">Hapus</button>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            <template x-if="varian.length < 1">
                                <tr>
                                    <td class="text-center text-sm text-gray-400 py-4" colspan="4">Tidak ada kemasan
                                        ditambahkan.
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="mt-8">
                <button type="submit"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    document.addEventListener('alpine:init', () => {
        Alpine.data('data', () => ({
            data: {
                modal: false
            },
            varian: [0],
            tambahKemasan: function () {
                this.varian.push([this.varian.length]);                
            },
            hapusKemasan: function (index) {
                this.varian.splice(index, 1);
            }   
        }))
    })
</script>
@endsection