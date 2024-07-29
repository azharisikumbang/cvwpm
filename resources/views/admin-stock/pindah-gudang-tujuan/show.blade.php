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

    @if(is_null($item['tanggal_penyelesaian']))
    <div class="my-4" x-data="{ modal: false }">
        <a href="{{ route('admin-stock.pindah-gudang-tujuan.edit', $item['id']) }}"
            class="text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-blue-700">Catat
            Penerimaan Manual</a>

        <button type="button" x-on:click="modal = true"
            class="text-white bg-green-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-green-700">Catat
            Penerimaan Otomatis</button>

        <div x-show="modal" style="display: none">
            <div class="fixed inset-0 flex items-center justify-center">
                <div class="bg-white rounded-lg p-6 z-50 max-w-lg">
                    <div>
                        <h2 class="text-lg font-semibold">Apakah anda yakin bahwa barang pindah gudang yang diterima
                            sudah sesuai ?
                        </h2>
                        <p class="text-sm text-gray-400">Barang diterima akan menambah stok yang ada secara otomatis
                            atau
                            membuat data barang baru jika belum tersedia.</p>
                    </div>

                    <form action="{{ route('admin-stock.pindah-gudang-tujuan.store', $item['id']) }}" method="post">
                        @csrf
                        <div class="flex gap-2 mt-8">
                            <button type="submit"
                                class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Yakin
                                dan Teruskan</button>
                            <button type="button" x-on:click="modal = false"
                                class="h-10 rounded-lg bg-gray-100 text-gray-500 hover:text-gray-700 focus:outline-none text-sm px-5 py-2.5">Kembali</button>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-500 bg-opacity-50 fixed inset-0"></div>
            </div>
        </div>
    </div>
    @endif

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
                        <th style="text-align: left">Nama Barang PO</th>
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