<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::when(request('search'), fn($query) => $query->where('nama', 'like', '%' . request('search') . '%'))
            ->when(request('page'), fn($query) => $query->offset((request('page') - 1) * 10))
            ->orderBy('nama')->paginate(request('per_page', 10));

        return view('admin-stock.barang.index', ['barang' => $barang->toArray()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listSatuan = Barang::select('satuan')->distinct()->get()->pluck('satuan');

        return view('admin-stock.barang.create', ['listSatuan' => $listSatuan->toArray()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBarangRequest $request)
    {
        Barang::create($request->validated());

        return redirect()
            ->route('admin-stock.barang.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        $listSatuan = Barang::select('satuan')->distinct()->get()->pluck('satuan');

        return view('admin-stock.barang.edit', [
            'barang' => $barang->toArray(),
            'listSatuan' => $listSatuan->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $barang->update($request->validated());

        return redirect()
            ->route('admin-stock.barang.index')
            ->with('success', "Barang '{$barang->nama}' berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        // delete only if there is no relation

        // delete only if role ADMIN_STOK
        

        $barang->delete();

        return redirect()
            ->route('admin-stock.barang.index')
            ->with('success', "Barang '{$barang->nama}' berhasil dihapus.");
    }
}
