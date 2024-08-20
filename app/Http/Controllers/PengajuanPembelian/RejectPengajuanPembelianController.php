<?php

namespace App\Http\Controllers\PengajuanPembelian;

use App\Http\Controllers\Controller;
use App\Models\PengajuanPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RejectPengajuanPembelianController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        PengajuanPembelian $pengajuanPembelian
    ) {
        Gate::authorize('update', $pengajuanPembelian);

        $pengajuanPembelian->reject();

        return redirect()
            ->route('pengajuan-pembelian.index')
            ->with('success', 'Pengajuan pembelian berhasil disetujui')
        ;
    }
}
