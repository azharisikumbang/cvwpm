<?php

namespace App\Http\Controllers\PengajuanPembelian;

use App\Http\Controllers\Controller;
use App\Models\PengajuanPembelian;
use Illuminate\Http\Request;

class ApprovePengajuanPembelian extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        Request $request,
        PengajuanPembelian $pengajuanPembelian
    ) {
        $pengajuanPembelian->approve();

        return redirect()
            ->route('pengajuan-pembelian.index')
            ->with('success', 'Pengajuan pembelian berhasil disetujui')
        ;
    }
}
