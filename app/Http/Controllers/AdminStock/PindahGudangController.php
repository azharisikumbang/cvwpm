<?php

namespace App\Http\Controllers\AdminStock;

use App\Http\Controllers\Controller;
use App\Models\Gudang;
use App\Models\PindahGudang;
use Illuminate\Http\Request;

class PindahGudangController extends Controller
{
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
        $items = Gudang::with('penanggungJawab')->whereNot('id', auth()->user()->gudangKerja()->first()->id)->get();

        return view('admin-stock.pindah-gudang.create', [
            'listGudangTujuan' => $items->toArray(),
            'barang' => auth()->user()->gudangKerja()->first()->barang()->get()->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        // $item = PindahGudang::make([

        // ]);

        $item = collect([
            'id' => 1,
            'gudang_id' => 1,
            'tanggal_pemindahan' => '2024/07/26',
            'tanggal_penyelesaian' => '2024/07/27',
            'nomor' => 'PG/001',
            'jenis_pindah_gudang' => 'KELUAR',
            'status' => 'PENDING',
            'jumlah_kotak' => 0,
            'jumlah_dus' => 80,
            'gudang_asal' => [
                'id' => 1,
                'nama' => 'Gudang Padang',
                'lokasi' => 'Padang',
                'penanggung_jawab' => [
                    'id' => 1,
                    'nama' => 'Azhari',
                    'kontak' => '081234567890',
                    'jabatan' => 'Admin Stock'
                ]
            ],
            'gudang_tujuan' => [
                'id' => 2,
                'nama' => 'Gudang Solok',
                'lokasi' => 'Solok',
                'penanggung_jawab' => null
            ],
            'riwayat_stok' => [
                [
                    'barang_id' => 1,
                    'jumlah_dus' => 50,
                    'jumlah_kotak' => 0,
                    'jumlah_satuan' => 0,
                    'satuan' => 'kotak',
                    'keterangan' => 'Gudang Padang',
                    'barang' => [
                        'nama' => 'Kol Giga F1',
                        'kemasan' => '15gr',
                        'harga' => 1000,
                    ],
                ],
                [
                    'barang_id' => 1,
                    'jumlah_dus' => 30,
                    'jumlah_kotak' => 0,
                    'jumlah_satuan' => 0,
                    'keterangan' => 'Gudang Padang',
                    'satuan' => 'kotak',
                    'barang' => [
                        'nama' => 'Kol Giga F1',
                        'kemasan' => '10gr',
                        'harga' => 1000,
                    ],
                ]
            ],

        ]);

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
