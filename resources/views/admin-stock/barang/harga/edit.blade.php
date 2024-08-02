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
        <form method="POST" action="{{ route('admin-stock.barang.harga.update', $barang['id']) }}" class="w-full">
            @csrf
            @method('PUT')

            <div class="flex p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Perhatian:</span>
                    <span>Harga barang yang dirubah akan menjadi perhitungan ketika pembuatan faktur penjualan.</span>
                </div>
            </div>

            <div class="flex justify-between w-full gap-8">
                <div class="w-1/3 space-y-4 md:space-y-6 ">
                    <div>
                        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">Nama Barang </label>
                        <input
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                            type="text" value="{{ $barang['nama_kemasan'] }}" disabled>
                    </div>

                    <div>
                        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">Harga Sebelumnya (Rp)
                        </label>
                        <input
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                            type="number" value="{{ $barang['harga'] }}" disabled>
                    </div>

                    <div>
                        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">Harga Baru (Rp)
                        </label>
                        <input name="harga"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                            type="number" value="0" min="0" step="1000">
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