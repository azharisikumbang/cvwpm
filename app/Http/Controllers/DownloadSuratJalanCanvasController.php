<?php

namespace App\Http\Controllers;

use App\Http\Requests\DownloadSuratJalanRequest;
use App\Models\SalesCanvas;
use Illuminate\Http\Request;
use PDF;

class DownloadSuratJalanCanvasController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(DownloadSuratJalanRequest $request, SalesCanvas $salesCanvas)
    {
        abort_if(
            $salesCanvas->surat_jalan_file === null
            || !file_exists(storage_path('app/public/surat-jalan-canvas/' . $salesCanvas->surat_jalan_file)),
            404
        );

        return response()->file(storage_path('app/public/surat-jalan-canvas/' . $salesCanvas->surat_jalan_file));
    }
}
