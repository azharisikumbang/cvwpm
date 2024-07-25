@extends('app')

@section('title', 'Pencatatan Penerimaan Barang PO')

@section('breadcrumb')
@include('components.breadcrumb', ['links' => [
route('admin-purchasing.index') => 'Panel Admin Purchasing',
'#' => 'Pencatatan Penerimaan Barang PO',
]])
@endsection

@section('content')
<div>
    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-600 md:text-2xl mb-2">
        @yield('title')
    </h1>

    @if ($errors->any())
    <div class="sm:max-w-md w-full">
        @foreach ($errors->all() as $error)
        <x-alert color="yellow" :message="$error" />
        @endforeach
    </div>
    @endif

    <form action="{{ route('admin-stock.delivery-order.store', ['purchase_order' => $item['id']]) }}" method="post">
        @csrf

        <div class="w-full">
            <table class="w-full mb-4">
                <tr>
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
                <tr>
                    <td class="py-2">
                        Nomor DO
                    </td>
                    <td>
                        : <input type="text" name="nomor"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 w-96 p-2.5 "
                            required autofocus>
                    </td>
                </tr>
                <tr>
                    <td class="py-2">
                        Tanggal Penerimaan
                    </td>
                    <td>
                        : <input type="date" name="tanggal_penerimaan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 w-96 p-2.5 "
                            required>
                    </td>
                </tr>
            </table>

            <div>
                <div class="font-semibold text-lg pb-2">Daftar Barang Masuk</div>

                <table class="table-content">
                    <thead>
                        <tr>
                            <th style="width: 64px">No</th>
                            <th style="text-align: left">Nama Barang PO</th>
                            <th>Kemasan</th>
                            <th>Jumlah Dus</th>
                            <th>Jumlah Kotak</th>
                            <th>Jumlah Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($item['riwayat_stok'] as $stok)
                        <tr>
                            <td style="text-align: center">{{ $loop->index + 1 }}</td>
                            <td style="text-align: left">{{ $stok['barang']['nama'] }}</td>
                            <td style="text-align: center">{{ $stok['barang']['kemasan'] }}</td>
                            <td style="text-align: center">
                                <input type="hidden" name="barang[{{ $loop->index }}][id]" value="{{ $stok['id'] }}">
                                <input type="number" name="barang[{{ $loop->index }}][jumlah_dus]" min="0"
                                    max="{{ $stok['jumlah_dus'] }}" value="0" class="px-2 py-1 w-16 border rounded"
                                    required>
                            </td>
                            <td style="text-align: center">
                                <input type="number" name="barang[{{ $loop->index }}][jumlah_kotak]" min="0"
                                    max="{{ $stok['jumlah_kotak'] }}" value="0" class="px-2 py-1 w-16 border rounded"
                                    required>
                            </td>
                            <td style="text-align: center">
                                <input type="number" name="barang[{{ $loop->index }}][jumlah_satuan]" min="0" value="0"
                                    class="px-2 py-1 w-16 border rounded" required>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="6">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-8">
                    <button type="submit"
                        class="text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Catat
                        Penerimaan Barang</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')

@endsection