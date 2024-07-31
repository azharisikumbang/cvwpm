<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePenjualanCanvasRequest;
use App\Models\SalesCanvas;
use App\Services\PenjualanService;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {

        if (SalesCanvas::where('sales_id', auth()->user()->staf->id)->whereNull('tanggal_selesai')->count() == 0)
        {
            return redirect()
                ->route('sales.canvas.index')
                ->with('success', 'Tidak ada canvas yang sedang berlangsung');
        }

        $item = SalesCanvas::with('riwayatStok.barang')
            ->where('sales_id', auth()->user()->staf->id)
            ->whereNull('tanggal_selesai')
            ->latest()
            ->first();

        $listBarang = $item->riwayatStok->map(function ($riwayat) {
            return [
                'id' => $riwayat->barang_id,
                'nama' => $riwayat->barang->nama,
                'kemasan' => $riwayat->barang->kemasan,
                'jumlah_satuan' => $riwayat->jumlah_satuan,
                'jumlah_dus' => $riwayat->jumlah_dus,
                'jumlah_kotak' => $riwayat->jumlah_kotak,
                'harga_satuan' => $riwayat->barang->harga_rupiah,
                'gudang_id' => $riwayat->barang->gudang_id,
                'satuan' => $riwayat->barang->satuan,
                'nama_kemasan' => $riwayat->barang->nama_kemasan,
                'jumlah_text' => sprintf("%s dus, %s kotak, %s %s", $riwayat->jumlah_dus, $riwayat->jumlah_kotak, $riwayat->jumlah_satuan, $riwayat->barang->satuan),
            ];
        });

        return view('sales.penjualan.index', [
            'item' => $item->toArray(),
            'barang' => $listBarang
        ]);
    }

    public function store(
        StorePenjualanCanvasRequest $request,
        PenjualanService $penjualanService
    ) {
        $canvas = SalesCanvas::find($request->canvas);

        $penjualanService->catatSales(
            auth()->user()->staf,
            $canvas,
            $request
        );

        return redirect()->route('sales.canvas.show', $canvas->id);
    }
}
