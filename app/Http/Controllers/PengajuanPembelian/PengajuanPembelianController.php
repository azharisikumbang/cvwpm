<?php

namespace App\Http\Controllers\PengajuanPembelian;

use App\DTOs\PengajuanPembelianDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengajuanPembelianRequest;
use App\Models\PengajuanPembelian;
use App\Services\PengajuanPembelianService;
use Illuminate\Http\Request;

class PengajuanPembelianController extends Controller
{
    public function __construct(
        protected readonly PengajuanPembelianService $pengajuanPembelianService
    ) {
        # code...
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePengajuanPembelianRequest $request)
    {
        $this->pengajuanPembelianService->simpan($request->toDTO());

        return redirect()
            ->route('pengajuan-pembelian.index')
            ->with('success', 'Pengajuan pembelian berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PengajuanPembelian $pengajuanPembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanPembelian $pengajuanPembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengajuanPembelian $pengajuanPembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanPembelian $pengajuanPembelian)
    {
        //
    }
}
