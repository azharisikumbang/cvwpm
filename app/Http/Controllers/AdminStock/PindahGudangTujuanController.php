<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePindahGudangTujuanRequest;
use App\Http\Requests\UpdatePindahGudangTujuanRequest;
use App\Models\PindahGudang;
use App\Services\BarangMasukService;
use App\Services\BarangService;
use Illuminate\Http\Request;

class PindahGudangTujuanController extends Controller
{
    public function index()
    {
        $items = PindahGudang::with('gudangAsal')
            ->where('gudang_tujuan_id', auth()->user()->staf->gudangKerja->id)
            ->where('jenis_pindah_gudang', PindahGudang::PINDAH_KELUAR)
            ->latest()
            ->paginate(10);

        return view('admin-stock.pindah-gudang-tujuan.index', [
            'items' => $items->toArray()
        ]);
    }

    public function show(PindahGudang $pindahGudang)
    {
        $pindahGudang->load('gudangAsal', 'gudangTujuan', 'riwayatStok.barang', 'penerimaan.riwayatStok.barang');

        return view('admin-stock.pindah-gudang-tujuan.show', [
            'item' => $pindahGudang->toArray()
        ]);
    }

    public function store(
        StorePindahGudangTujuanRequest $request,
        PindahGudang $pindahGudang,
        BarangMasukService $barangMasukService,
        BarangService $barangService
    ) {
        $barangMasukService->catatBarangMasukPindahGudangOtomatis(
            $pindahGudang,
            $request,
            $barangService
        );

        return redirect()->route('admin-stock.pindah-gudang-tujuan.show', $pindahGudang);
    }

    public function update(
        UpdatePindahGudangTujuanRequest $request,
        PindahGudang $pindahGudang,
        BarangMasukService $barangMasukService
    ) {

    }
}
