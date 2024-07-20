@extends('app')

@section('title', 'Riwayat Pengajuan Pembelian')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-stock.index') => 'Panel Admin Stok',
route('admin-stock.pengajuan-pembelian.index') => 'Riwayat Pengajuan Pembelian',
"#" => 'Detail Barang',
]])
@endsection

@section('content')
<div>
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-600 md:text-2xl mb-2">
        @yield('title')
    </h1>

    <div class="w-full mt-4">
        <div class="flex justify-between w-full gap-8">
            <div class="w-1/3 space-y-4 md:space-y-6 ">
                <div>
                    <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">
                        Tanggal Pengajuan</label>
                    <div>
                        {{ $data['tanggal_pengajuan'] }}
                    </div>
                </div>

                <div>
                    <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">Status Pengajuan</label>
                    <div class="">
                        <span
                            class="bg-{{ $data['status_color'] }}-200 text-{{ $data['status_color'] }}-800 text-xs font-medium px-2.5 py-0.5 rounded">
                            {{ $data['status_label'] }}
                        </span>
                    </div>
                </div>

                <div>
                    <label class=" block mb-2 text-sm font-medium text-gray-900" for="name">Catatan</label>
                    <div class="">
                        {{ $data['catatan'] }}
                    </div>
                </div>


            </div>
            <div class="w-2/3">
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
                        <tr class="border-b">
                            <td style="text-align: center">{{ $loop->index + 1 }}</td>
                            <td class="w-96 py-4">{{
                                $item['barang']['nama'] }}
                            </td>
                            <td style="text-align: center">{{ $item['jumlah_dus'] }}</td>
                            <td style="text-align: center">{{ $item['jumlah_kotak'] }}</td>
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
    </div>
</div>
@endsection

@section('script')

@endsection