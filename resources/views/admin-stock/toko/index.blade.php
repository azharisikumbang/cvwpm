@extends('app')

@section('title', 'Data Master Toko')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-stock.index') => 'Panel Admin Stok',
'#' => 'Data Master Toko',
]])
@endsection

@section('content')
<div>
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-600 md:text-2xl mb-2">
        @yield('title')
    </h1>

    @session('success')
    <div class="w-full">
        <x-alert color="green" :message="$value" />
    </div>
    @endsession

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
                <a href="{{ route('admin-stock.toko.index') }}"
                    class="ml-2 w-full h-10 mt-1 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-red-700">Reset</a>
                @endif
            </div>
            <div>
                <a href="{{ route('admin-stock.toko.create') }}"
                    class="w-full text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-blue-700">Tambah
                    Data Toko</a>
            </div>
        </div>
        <table class="table-content">
            <thead>
                <tr>
                    <th style="width: 64px">No</th>
                    <th style="text-align: left">Nama Toko</th>
                    <th style="text-align: left">Alamat</th>
                    <th style="width: 220px">CP</th>
                    <th style="width: 220px">UP</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items['data'] as $item)
                <tr>
                    <td style="text-align: center">{{ $loop->index + 1 }}</td>
                    <td style="text-align: left; font-weight: 600; text-decoration: uppercase">{{ $item['nama'] }}</td>
                    <td style="text-align: left">{{ $item['alamat'] }}</td>
                    <td style="text-align: center">{{ $item['cp'] ?? '-' }}</td>
                    <td style="text-align: center">{{ $item['up'] ?? '-' }}</td>
                    <td>
                        <div class="flex justify-end gap-4">
                            <a href="{{ route('admin-stock.toko.edit', $item['id']) }}"
                                class="hover:underline text-blue-600 hover:text-blue-700 focus:outline-none">Ubah
                                Data</a>

                            <div x-data="{ openModal: false }">
                                <button x-on:click="openModal = true"
                                    class="hover:underline text-red-600 hover:text-red-700 focus:outline-none">Hapus</button>

                                <!-- Modal -->
                                <div x-show="openModal" style="display: none">

                                    <div class="fixed inset-0 flex items-center justify-center">
                                        <div class="bg-white rounded-lg p-6 w-auto  z-50">
                                            <h2 class="text-lg font-semibold mb-4">Mohon Konfirmasi</h2>
                                            <p>Mengkonfirmasi penghapusan akan menghapus data selamanya. <br>Apakah anda
                                                yakin ingin menghapus data ini?</p>
                                            <div class="mt-6 flex justify-end">
                                                <button x-on:click="openModal = false"
                                                    class="h-10 text-gray-500 hover:text-gray-700 focus:outline-none text-sm px-5 py-2.5">Batalkan</button>

                                                <form method="POST"
                                                    action="{{ route('admin-stock.toko.destroy', $item['id']) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-red-700 bg-red-500 text-white">Hapus
                                                        Sekarang</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="bg-gray-500 bg-opacity-50 fixed inset-0"></div>
                                    </div>
                                </div>
                            </div>
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

        @if($items['total'] > 0)
        <div class="flex mt-4 justify-end">
            <!-- Previous Button -->
            <a href="{{ $items['prev_page_url'] }}"
                class="flex items-center justify-center px-4 h-10 me-3 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700">
                <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 5H1m0 0 4 4M1 5l4-4" />
                </svg>
                Halaman Sebelumnya
            </a>
            <a href="{{ $items['next_page_url'] }}"
                class="flex items-center justify-center px-4 h-10 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 -700">
                Halaman Selanjutnya
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@section('script')

@endsection