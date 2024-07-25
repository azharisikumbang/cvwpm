<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        return view('admin-stock.purchase-order.index', [
            'items' => PurchaseOrder::where('gudang_id', auth()->user()->gudangKerja()->id)
                ->latest()
                ->paginate(10)
                ->toArray()
        ]);
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        return view('admin-stock.purchase-order.show', [
            'item' => $purchaseOrder->load(['riwayatStok.barang', 'deliveryOrders.riwayatStok.barang'])->toArray()
        ]);
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        return view('admin-stock.purchase-order.edit', [
            'item' => $purchaseOrder->load('riwayatStok.barang')->toArray()
        ]);
    }
}
