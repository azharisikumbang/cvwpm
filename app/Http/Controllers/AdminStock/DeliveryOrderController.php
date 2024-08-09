<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeliveryOrderRequest;
use App\Models\PurchaseOrder;
use App\Services\BarangMasukService;
use App\Services\BarangService;
use Illuminate\Http\Request;

class DeliveryOrderController extends Controller
{
    public function store(
        StoreDeliveryOrderRequest $request,
        BarangMasukService $barangMasukService,
        PurchaseOrder $purchaseOrder,
        BarangService $barangService
    ) {
        $barangMasukService->simpanDeliveryOrder(
            $barangService,
            $purchaseOrder,
            $request->validated()
        );

        return redirect()
            ->route('admin-stock.purchase-order.show', [
                'purchase_order' => $purchaseOrder->id
            ])
            ->with('success', 'Delivery order berhasil disimpan');
    }
}
