<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Kartu Stok</title>
    <style>
        #content th,
        #content td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td style="height: 120px; width: 120px; background:rgba(115, 112, 112, 0.349)">
                <div>
                    <img src="" alt="Logo WPM">
                </div>
            </td>
            <td>
                <h1>KARTU STOK BARANG</h1>
            </td>
        </tr>
    </table>

    <hr>

    <table>
        <tr>
            <td style="width: 120px">Gudang</td>
            <td> : {{ $item['gudang']['nama'] }} ({{ $item['gudang']['kode_gudang'] }})</td>
        </tr>
        <tr>
            <td>Nama Barang</td>
            <td> : {{ $item['barang']['nama_kemasan'] }}</td>
        </tr>
    </table>

    <hr>

    <table style="width: 100%; border-collapse: collapse" border="2" id="content">
        <thead>
            <tr style="background: #cacaca">
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Masuk (pcs)</th>
                <th>Keluar (pcs)</th>
                <th>Sisa (pcs)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($item['riwayat_stok'] as $riwayat)
            <tr>
                <td>{{ $riwayat['tanggal'] }}</td>
                <td>{{ $riwayat['keterangan'] }}</td>
                <td>{{ format_ribuan($riwayat['masuk']) }}</td>
                <td>{{ format_ribuan($riwayat['keluar']) }}</td>
                <td>{{ format_ribuan($riwayat['sisa']) }}</td>
            </tr>

            @empty
            <tr>
                <td colspan="5" style="text-align:center">Tidak ada data.</td>
            </tr>
            @endforelse

        </tbody>
        <tfoot>
            <tr style='font-weight: 600'>
                <td colspan="2">
                    Total
                </td>
                <td>{{ format_ribuan($item['total_masuk']) }}</td>
                <td>{{ format_ribuan($item['total_keluar']) }}</td>
                <td>{{ format_ribuan($item['total_sisa']) }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>