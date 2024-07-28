<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Jalan Canvas</title>
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

    <div class="width: 100%; margin-bottom: 10px">
        <div>CV Wahana Prima Mandiri</div>
        <span>Jl. Khatib Sulaiman no. 47 Padang</span>
    </div>

    <br>

    <div style="width: 100%; margin-bottom: 10px">
        <div style="float: left; width: 50%">
            <table>
                <tr>
                    <td>Telp</td>
                    <td> : (0751)-xxxxx</td>
                </tr>
                <tr>
                    <td>Fax</td>
                    <td> : (0751)-xxxxx</td>
                </tr>
                <tr>
                    <td>CP</td>
                    <td> : </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Hari / Tanggal</td>
                    <td> : {{ format_tanggal_indonesia($canvas['tanggal_mulai']) }}</td>
                </tr>
                <tr>
                    <td>No Surat Jalan</td>
                    <td> : 2024/002</td>
                </tr>
            </table>
        </div>
        <div style="float: right; width: 50%">
            <table>
                <tr>
                    <td>Wilayah</td>
                    <td> : Solok, Tanah Datar, Bukittinggi</td>
                </tr>
                <tr>
                    <td>CP</td>
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
                <th>Quantity</th>
                <th>Terjual</th>
                <th>Sisa</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($canvas['riwayat_stok'] as $barang)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td> {{ $barang['barang']['nama'] . $barang['barang']['kemasan'] }} </td>
                <td>{{ $barang['total_pcs'] }}</td>
                <td></td>
                <td></td>
                <td>{{ $barang['keterangan'] ?? $barang['jumlah_text'] }}</td>
                @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <table width="100%" style="text-align:center; margin-top: 40px">
        <tr>
            <td>Padang, {{ format_tanggal_indonesia($canvas['tanggal_mulai']) }}</td>
            <td style="width: 240px;"></td>
            <td style="width: 200px;">Sales</td>
        </tr>
        <tr>
            <td></td>
            <td style="height: 96px"></td>
            <td></td>
        </tr>
        <tr>
            <td>Bobby Ardian Asli, SE</td>
            <td></td>
            <td>{{ $canvas['sales']['nama'] }}</td>
        </tr>
    </table>
</body>

</html>