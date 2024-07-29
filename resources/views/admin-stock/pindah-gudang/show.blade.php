@extends('app')

@section('title', 'Riwayat Pindah Gudang')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-purchasing.index') => 'Panel Admin Purchasing',
'#' => 'Riwayat Pindah Gudang',
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
        <table class="w-full mb-4 border-t border-b py-4">
            <tr>
                <td style="width: 320px" class="py-2">
                    Nomor Pindah Gudang / Surat Jalan
                </td>
                <td>
                    : {{ $item['nomor_surat_jalan'] }}
                    (<a href="{{ route('admin-stock.pindah-gudang.download', $item['id']) }}"
                        class="text-red-500 hover:underline" target="_blank">download</a>)
                </td>
            </tr>
            <tr>
                <td class="py-2">
                    Tanggal Mulai Pemindahan
                </td>
                <td>
                    : {{ date('d/m/Y', strtotime($item['tanggal_pemindahan'])) }}
                </td>
            </tr>
            <tr>
                <td class="py-2">
                    Tanggal Penerimaan di Tujuan
                </td>
                <td>
                    : {{ is_null($item['tanggal_penyelesaian']) ? 'Sedang Berlangsung' : date('d/m/Y',
                    strtotime($item['tanggal_penyelesaian'])) . ' (Selesai)' }}
                </td>
            </tr>
            <tr>
                <td style="width: 320px" class="py-2">
                    Rute Pemindahan
                </td>
                <td>
                    : {{ $item['gudang_asal']['nama'] }} - {{ $item['gudang_tujuan']['nama'] }}
                </td>
            </tr>

            <tr>
                <td style="width: 320px" class="py-2">
                    PIC Tujuan
                </td>
                <td>
                    : {{ $item['gudang_tujuan']['pic'] }}
                </td>
            </tr>
        </table>

        <div>
            <div class="font-semibold text-lg pb-2">Daftar Barang dipindahkan</div>

            <table class="table-content">
                <thead>
                    <tr>
                        <th style="width: 64px">No</th>
                        <th style="text-align: left">Nama Barang</th>
                        <th>Kemasan</th>
                        <th>Dus</th>
                        <th>Kotak</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($item['riwayat_stok'] as $stok)
                    <tr>
                        <td style="text-align: center">{{ $loop->index + 1 }}</td>
                        <td style="text-align: left">{{ $stok['barang']['nama'] }}</td>
                        <td style="text-align: center">{{ $stok['barang']['kemasan'] }}</td>
                        <td style="text-align: center">{{ $stok['jumlah_dus'] }}</td>
                        <td style="text-align: center">{{ $stok['jumlah_kotak'] }}</td>
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
            <div class="pb-2 border-b-2 mb-4">
                <div class="font-semibold text-lg">Riwayat Penerimaan Barang di Tujuan</div>
                <p>Jumlah Penerimaan: {{ count($item['penerimaan']) }} kali</p>
            </div>

            @foreach ($item['penerimaan'] as $barangMasuk)
            <table class="table-content">
                <thead>
                    <tr>
                        <th style="width: 64px">No</th>
                        <th style="text-align: left">Tanggal</th>
                        <th style="text-align: left">Nama Barang</th>
                        <th>Kemasan</th>
                        <th>Dus</th>
                        <th>Kotak</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangMasuk['riwayat_stok'] as $stok)
                    <tr>
                        <td style="text-align: center">{{ $loop->index + 1 }}</td>
                        <td style="text-align: left">{{ date('d/m/Y', strtotime($item['tanggal_penyelesaian']))
                            }}</td>
                        <td style="text-align: left">{{ $stok['barang']['nama'] }}</td>
                        <td style="text-align: center">{{ $stok['barang']['kemasan'] }}</td>
                        <td style="text-align: center">{{ $stok['jumlah_dus'] }}</td>
                        <td style="text-align: center">{{ $stok['jumlah_kotak'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="6">Tidak ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection