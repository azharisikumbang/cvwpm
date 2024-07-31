<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Models\PindahGudang;
use Illuminate\Http\Request;

class DownloadSuratPindahGudangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(PindahGudang $pindahGudang)
    {
        abort_if(
            $pindahGudang->surat_jalan_file === null
            || !file_exists(storage_path('app/public/surat-jalan-pindah-gudang/' . $pindahGudang->surat_jalan_file)),
            404
        );

        return response()->file(
            storage_path("app/public/surat-jalan-pindah-gudang/{$pindahGudang->surat_jalan_file}")
        );
    }
}
