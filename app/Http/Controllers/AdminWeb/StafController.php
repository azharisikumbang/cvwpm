<?php

namespace App\Http\Controllers\AdminWeb;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStafRequest;
use App\Models\Gudang;
use App\Models\Role;
use App\Models\Staf;
use App\Models\User;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Http\Request;

class StafController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin-web.staf.index', [
            'items' => Staf::paginate(10)->toArray()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-web.staf.create', [
            'listJabatan' => Role::whereNotIn('id', [Role::ID_MANAGER, Role::ID_ADMIN_WEB])->get()->toArray(),
            'listUser' => User::select('id', 'username')->whereNotIn('role_id', [Role::ID_MANAGER, Role::ID_ADMIN_WEB])->get()->toArray(),
            'listGudang' => Gudang::all()->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStafRequest $request)
    {
        Staf::create([...$request->validated(), 'jabatan' => Role::where('id', $request->jabatan)->first()->getDisplaybleName()]);

        return redirect()->route('admin-web.staf.index')->with('success', 'Staf berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staf $staf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staf $staf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staf $staf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staf $staf)
    {
        $staf->delete();

        return redirect()->route('admin-web.staf.index')->with('success', 'Staf berhasil dihapus');
    }
}
