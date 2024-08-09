<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalesCanvasRequest;
use App\Models\SalesCanvas;
use App\Services\BarangService;
use App\Services\PencatatanBarangKeluarService;
use Illuminate\Http\Request;

class SalesCanvasController extends Controller
{
    public function __construct(
        protected PencatatanBarangKeluarService $pencatatanBarangKeluarService,
        protected BarangService $barangService
    ) {
        # code...
    }

    public function index()
    {
        $items = SalesCanvas::with('sales', 'riwayatStok', 'penjualan')->whereRelation('sales', function ($relation) {
            return $relation->where('gudang_kerja', auth()->user()->gudangKerja()->id);
        })->paginate(10);

        return view('admin-stock.sales-canvas.index', [
            'items' => $items->toArray()
        ]);
    }

    public function create()
    {
        $gudang = auth()->user()->gudangKerja();

        return view('admin-stock.sales-canvas.create', [
            'barang' => $gudang->barang()->orderBy('nama')->get()->toArray(),
            'sales' => $gudang->sales()->get()->toArray()
        ]);
    }

    public function store(
        StoreSalesCanvasRequest $request
    ) {

        $canvas = $this->pencatatanBarangKeluarService->catatBarangKeluarSales($request, $this->barangService);
        if (!$canvas)
        {
            return redirect()
                ->route('admin-stock.sales-canvas.create')
                ->with('error', 'Pencatatan barang keluar gagal disimpan.')
            ;
        }

        $this->pencatatanBarangKeluarService->buatSuratJalanCanvas($canvas);

        return redirect()
            ->route('admin-stock.sales-canvas.show', $canvas->id)
            ->with('success', 'Pencatatan barang keluar berhasil disimpan.')
        ;
    }

    public function show(SalesCanvas $salesCanvas)
    {
        $salesCanvas->load('riwayatStok.barang', 'sales', 'penjualan.riwayatStok.barang')->toArray();

        return view('admin-stock.sales-canvas.show', [
            'item' => $salesCanvas->toArray()
        ]);
    }
}
