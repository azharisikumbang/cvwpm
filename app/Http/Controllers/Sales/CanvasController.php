<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\RiwayatStok;
use App\Models\SalesCanvas;
use Illuminate\Http\Request;

class CanvasController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        $items = SalesCanvas::where('sales_id', auth()->user()->staf->id)->latest()->paginate(10);

        return view('sales.canvas.index', [
            'items' => $items->toArray()
        ]);
    }

    public function show(SalesCanvas $canvas)
    {
        $canvas->load('riwayatStok.barang');
        $penjualan = collect([
            [
                'nomor' => '202407260001',
                'nama_toko' => 'Toko Serba Ada',
                'alamat_toko' => 'Jl. Raya Serba Ada No. 1',
                'kontak_toko' => '081234567890',
                'tanggal_transaksi' => '2024-07-26',
                'riwayat_stok' => [
                    [
                        'id' => 1,
                        'barang_id' => 1,
                        'jumlah_dus' => 0,
                        'jumlah_kotak' => 2,
                        'jumlah_satuan' => 0,
                        'keterangan' => '',
                        'stokable_id' => 1,
                        'stokable_type' => 'App\Models\Penjualan',
                        'barang' => [
                            'id' => 1,
                            'nama' => 'Kol Giga F1',
                            'kemasan' => '15gr',
                            'harga_satuan' => 10000,
                            'jumlah_dus' => 0,
                            'jumlah_kotak' => 10,
                            'jumlah_satuan' => 0,
                        ]
                    ],
                    [
                        'id' => 1,
                        'barang_id' => 1,
                        'jumlah_dus' => 0,
                        'jumlah_kotak' => 2,
                        'jumlah_satuan' => 0,
                        'keterangan' => '',
                        'stokable_id' => 1,
                        'stokable_type' => 'App\Models\Penjualan',
                        'barang' => [
                            'id' => 1,
                            'nama' => 'Kol Giga F1',
                            'kemasan' => '10gr',
                            'harga_satuan' => 10000,
                            'jumlah_dus' => 0,
                            'jumlah_kotak' => 10,
                            'jumlah_satuan' => 0,
                        ]
                    ],
                    [
                        'id' => 1,
                        'barang_id' => 1,
                        'jumlah_dus' => 3,
                        'jumlah_kotak' => 0,
                        'jumlah_satuan' => 0,
                        'keterangan' => '',
                        'stokable_id' => 1,
                        'stokable_type' => 'App\Models\Penjualan',
                        'barang' => [
                            'id' => 1,
                            'nama' => 'Oyong Anggun Tavi 75s',
                            'kemasan' => '10gr',
                            'harga_satuan' => 10000,
                            'jumlah_dus' => 0,
                            'jumlah_kotak' => 10,
                            'jumlah_satuan' => 0,
                        ]
                    ]
                ]
            ],
        ]); // TODO: change this

        return view('sales.canvas.show', [
            'item' => $canvas->toArray(),
            'penjualan' => $penjualan->toArray()
        ]);
    }
}
