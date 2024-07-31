<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Jalan Pindah Gudang</title>
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
                    <td> : {{ format_tanggal_indonesia($item['tanggal_pemindahan']) }}</td>
                </tr>
                <tr>
                    <td>No Surat Jalan</td>
                    <td> : {{ $item['nomor_surat_jalan'] }}</td>
                </tr>
            </table>
        </div>
        <div style="float: right; width: 50%">
            <table>
                <tr>
                    <td>Gudang Asal</td>
                    <td> : {{ $item['gudang_asal']['nama'] }}</td>
                </tr>
                <tr>
                    <td>Gudang Tujuan</td>
                    <td> : {{ $item['gudang_tujuan']['nama'] }}</td>
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
                <th>Jumlah Barang</th>
                <th>Quantity (Pcs)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($item['riwayat_stok'] as $barang)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td> {{ $barang['barang']['nama_kemasan'] }} </td>
                <td>{{ $barang['jumlah_text'] }}</td>
                <td>{{ $barang['total_pcs'] }}</td>
                <td>{{ $barang['keterangan'] }}</td>
                @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <table width="100%" style="text-align:center; margin-top: 40px">
        <tr>
            <td>{{ $item['gudang_asal']['lokasi'] }}, {{ format_tanggal_indonesia($item['tanggal_pemindahan']) }}</td>
            <td style="width: 240px;"></td>
            <td style="width: 200px;">Penerima</td>
        </tr>
        <tr>
            <td></td>
            <td style="height: 96px"></td>
            <td></td>
        </tr>
        <tr>
            <td>Pengirim</td>
            <td></td>
            <td>{{ $item['gudang_tujuan']['nama'] }}</td>
        </tr>
    </table>
</body>

</html>