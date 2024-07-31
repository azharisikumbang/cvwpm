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

        return PDF::loadView('laporan.kartu-stok', [
            'item' => $item,
        ])->setPaper('a4')->stream();
    }
}
