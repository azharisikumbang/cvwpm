@extends('app')

@section('title', 'Riwayat PO')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-stock.index') => 'Panel Admin Stock',
route('admin-stock.purchase-order.index') => 'Riwayat PO',
'#' => 'Riwayat Penerimaan Barang Masuk',
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
        <a href="{{ route('admin-stock.purchase-order.edit', $item['id']) }}"
            class="w-full text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:bg-blue-700">Catat
            Penerimaan Barang</a>
    </div>
    @endif

    <div class="w-full">
        <table class="w-full mb-4">
            <tr class="border-b">
                <td style="width: 200px" class="py-2">
                    Nomor PO
                </td>
                <td>
                    : {{ $item['nomor'] }}
                </td>
            </tr>
            <tr class="border-b">
                <td class="py-2">
                    Tanggal PO
                </td>
                <td>
                    : {{ $item['tanggal'] }}
                </td>
            </tr>
            <tr class="border-b">
                <td style="width: 200px" class="py-2">
                    Status PO
                </td>
                <td>
                    : <span
                        class="px-2 py-1 text-sm rounded bg-{{ $item['is_done'] ? 'green' : 'yellow' }}-500 text-white">{{
                        $item['is_done'] ? 'Lunas' :
                        'Ongoing' }}</span>
                </td>
            </tr>
        </table>

        <div>
            <div class="font-semibold text-lg pb-2">Riwayat Barang Masuk PO</div>

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

        <div class="mt-8">
            <div class="pb-2 border-b-2 mb-4">
                <div class="font-semibold text-lg">Riwayat Penerimaan Barang</div>
                <p>Jumlah Penerimaan: {{ count($item['delivery_orders']) }} kali</p>
            </div>

            @foreach ($item['delivery_orders'] as $deliveryOrder)
            <table class="w-full mb-4 mt-4">
                <tr class="border-b">
                    <td style="width: 200px" class="py-2">
                        Nomor DO
                    </td>
                    <td>
                        : {{ $deliveryOrder['nomor'] }}
                    </td>
                </tr>
                <tr>
                    <td class="py-2">
                        Tanggal Penerimaan
                    </td>
                    <td>
                        : {{ $deliveryOrder['tanggal_penerimaan'] }}
                    </td>
                </tr>
            </table>

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
                    @forelse ($deliveryOrder['riwayat_stok'] as $stok)
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
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection