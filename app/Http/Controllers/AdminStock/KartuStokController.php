<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexLaporanKartuStokRequest;
use App\Models\Barang;
use App\Models\DeliveryOrder;
use App\Models\RiwayatStok;
use Illuminate\Http\Request;

class KartuStokController extends Controller
{
    public function index(IndexLaporanKartuStokRequest $request)
    {
        // $items = RiwayatStok::query()
        //     ->with('barang')
        //     ->whereRelation('barang', function ($barang) {
        //         return $barang->where('gudang_id', auth()->user()->gudangKerja()->id);
        //     })
        //     ->when($request->has('barang'), function ($query) use ($request) {
        //         $query->where('stok_id', $request->barang);
        //     })
        //     ->paginate();

        $items = Barang::query()
            ->with('riwayatStok', function ($relation) {
                return $relation->whereIn('stokable_type', [DeliveryOrder::class]);
            })
            ->where('gudang_id', auth()->user()->staf->gudangKerja->id)
            ->when($request->has('barang'), function ($query) use ($request) {
                $query->where('id', $request->barang);
            })
            ->get();


        return view('admin-stock.kartu-stok.index', [
            'items' => $items->toArray(),
        ]);
    }

    public function create()
    {
        return view('admin-stock.kartu-stok.create', [
            'listBarang' => Barang::query()
                ->select('id', 'nama', 'kemasan')
                ->where('gudang_id', auth()->user()->staf->gudangKerja->id)
                ->orderBy('nama')
                ->get()
                ->toArray(),
        ]);
    }
}
