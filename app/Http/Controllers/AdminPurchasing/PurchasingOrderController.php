<?php

namespace App\Http\Controllers\AdminPurchasing;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePurchaseOrderRequest;
use App\Models\Barang;
use App\Models\PengajuanPembelian;
use App\Models\PurchaseOrder;
use App\Services\PurchaseOrderService;
use Illuminate\Http\Request;

class PurchasingOrderController extends Controller
{
    public function index()
    {
        $purchaseOrder = PurchaseOrder::where('gudang_id', auth()->user()->gudangKerja()->id)->latest()->paginate(10);

        return view('admin-purchasing.purchasing-orders.index', [
            'items' => $purchaseOrder->toArray()
        ]);
    }

    public function create()
    {
        $barang = Barang::getModel()->getBarangGudang()->toArray();

        return view('admin-purchasing.purchasing-orders.create', [
            'barang' => $barang
        ]);
    }

    public function store(
        CreatePurchaseOrderRequest $request,
        PurchaseOrderService $purchaseOrderService
    ) {
        $purchaseOrderService->create(
            auth()->user()->gudangKerja(),
            $request
        );

        return redirect()
            ->route('admin-purchasing.purchase-orders.index')
            ->with('success', 'Berhasil membuat purchase order.');
        ;
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        return view('admin-purchasing.purchasing-orders.show', [
            'item' => $purchaseOrder->load('riwayatStok.barang')->toArray()
        ]);
    }
}
