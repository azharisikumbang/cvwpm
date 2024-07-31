@extends('app')

@section('title', 'Riwayat Sales Canvas')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('sales.index') => 'Panel Sales',
route('sales.canvas.index') => 'Riwayat Canvas'
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
                <a href="{{ route('admin-stock.sales-canvas.index') }}"
                    class="ml-2 w-full h-10 mt-1 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-red-700">Reset</a>
                @endif
            </div>
        </div>
        <table class="table-content">
            <thead>
                <tr>
                    <th style="width: 64px">No</th>
                    <th>Nomor Surat Jalan</th>
                    <th style="text-align: left">Tanggal Sales</th>
                    <th>Wilayah</th>
                    <th>Status Canvas</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items['data'] as $item)
                <tr>
                    <td style="text-align: center">{{ $loop->index + 1 }}</td>
                    <td style="text-align: left">
                        <a class="text-blue-500 hover:underline"
                            href="{{ route('admin-stock.sales-canvas.download', $item['id']) }}" class="text-blue-500"
                            target="_blank">{{ $item['nomor_surat_jalan'] }}</a>
                    </td>
                    <td style="text-align: center">{{ date('d/m/Y', strtotime($item['tanggal_mulai'])) }}</td>
                    <td style="text-align: center">{{ $item['wilayah'] }}</td>
                    <td style="text-align: center">{{ is_null($item['tanggal_selesai']) ? 'Berlangsung' : 'Selesai' }}
                    </td>
                    <td style="text-align: center">
                        <a href="{{ route('sales.canvas.show', $item['id']) }}"
                            class="text-blue-500 hover:underline">Lihat Detail</a>
                        @if (false === $item['is_done'])|
                        <a href="{{ route('sales.penjualan.index', $item['id']) }}"
                            class="text-blue-500 hover:underline">Catat Penjualan</a>
                        @endif
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
            @if($items['prev_page_url'])
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
            @endif
            @if ($items['next_page_url'])
            <a href="{{ $items['next_page_url'] }}"
                class="flex items-center justify-center px-4 h-10 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 -700">
                Halaman Selanjutnya
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection

@section('script')

@endsection