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
    public function __invoke(DownloadSuratJalanRequest $request, SalesCanvas $canvas)
    {
        abort_if(
            $canvas->surat_jalan_file === null
            || !file_exists($canvas->getSuratJalanFileWithFulPath()),
            404
        );

        return response()->file($canvas->getSuratJalanFileWithFulPath());
    }
}
