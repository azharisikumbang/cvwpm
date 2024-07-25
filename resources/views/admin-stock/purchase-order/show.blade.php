@extends('app')

@section('title', 'Riwayat PO')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-purchasing.index') => 'Panel Admin Purchasing',
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
        <div>
            <table class="w-full mb-4">
                <tr class="border-b">
                    <td style="width: 200px" class="py-2">
                        Nomor PO
                    </td>
                    <td>
                        : {{ $item['nomor'] }}
                    </td>
                </tr>
                <tr>
                    <td class="py-2">
                        Tanggal PO
                    </td>
                    <td>
                        : {{ $item['tanggal'] }}
                    </td>
                </tr>
            </table>
        </div>

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
            <tfoot class="font-semibold">
                <tr>
                    <td colspan="3">
                        Total
                    </td>
                    <td class="text-center">
                        {{ $item['jumlah_dus'] }} dus
                    </td>
                    <td class="text-center">
                        {{ $item['jumlah_kotak'] }} kotak
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

@section('script')

@endsection