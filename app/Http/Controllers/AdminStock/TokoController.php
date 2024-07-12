<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTokoRequest;
use App\Http\Requests\UpdateTokoRequest;
use App\Models\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Toko::when(request('search'), fn($query) => $query->where('nama', 'like', '%' . request('search') . '%'))
            ->when(request('page'), fn($query) => $query->offset((request('page') - 1) * 10))
            ->orderBy('nama')->paginate(request('per_page', 10));

        return view('admin-stock.toko.index', [
            'items' => $items->toArray()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-stock.toko.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTokoRequest $request)
    {
        Toko::create($request->validated());

        return redirect()
            ->route('admin-stock.toko.index')
            ->with('success', 'Data toko berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Toko $toko)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Toko $toko)
    {
        return view('admin-stock.toko.edit', ['toko' => $toko->toArray()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTokoRequest $request, Toko $toko)
    {
        $toko->update($request->validated());

        return redirect()
            ->route('admin-stock.toko.index')
            ->with('success', 'Data toko berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toko $toko)
    {
        $toko->delete();

        return redirect()
            ->route('admin-stock.toko.index')
            ->with('success', 'Data toko berhasil dihapus.');
    }
}
