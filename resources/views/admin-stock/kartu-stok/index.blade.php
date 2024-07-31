@extends('app')

@section('title', 'Cek Kartu Stok')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-web.index') => 'Panel Admin Stok',
route('admin-stock.kartu-stok.index') => 'Kartu Stok',
'#' => 'Cek Kartu Stok',
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
        <form method="get" action="{{ route('admin-stock.kartu-stok.show') }}" class="w-full">
            <div class="flex justify-between w-full gap-8">
                <div class="w-1/3 space-y-4 md:space-y-6 ">
                    <div>
                        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">Nama Barang </label>
                        <select
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                            name="barang" required>
                            <option value selected disabled>-- pilih barang --</option>
                            @foreach ($items as $barang)
                            <option value="{{ $barang['id'] }}">{{ $barang['nama_kemasan'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">Tanggal Awal</label>
                        <input type="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                            name="awal" required>
                    </div>

                    <div>
                        <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">Tanggal Akhir <small
                                class="text-sm text-gray-500">(kosongkan untuk tanggal hari ini)</small></label>
                        <input type="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
                            name="akhir">
                    </div>
                </div>
            </div>
            <div class="mt-8">
                <button type="submit"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Cek
                    Kartu Stok</button>
            </div>
        </form>
    </div>
</div>
@endsection