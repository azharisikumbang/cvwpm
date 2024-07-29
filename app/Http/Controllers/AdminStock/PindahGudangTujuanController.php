<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Models\PindahGudang;
use Illuminate\Http\Request;

class PindahGudangTujuanController extends Controller
{
    public function index()
    {
        $items = PindahGudang::with('gudangAsal')->where('gudang_tujuan_id', auth()->user()->staf->gudangKerja->id)->latest()->paginate(10);

        return view('admin-stock.pindah-gudang-tujuan.index', [
            'items' => $items->toArray()
        ]);
    }
}
