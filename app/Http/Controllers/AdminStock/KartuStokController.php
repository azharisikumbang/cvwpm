<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexLaporanKartuStokRequest;
use App\Http\Requests\ShowKartuStokRequest;
use App\Models\Barang;
use App\Services\KartuStokService;
use PDF;

class KartuStokController extends Controller
{
    public function index(IndexLaporanKartuStokRequest $request)
    {
        $items = Barang::query()
            ->where('gudang_id', auth()->user()->staf->gudangKerja->id)
            ->orderBy('nama')
            ->get();


        return view('admin-stock.kartu-stok.index', [
            'items' => $items->toArray(),
        ]);
    }

    public function show(
        ShowKartuStokRequest $request,
        KartuStokService $service
    ) {
        /** @var array $item */
        $item = $service->createFromRequest($request);
        $periode = sprintf(
            '%s s/d %s',
            format_tanggal_indonesia(date('d-m-Y', strtotime($request->get('awal')))),
            format_tanggal_indonesia($request->get('akhir') ? date('d-m-Y', strtotime($request->get('akhir'))) : now()->format('d-m-Y'))
        ); // TODO: pindah ke dalam service

        return PDF::loadView('laporan.kartu-stok', [
            'item' => $item,
            'periode' => $periode,
        ])->setPaper('a4')->stream();
    }
}
