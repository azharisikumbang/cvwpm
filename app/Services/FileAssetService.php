<?php

namespace App\Services;

use App\Models\Gudang;

class FileAssetService
{
    public static function findFileLaporanPersediaan(
        Gudang $gudang,
        int $year,
        int $month
    ): false|string {
        return "";
    }
}
