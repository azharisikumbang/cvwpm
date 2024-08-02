<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur Penjualan</title>
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
    <div style="height: 120px; width: 50%; background: rgba(202, 202, 202, 0.349)">
        <img src="" alt="Logo WPM">
    </div>

    <hr>

    <div style="width: 100%; margin-bottom: 10px">
        <div style="float: left; width: 50%">
            <table>
                <tr>
                    <td>Nama</td>
                    <td> : {{ $penjualan['nama_toko'] }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td> : {{ $penjualan['alamat_toko'] }}</td>
                </tr>
                <tr>
                    <td>CP</td>
                    <td> : </td>
                </tr>
                <tr>
                    <td>UP</td>
                    <td> : </td>
                </tr>
            </table>
        </div>
        <div style="float: right; text-align:left; width: 50%">
            <table>
                <tr>
                    <td>No. Faktur</td>
                    <td> : {{ $penjualan['nomor'] }}</td>
                </tr>
                <tr>
                    <td>Tanggal Faktur</td>
                    <td> : {{ date('d/m/Y', strtotime($penjualan['tanggal_transaksi'])) }}</td>
                </tr>
                <tr>
                    <td>No. SO</td>
                    <td> : </td>
                </tr>
                <tr>
                    <td>Tanggal SO</td>
                    <td> : </td>
                </tr>
                <tr>
                    <td>Tanggal Jatuh Tempo</td>
                    <td> : </td>
                </tr>
            </table>
        </div>
        <div style="clear: both"></div>
    </div>

    <table style="width: 100%; border-collapse: collapse" border="2" id="content">
        <thead>
            <tr style="background: #cacaca">
                <th>No</th>
                <th>Nama Barang</th>
                <th>Item</th>
                <th>Quantity (pcs)</th>
                <th>Harga Satuan</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0 @endphp
            @foreach ($penjualan['riwayat_stok'] as $barang)
            @php $total += $barang['sub_total'] @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $barang['barang']['nama'] . ' ' . $barang['barang']['kemasan'] }}</td>
                <td>{{ $barang['jumlah_text'] }}</td>
                <td>{{ $barang['total_pcs'] }}</td>
                <td>Rp {{ number_format($barang['barang']['harga'], 0, ',', '.') }}</td>
                <td>Rp {{ number_format($barang['sub_total'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">Total</td>
                <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <table width="100%" style="text-align:center; margin-top: 40px">
        <tr>
            <td>Penerima</td>
            <td style="width: 260px;"></td>
            <td style="width: 200px;">Hormat Kami</td>
        </tr>
        <tr>
            <td style="height: 96px"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>{{ $penjualan['nama_toko'] }}</td>
            <td></td>
            <td>CV Wahana Prima Mandiri</td>
        </tr>
    </table>
</body>

</html>