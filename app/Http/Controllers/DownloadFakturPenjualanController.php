<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;

class DownloadFakturPenjualanController extends Controller
{
    public function __invoke(Penjualan $penjualan)
    {
        if (!$penjualan->file_faktur_penjualan)
        {
            return redirect()
                ->route('sales.penjualan.index')
                ->with('error', 'Faktur penjualan tidak ditemukan');
        }

        return response()->file($penjualan->getFileFakturPenjualanWithFullPath());
    }
}
