<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePindahGudangRequest;
use App\Models\Gudang;
use App\Models\PindahGudang;
use App\Services\BarangService;
use App\Services\PencatatanBarangKeluarService;
use Illuminate\Http\Request;

class PindahGudangController extends Controller
{
    public function __construct(
        protected BarangService $barangService,
        protected PencatatanBarangKeluarService $pencatatanBarangKeluarService
    ) {
        # code...
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = PindahGudang::with('gudangTujuan')
            ->where('gudang_asal_id', auth()->user()->staf->gudangKerja->id)
            ->where('jenis_pindah_gudang', PindahGudang::PINDAH_KELUAR)
            ->latest()
            ->paginate(10);

        return view('admin-stock.pindah-gudang.index', [
            'items' => $items->toArray()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gudangKerja = auth()->user()->staf->gudangKerja;
        $items = Gudang::with('penanggungJawab')->whereNot('id', $gudangKerja->id)->get();

        return view('admin-stock.pindah-gudang.create', [
            'listGudangTujuan' => $items->toArray(),
            'barang' => $gudangKerja->barang()->where('jumlah_satuan', '>', 0)->get()->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StorePindahGudangRequest $request,
    ) {
        $gudangAsal = auth()->user()->staf->gudangKerja;

        $pindahGudang = $this->pencatatanBarangKeluarService->catatBarangKeluarPindahGudang(
            $gudangAsal,
            $request,
            $this->barangService
        );

        if (!$pindahGudang)
            return redirect()->back()->withErrors('Gagal membuat surat jalan pindah gudang');

        $this->pencatatanBarangKeluarService->simpanSuratJalanPindahGudang($pindahGudang);

        return redirect()->route('admin-stock.pindah-gudang.show', $pindahGudang->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(PindahGudang $pindahGudang)
    {
        abort_if(
            $pindahGudang->gudang_asal_id !== auth()->user()->staf->gudangKerja->id,
            403,
        );

        $item = $pindahGudang->load('gudangAsal', 'gudangTujuan', 'riwayatStok.barang', 'penerimaan.riwayatStok.barang');

        return view('admin-stock.pindah-gudang.show', [
            'item' => $item->toArray()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PindahGudang $pindahGudang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PindahGudang $pindahGudang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PindahGudang $pindahGudang)
    {
        //
    }
}
