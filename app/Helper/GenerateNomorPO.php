<?php

namespace App\Helper;

use App\Models\PurchaseOrder;

class GenerateNomorPO
{
    public static function generate(?PurchaseOrder $latest = null): string
    {
        // format PO -> 012/WPM/PO.4/2024
        $latest = $latest ?? PurchaseOrder::whereYear('created_at', now()->year)->latest()->first();

        return "";
    }
}