<?php

namespace App\Services;

use App\Http\Requests\CreatePurchaseOrderRequest;
use App\Models\PengajuanPembelian;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetails;
use Illuminate\Support\Facades\DB;

class PurchaseOrderService
{
    public function createFromPermintaanPembelian(
        PengajuanPembelian $pengajuanPembelian,
        CreatePurchaseOrderRequest $request
    ): false|PurchaseOrder {
        // jika jumlah dus dan kotak sama sama nol dari satu barang, maka kembaliak error
        $validated = $request->validated();
        foreach ($validated['barang'] as $barang)
        {
            if ($this->jumlahDusDanKotakDibawahSatu($barang['jumlah_dus'], $barang['jumlah_kotak']))
                return false;
        }

        // jika nilai jumlah berubah dari yang diajukan, maka rubah status pengajuan pembelian menjadi revised

        // save
        // TODO: buat ke transaction
        $purchaseOrder = PurchaseOrder::create([
            'nomor' => $this->generateNomorPO(),
            'tanggal' => date('Y-m-d'),
            'status' => PurchaseOrder::STATUS_PENDING,
            'staf_id' => auth()->id(),
            'supplier' => $validated['supplier']
        ]);

        $purchaseOrder->details()->saveMany(
            array_map(function ($barang) {
                return new PurchaseOrderDetails([
                    'barang_id' => $barang['id'],
                    'jumlah_dus' => $barang['jumlah_dus'],
                    'jumlah_kotak' => $barang['jumlah_kotak']
                ]);
            }, $validated['barang'])
        );

        $pengajuanPembelian->setAttribute('status', PengajuanPembelian::STATUS_APPROVED)->save();

        // TODO: save as PDF

        return $purchaseOrder;
    }

    private function generateNomorPO(): string
    {
        // example : 001/WPM/PO.4/2024 ==> {urut}/WPM/PO.{bulan}/{tahun}
        $latest = PurchaseOrder::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->latest()->first();

        if (null === $latest)
            return $this->formatPO();

        $nomorUrut = explode("/", $latest->nomor)[0];
        $nomorUrut++;

        return $this->formatPO($nomorUrut);
    }

    private function formatPO(int $urut = 1): string
    {
        // format {urut}/WPM/PO.{bulan}/{tahun}
        return sprintf("%s/WPM/PO.%s/%s", str_pad($urut, 3, "0", STR_PAD_LEFT), date('n'), date('Y'));
    }

    protected function jumlahDusDanKotakDibawahSatu(int $dus, int $kotak): bool
    {
        return $dus < 1 && $kotak < 1;
    }
}
