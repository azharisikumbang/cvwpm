@extends('app')

@section('title', 'Formulir Pengajuan Pembelian Baru')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-stock.index') => 'Panel Admin Stok',
route('admin-stock.pengajuan-pembelian.index') => 'Riwayat Pengajuan Pembelian',
'#' => 'Buat Pengajuan Pembelian Baru',
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
        <form method="POST" action="{{ route('admin-stock.pengajuan-pembelian.store') }}" class="w-full">
            @csrf

            <div class="flex justify-between w-full gap-8">
                <div class="w-1/3 space-y-4 md:space-y-6 ">
                    <div>
                        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                            Tanggal Pengajuan</label>
                        <input
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                            type="text" value="{{ date('d/m/Y') }} (hari ini)" disabled>
                    </div>

                    <div>
                        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">Catatan <span
                                class="text-sm text-gray-500">(opsional)</span></label>
                        <textarea rows="5"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                            name="catatan"></textarea>
                    </div>
                </div>
                <div class="w-2/3">
                    <div class="flex justify-between items-center pb-2 border-b">
                        <div class="block text-sm font-medium text-gray-900">
                            List barang diajukan (total: <span x-text="barang_dipilih.length"></span> item)
                        </div>
                        <div>
                            <button type="button" x-on:click="data.modal = true"
                                class="bg-green-500 text-white text-sm w-full px-2 py-2 rounded focus:outline-none hover:bg-green-700">Tambah
                                Barang</button>
                        </div>
                    </div>
                    <table class="w-full">
                        <tbody>
                            <template x-if="barang_dipilih.length > 0">
                                <template x-for="item in barang_dipilih" :key="item.id">
                                    <tr class="border-b">
                                        <td x-text="item.nama" class="w-96 py-4"></td>
                                        <td>
                                            <input type="hidden" :name="'barang[' + item.id + '][barang_id]'"
                                                :value="item.id">
                                            <input type="number" class="px-2 py-1 w-16 border rounded"
                                                :name="'barang[' + item.id + '][jumlah_dus]'" min="0" value="0"
                                                required>
                                            dus
                                        </td>
                                        <td>
                                            <input type="number" class="px-2 py-1 w-16 border rounded"
                                                :name="'barang[' + item.id + '][jumlah_kotak]'" min="0" value="0"
                                                required>
                                            kotak
                                        </td>
                                        <td class="text-right">
                                            <button type="button" x-on:click="hapusBarang(item)"
                                                class="rounded-lg bg-red-100 text-red-500 hover:text-red-700 focus:outline-none text-sm px-2 py-1">Hapus</button>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            <template x-if="barang_dipilih.length < 1">
                                <tr>
                                    <td class="text-center text-sm text-gray-400 py-4" colspan="4">Tidak ada barang
                                        dipilih.
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <div>
                        <!-- Modal -->
                        <div x-show="data.modal" style="display: none">
                            <div class="fixed inset-0 flex items-center justify-center">
                                <div class="bg-white rounded-lg p-6 w-1/2 z-50">
                                    <div class="flex justify-between items-center mb-4">
                                        <div>
                                            <h2 class="text-lg font-semibold">Daftar Produk</h2>
                                            <p class="text-sm text-gray-400">Produk dipilih dapat dilihat pada
                                                tabel produk diajukan pembelian dan tidak tersedia lagi dilist
                                            </p>
                                        </div>

                                        <div class="flex justify-end gap-2">
                                            <button type="button" x-on:click="data.modal = false"
                                                class="h-10 rounded-lg bg-gray-100 text-gray-500 hover:text-gray-700 focus:outline-none text-sm px-5 py-2.5">Selesai</button>
                                        </div>
                                    </div>
                                    <div class="overflow-x-auto max-h-80">
                                        <table class="table-content">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: left">Nama Barang</th>
                                                    <th style="width: 64px">Pilih</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="item in barang" :key="item.id">
                                                    <tr>
                                                        <td x-text="item.nama"></td>
                                                        <td class="text-center">
                                                            <button type="button" x-on:click="pilihBarang(item)"
                                                                class="h-10 rounded-lg bg-blue-100 text-blue-500 hover:text-blue-700 focus:outline-none text-sm px-2 py-1">Pilih</button>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="bg-gray-500 bg-opacity-50 fixed inset-0"></div>
                            </div>
                        </div>
                    </div>
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
            barang: @json($barang),
            barang_dipilih: [],
            pilihBarang: function (barang) {
                // check if barang exists
                // push to barang_dipilih
                this.barang_dipilih.push(barang);

                // remove from barang
                const index = this.barang.indexOf(barang);
                this.barang.splice(index, 1);
                
            },
            hapusBarang: function (barang) {
                // check if barang exists
                // push to barang
                this.barang.push(barang);

                // remove from barang_dipilih
                const index = this.barang_dipilih.indexOf(barang);
                this.barang_dipilih.splice(index, 1);

            }
        }))
    })
</script>
@endsection