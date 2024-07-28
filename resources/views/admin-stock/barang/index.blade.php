@extends('app')

@section('title', 'Data Master Barang')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-stock.index') => 'Panel Admin Stok',
route('admin-stock.barang.index') => 'Data Master Barang',
]])
@endsection

@section('content')
<div>
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-600 md:text-2xl mb-2">
        @yield('title')
    </h1>

    @include('components.flash-message')

    <div class="w-full">
        <div class="flex justify-between items-center w-full mb-4">
            <div class="flex inline-flex">
                <form method="GET" action="">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative mt-1">
                        <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="table-search" name="search"
                            class="block py-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-96 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Cari berdasarkan nama dan tekan enter.." value="{{ $_GET['search'] ?? '' }}">
                    </div>
                </form>
                @if(isset($_GET['search']))
                <a href="{{ route('admin-stock.barang.index') }}"
                    class="ml-2 w-full h-10 mt-1 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-red-700">Reset</a>
                @endif
            </div>
            <div>
                <a href="{{ route('admin-stock.barang.create') }}"
                    class="w-full text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-blue-700">Tambah
                    Data Barang</a>
            </div>
        </div>
        <table class="table-content">
            <thead>
                <tr>
                    <th style="width: 64px">No</th>
                    <th style="text-align: left">Kode Barang</th>
                    <th style="text-align: left">Nama Barang</th>
                    <th>Stok Gudang</th>
                    <th>Harga Satuan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barang['data'] as $item)
                <tr>
                    <td style="text-align: center">{{ $loop->index + 1 }}</td>
                    <td style="text-align: left">{{ $item['kode_barang'] }}</td>
                    <td style="text-align: left; font-weight: 600; text-decoration: uppercase">{{ $item['nama_kemasan']
                        }}</td>
                    <td style="text-align: center">{{ $item['jumlah_text'] }}</td>
                    <td style="text-align: center">{{ $item['harga_rupiah'] }}</td>
                    <td>
                        <div class="flex justify-end gap-4">
                            <a href="{{ route('admin-stock.barang.edit', $item['id']) }}"
                                class="hover:underline text-blue-600 hover:text-blue-700 focus:outline-none">Tambah
                                Kemasan Baru</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="6">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @include('components.table-footer-navigation', [
        'total' => $barang['total'],
        'prev_page_url' => $barang['prev_page_url'],
        'next_page_url' => $barang['next_page_url'],
        ])
    </div>
</div>
@endsection

@section('script')

@endsection