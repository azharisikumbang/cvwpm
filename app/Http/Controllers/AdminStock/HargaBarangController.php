<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateHargaBarangRequest;
use App\Models\Barang;
use Illuminate\Http\Request;

class HargaBarangController extends Controller
{
    public function edit(Barang $barang)
    {
        return view('admin-stock.barang.harga.edit', compact('barang'));
    }

    public function update(UpdateHargaBarangRequest $request, Barang $barang)
    {
        $barang->update([
            'harga' => $request->harga
        ]);

        return redirect()
            ->route('admin-stock.barang.index')
            ->with('success', "Harga barang '{$barang->nama_kemasan}' berhasil diubah.")
        ;
    }
}
