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
                        <input
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
                            <option value="kg">
                            <option value="gr">
                            <option value="ml">
                            <option value="liter">
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
                        <tbody id="tbody-wrapper">
                            <template x-if="varian.length > 0">
                                <template x-for="item in varian">
                                    <tr class="border-b">
                                        <td class="py-2 px-2">
                                            <label for="">Kemasan</label>
                                            <input type="text"
                                                class="px-2 py-1 border rounded bg-gray-50 border border-gray-300 text-gray-900"
                                                :name="'kemasan[' + item + '][varian]'" min="0" value="" required>
                                        </td>
                                        <td>
                                            <label for="">Harga</label>
                                            <input type="number"
                                                class="px-2 py-1 border rounded bg-gray-50 border border-gray-300 text-gray-900"
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
            varian: [],
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