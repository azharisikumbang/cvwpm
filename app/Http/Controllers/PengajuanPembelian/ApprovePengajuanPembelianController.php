<?php

namespace App\Http\Controllers\PengajuanPembelian;

use App\Http\Controllers\Controller;
use App\Models\PengajuanPembelian;
use Illuminate\Support\Facades\Gate;

class ApprovePengajuanPembelianController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        PengajuanPembelian $pengajuanPembelian
    ) {
        Gate::authorize('update', $pengajuanPembelian);

        $pengajuanPembelian->approve();

        return redirect()
            ->route('pengajuan-pembelian.index')
            ->with('success', 'Pengajuan pembelian berhasil disetujui')
        ;
    }
}
