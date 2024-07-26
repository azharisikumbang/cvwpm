@extends('app')

@section('title', 'Stok Barang')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-stock.index') => 'Panel Admin Stock',
'#' => 'Riwayat PO',
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
        <table class="table-content">
            <thead>
                <tr>
                    <th style="width: 64px">No</th>
                    <th style="text-align: left">Nomor PO</th>
                    <th>Tanggal PO</th>
                    <th>Total Barang</th>
                    <th>Total Dus</th>
                    <th>Total Kotak</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items['riwayat_stok'] as $item)
                <tr>
                    <td style="text-align: center">{{ $loop->index + 1 }}</td>
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