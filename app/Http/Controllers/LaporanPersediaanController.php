<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLaporanPersediaanRequest;
use App\Services\LaporanPersediaanService;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPersediaanController extends Controller
{
    public function __construct(
        protected LaporanPersediaanService $laporanPersediaanService
    ) {
    }

    public function create()
    {
        $listGudang = $this->laporanPersediaanService->getListGudang();

        return view('laporan-persediaan.create', [
            'listGudang' => $listGudang,
        ]);
    }

    public function show(
        CreateLaporanPersediaanRequest $request
    ) {

        // TODO temporary solution for memory limit, please refactor the code
        ini_set('memory_limit', '512M');
        $data = $this->laporanPersediaanService->createFromRequest($request);

        return Pdf::loadView('export.pdf.laporan-persediaan', [
            'item' => $data,
        ])
            ->setPaper('a4', 'landscape')
            ->stream('laporan-persediaan.pdf');
    }
}
