<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class LaporanKartuStokController extends Controller
{
    public function show()
    {
        $pdf = PDF::loadView('laporan.kartu-stok');

        return $pdf->stream();
    }
}
