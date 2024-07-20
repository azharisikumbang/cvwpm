<?php

namespace App\Http\Controllers\AdminPurchasing;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexPengajuanPembelianRequest;
use App\Models\PengajuanPembelian;
use Illuminate\Http\Request;

class PengajuanPembelianController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(IndexPengajuanPembelianRequest $request)
    {
        $pengajuanPembelian = PengajuanPembelian::with('details')
            ->when($request->search, fn($query, $search) => $query->where('catatan', 'like', "%$search%"))
            ->when($request->status, fn($query, $status) => $query->where('status', $status))
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return view('admin-purchasing.pengajuan-pembelian.index', [
            'items' => $pengajuanPembelian->toArray(),
        ]);
    }

    public function show(PengajuanPembelian $pengajuanPembelian)
    {
        $pengajuanPembelian->load('details.barang', 'user');

        return view('admin-purchasing.pengajuan-pembelian.show', [
            'data' => $pengajuanPembelian->toArray()
        ]);
    }
}
