<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use PDF;

class LaporanFakturPenjualanCanvasController extends Controller
{
    public function show(Penjualan $penjualan)
    {
        $penjualan->load('riwayatStok.barang', 'salesCanvas.sales');

        $pdf = PDF::loadView('export.pdf.faktur-penjualan', [
            'penjualan' => $penjualan->toArray()
        ]);

        return $pdf->stream();
    }
}
