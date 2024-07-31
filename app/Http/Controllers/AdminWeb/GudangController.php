<?php

namespace App\Http\Controllers\AdminWeb;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGudangRequest;
use App\Models\Gudang;
use App\Models\Staf;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin-web.gudang.index', [
            'items' => Gudang::paginate(10)->toArray()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-web.gudang.create', [
            'listStaf' => Staf::whereNull('gudang_kerja')->get()->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGudangRequest $request)
    {
        Gudang::create($request->validated());

        return redirect()
            ->route('admin-web.gudang.index')
            ->with('success', 'Gudang berhasil ditambahkan')
        ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Gudang $gudang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gudang $gudang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gudang $gudang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gudang $gudang)
    {
        //
    }
}
