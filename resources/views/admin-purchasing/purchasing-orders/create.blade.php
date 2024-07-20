@extends('app')

@section('title', 'Pengajuan PO')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-purchasing.index') => 'Panel Admin Purchasing',
"#" => 'Pengajuan PO',
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

    <div>
        <form method="POST"
            action="{{ route('admin-purchasing.purchasing-orders.store', ['pengajuanPembelian' => $data['id']]) }}">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-4 md:space-y-6">
                    <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50"
                        role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Informasi!</span> Tanggal dan Nomor PO akan dibuat secara otomatis
                            dan
                            dapat dilihat pada dokumen PO nantinya.
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 w-full">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="name">
                                Nomor PO</label>
                            <input
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                                type="text" name="tanggal" value="(dibuat otomatis)" disabled>
                        </div>
                        <div>
                            <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                                Tanggal PO</label>
                            <input
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                                type="text" name="tanggal" value="{{ date('m/d/Y') }} (hari ini)" disabled>
                        </div>
                    </div>

                    <div>
                        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                            Tujuan PO / Pemasok</label>
                        <input
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                            type="text" name="supplier" required autofocus>
                    </div>
                </div>

                <div>
                    <div class="px-4">
                        <div class="font-bold">
                            Barang Akan PO :
                        </div>
                        <span class="text-gray-600 text-sm italic">jumlah dapat diubah sesuai keperluan.</span>
                    </div>
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th style="width: 64px" class="py-4">No</th>
                                <th style="text-align: left">Nama Barang</th>
                                <th>Jumlah Dus</th>
                                <th>Jumlah Kotak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['details'] as $item)
                            <input type="hidden" name="barang[{{$item['id']}}][id]" value="{{ $item['id'] }}">
                            <tr class="border-b">
                                <td style="text-align: center">{{ $loop->index + 1 }}</td>
                                <td class="w-96 py-4">{{
                                    $item['barang']['nama'] }}
                                </td>
                                <td style="text-align: center">
                                    <input type="number" name="barang[{{$item['id']}}][jumlah_dus]"
                                        value="{{ $item['jumlah_dus'] }}" min="0"
                                        class="w-20 p-2.5 border border-gray-300 rounded-lg focus:ring-primary-600 focus:border-primary-600 block">
                                </td>
                                <td style="text-align: center">
                                    <input type="number" name="barang[{{$item['id']}}][jumlah_kotak]"
                                        value="{{ $item['jumlah_kotak'] }}" min="0"
                                        class="w-20 p-2.5 border border-gray-300 rounded-lg focus:ring-primary-600 focus:border-primary-600 block">
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center text-sm text-gray-400 py-4" colspan="6">Tidak ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="px-4 mt-4">
                        <strong>Total Barang: </strong>
                        <span>{{ count($data['details']) }} item</span>
                    </div>
                </div>
            </div>

            <div class="mt-8" x-data="{ modal: false }">
                <button type="button" x-on:click="modal = true"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Ajukan
                    PO</button>

                <div x-show="modal" style="display: none">
                    <div class="fixed inset-0 flex items-center justify-center">
                        <div class="bg-white rounded-lg p-6 z-50 max-w-lg">
                            <div>
                                <h2 class="text-lg font-semibold">Apakah anda yakin ingin mengajukan PO ?</h2>
                                <p class="text-sm text-gray-400">Mohon konfirmasi kembali data PO yang dibuat sebelum
                                    mengajukan PO. Pengajuan PO akan menghasilkan nomor PO dan dokumen PO yang tidak
                                    dapat diubah lagi.</p>
                            </div>

                            <div class="flex gap-2 mt-8">
                                <button type="submit"
                                    class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Ajukan
                                    PO Sekarang</button>
                                <button type="button" x-on:click="modal = false"
                                    class="h-10 rounded-lg bg-gray-100 text-gray-500 hover:text-gray-700 focus:outline-none text-sm px-5 py-2.5">Kembali</button>
                            </div>
                        </div>
                        <div class="bg-gray-500 bg-opacity-50 fixed inset-0"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')

@endsection