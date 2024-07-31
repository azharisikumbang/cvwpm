@extends('app')

@section('title', 'Riwayat Sales Canvas')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-stock.index') => 'Panel Admin Stock',
route('admin-stock.sales-canvas.index') => 'Sales Canvas',
'#' => 'Detail Canvas',
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

    @if(false === $item['is_done'])
    <div class="my-8">
        <a href="{{ route('sales.penjualan.index') }}"
            class="w-full text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-blue-700">Catat
            Penjualan</a>
    </div>
    @endif

    <div class="w-full">
        <table class="w-full mb-4 border-b border-t py-2">
            <tr>
                <td style="width: 200px" class="py-2">
                    Nomor Surat Jalan
                </td>
                <td>
                    : {{ $item['nomor_surat_jalan'] }}
                    (<a class="text-red-500 hover:underline" href="{{ route('sales.canvas.download', $item['id']) }}"
                        class="text-blue-500" target="_blank">download pdf</a>)
                </td>
            </tr>
            <tr>
                <td class="py-2">
                    Tanggal Mulai
                </td>
                <td>
                    : {{ date('d/m/Y', strtotime($item['tanggal_mulai'])) }}
                </td>
            </tr>
            <tr>
                <td class="py-2">
                    Tanggal Selesai
                </td>
                <td>
                    : {{ is_null($item['tanggal_selesai']) ? 'Berlangsung' : date('d/m/Y',
                    strtotime($item['tanggal_selesai'])) . ' (Selesai)' }}
                </td>
            </tr>
            <tr>
                <td class="py-2">
                    Wilayah
                </td>
                <td>
                    : {{ $item['wilayah'] }}
                </td>
            </tr>
        </table>

        <div>
            <div class="font-semibold text-lg pb-2">Barang Muatan Canvas</div>

            <table class="table-content">
                <thead>
                    <tr>
                        <th style="width: 64px">No</th>
                        <th style="text-align: left">Nama Barang</th>
                        <th>Jumlah Dus</th>
                        <th>Jumlah Kotak</th>
                        <th>Jumlah Satuan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($item['riwayat_stok'] as $stok)
                    <tr>
                        <td style="text-align: center">{{ $loop->index + 1 }}</td>
                        <td style="text-align: left">{{ $stok['barang']['nama_kemasan'] }}</td>
                        <td style="text-align: center">{{ $stok['jumlah_dus'] }}</td>
                        <td style="text-align: center">{{ $stok['jumlah_kotak'] }}</td>
                        <td style="text-align: center">{{ $stok['jumlah_satuan'] }}</td>
                        <td style="text-align: center">{{ $stok['keterangan'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="6">Tidak ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <div class="mt-8">
            <div class="font-semibold text-lg pb-2">Riwayat Penjualan</div>

            <table class="table-content">
                <thead>
                    <tr>
                        <th style="width: 64px">No</th>
                        <th style="text-align: left">Tanggal</th>
                        <th style="text-align: left">Toko</th>
                        <th style="text-align: left">Nama Barang</th>
                        <th>Jumlah Dus</th>
                        <th>Jumlah Kotak</th>
                        <th>Jumlah Satuan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($item['penjualan'] as $penjualan)
                    @foreach ($penjualan['riwayat_stok'] as $stok)
                    <tr>
                        <td style="text-align: center">{{ $loop->index + 1 }}</td>
                        <td style="text-align: left">{{ date('d/m/Y', strtotime($penjualan['tanggal_transaksi'])) }}
                        </td>
                        <td>{{ $penjualan['nama_toko'] }}</td>
                        <td>{{ $stok['barang']['nama_kemasan'] }}</td>
                        <td style="text-align: center">{{ $stok['jumlah_dus'] }}</td>
                        <td style="text-align: center">{{ $stok['jumlah_kotak'] }}</td>
                        <td style="text-align: center">{{ $stok['jumlah_satuan'] }}</td>
                        <td style="text-align: center">{{ $stok['keterangan'] }}</td>
                    </tr>
                    @endforeach
                    @empty
                    <tr>
                        <td class="text-center" colspan="6">Tidak ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection