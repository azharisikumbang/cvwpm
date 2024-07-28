<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\RiwayatStok;
use App\Models\SalesCanvas;
use Illuminate\Http\Request;

class CanvasController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        $items = SalesCanvas::where('sales_id', auth()->user()->staf->id)->latest()->paginate(10);

        return view('sales.canvas.index', [
            'items' => $items->toArray()
        ]);
    }

    public function show(SalesCanvas $canvas)
    {
        $canvas->load('riwayatStok.barang', 'penjualan.riwayatStok.barang');

        return view('sales.canvas.show', [
            'item' => $canvas->toArray(),
        ]);
    }
}
