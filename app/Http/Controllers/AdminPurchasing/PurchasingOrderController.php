<?php

namespace App\Http\Controllers\AdminPurchasing;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePurchaseOrderRequest;
use App\Models\PengajuanPembelian;
use App\Models\PurchaseOrder;
use App\Services\PurchaseOrderService;
use Illuminate\Http\Request;

class PurchasingOrderController extends Controller
{
    public function index()
    {
        $purchaseOrder = PurchaseOrder::latest()->paginate(10);

        return view('admin-purchasing.purchasing-orders.index', [
            'items' => $purchaseOrder->toArray()
        ]);
    }

    public function create(PengajuanPembelian $pengajuanPembelian)
    {
        $pengajuanPembelian->load('details.barang');

        return view('admin-purchasing.purchasing-orders.create', [
            'data' => $pengajuanPembelian->toArray()
        ]);
    }

    public function store(
        PengajuanPembelian $pengajuanPembelian,
        CreatePurchaseOrderRequest $request,
        PurchaseOrderService $service
    ) {
        $created = $service->createFromPermintaanPembelian($pengajuanPembelian, $request);

        if (false === $created)
            return back()->withErrors('Gagal mengajukan PO, silahkan coba kembali');

        return redirect()
            ->route('admin-purchasing.purchasing-orders.index')
            ->with('success', 'Pengajuan PO Berhasil, silahkan unduh dokumen PO untuk melihat lebih lanjut.')
        ;
    }
}
