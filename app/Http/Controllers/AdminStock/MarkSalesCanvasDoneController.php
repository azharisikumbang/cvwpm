<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Models\SalesCanvas;
use App\Services\BarangMasukService;
use Illuminate\Http\Request;

class MarkSalesCanvasDoneController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SalesCanvas $salesCanvas, BarangMasukService $barangMasukService)
    {
        if ($salesCanvas->is_done)
        {
            return redirect()
                ->route('admin-stock.sales-canvas.show', $salesCanvas)
                ->withErrors('Sales Canvas sudah selesai');
        }

        $barangMasukService->catatSisaCanvas($salesCanvas);

        return redirect()->route('admin-stock.sales-canvas.index');
    }
}
