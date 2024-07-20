<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexPengajuanPembelianRequest as IndexRequest;
use App\Http\Requests\StorePengajuanPembelianRequest;
use App\Models\Barang;
use App\Models\PengajuanPembelian;
use Illuminate\Http\Request;

class PengajuanPembelianController extends Controller
{
    public function index(IndexRequest $request)
    {
        $pengajuanPembelian = PengajuanPembelian::with('details')
            ->when($request->search, fn($query, $search) => $query->where('catatan', 'like', "%$search%"))
            ->when($request->status, fn($query, $status) => $query->where('status', $status))
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return view('admin-stock.pengajuan-pembelian.index', [
            'items' => $pengajuanPembelian->toArray(),
        ]);
    }

    public function create()
    {
        $barang = Barang::select(['id', 'nama'])->orderBy('nama')->get();

        return view('admin-stock.pengajuan-pembelian.create', ['barang' => $barang->toArray()]);
    }

    public function store(StorePengajuanPembelianRequest $request)
    {
        $pengajuanPembelian = PengajuanPembelian::create([
            'catatan' => $request->catatan,
            'created_by' => auth()->id(),
        ]);

        $pengajuanPembelian->details()->createMany($request->barang);

        return redirect()->route('admin-stock.pengajuan-pembelian.index');
    }

    public function show(PengajuanPembelian $pengajuanPembelian)
    {
        $pengajuanPembelian->load('details.barang');

        return view('admin-stock.pengajuan-pembelian.show', [
            'data' => $pengajuanPembelian->toArray()
        ]);
    }
}
