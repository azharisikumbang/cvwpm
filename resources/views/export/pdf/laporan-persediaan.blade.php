<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Persediaan</title>
    <style>
        #content th,
        #content td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    {{-- logo --}}
    <div style="height: 120px; width: 50%;">
        <img src="{{ public_path('storage/static/logo.png') }}" alt="Logo Perusahaan">
    </div>

    <hr>

    <table>
        <tr>
            <td style="width: 120px">Gudang</td>
            <td> : {{ $item['gudang']['nama'] }} / {{ $item['gudang']['kode_gudang'] }}</td>
        </tr>
        <tr>
            <td>Periode</td>
            <td> : {{ $item['periode'] }}</td>
        </tr>
    </table>

    <hr>

    <table style="width: 100%; border-collapse: collapse" border="2" id="content">
        <thead>
            <tr style="background: #cacaca">
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Quantity (pcs)</th>
                <th>Harga Satuan</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0 @endphp
            @forelse ($item['barang'] as $barang)
            @php
            $subTotal = $barang['harga'] * $barang['jumlah_satuan'];
            $total += $subTotal;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $barang['kode_barang'] }}</td>
                <td>{{ $barang['nama_kemasan'] }}</td>
                <td>{{ $barang['jumlah_satuan'] }}</td>
                <td>{{ $barang['harga_rupiah'] }}</td>
                <td>Rp {{ number_format($subTotal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">Tidak ada data barang.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">Total</td>
                <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>