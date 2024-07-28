<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class LaporanFakturPenjualanCanvasController extends Controller
{
    public function show()
    {
        // $penjualan = [
        //     'nomor' => '20240726001',
        //     'tanggal_transaksi' => '2024-06-27',
        //     'nama_toko' => 'Regina Tani',
        //     'alamat_toko' => 'Pariaman',
        //     'total' => 0,
        //     'riwayat_stok' => [
        //         [
        //             'barang_id' => 1,
        //             'jumlah_dus' => 0,
        //             'jumlah_kotak' => 2,
        //             'jumlah_satuan' => 0,
        //             'satuan' => 'kotak',
        //             'keterangan' => 'Penjualan',
        //             'barang' => [
        //                 'nama' => 'Kol Giga F1',
        //                 'kemasan' => '15gr',
        //                 'harga' => 1000,
        //             ],
        //         ],
        //         [
        //             'barang_id' => 1,
        //             'jumlah_dus' => 0,
        //             'jumlah_kotak' => 2,
        //             'jumlah_satuan' => 0,
        //             'keterangan' => 'Penjualan',
        //             'satuan' => 'kotak',
        //             'barang' => [
        //                 'nama' => 'Kol Giga F1',
        //                 'kemasan' => '10gr',
        //                 'harga' => 1000,
        //             ],
        //         ],
        //         [
        //             'barang_id' => 1,
        //             'jumlah_dus' => 3,
        //             'jumlah_kotak' => 0,
        //             'jumlah_satuan' => 0,
        //             'satuan' => 'dus',
        //             'keterangan' => 'Penjualan',
        //             'barang' => [
        //                 'nama' => 'Oyong Anggun CS',
        //                 'kemasan' => '75s',
        //                 'harga' => 1000,
        //             ],
        //         ],
        //         [
        //             'barang_id' => 1,
        //             'jumlah_dus' => 0,
        //             'jumlah_kotak' => 3,
        //             'jumlah_satuan' => 0,
        //             'satuan' => 'kotak',
        //             'keterangan' => 'Penjualan',
        //             'barang' => [
        //                 'nama' => 'Oyong Anggun Tavi',
        //                 'kemasan' => '75s',
        //                 'harga' => 1000,
        //             ],
        //         ],
        //         [
        //             'barang_id' => 1,
        //             'jumlah_dus' => 0,
        //             'jumlah_kotak' => 3,
        //             'jumlah_satuan' => 0,
        //             'keterangan' => 'Penjualan',
        //             'satuan' => 'dus',
        //             'barang' => [
        //                 'nama' => 'Kubis PM 48',
        //                 'kemasan' => '15gr',
        //                 'harga' => 1000,
        //             ],
        //         ]
        //     ],
        // ];

        // $pdf = PDF::loadView('laporan.faktur-penjualan-canvas', [
        //     'penjualan' => $penjualan
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
                    'jumlah_dus' => 2,
                    'jumlah_kotak' => 5,
                    'jumlah_satuan' => 0,
                    'satuan' => 'kotak',
                    'keterangan' => 'Penjualan',
                    'barang' => [
                        'nama' => 'Kol Giga F1',
                        'kemasan' => '15gr',
                        'harga' => 1000,
                    ],
                ],
                [
                    'barang_id' => 1,
                    'jumlah_dus' => 13,
                    'jumlah_kotak' => 14,
                    'jumlah_satuan' => 0,
                    'keterangan' => 'Penjualan',
                    'satuan' => 'kotak',
                    'barang' => [
                        'nama' => 'Kol Giga F1',
                        'kemasan' => '10gr',
                        'harga' => 1000,
                    ],
                ],
                [
                    'barang_id' => 1,
                    'jumlah_dus' => 10,
                    'jumlah_kotak' => 0,
                    'jumlah_satuan' => 0,
                    'satuan' => 'dus',
                    'keterangan' => 'Penjualan',
                    'barang' => [
                        'nama' => 'Oyong Anggun CS',
                        'kemasan' => '75s',
                        'harga' => 1000,
                    ],
                ],
                [
                    'barang_id' => 1,
                    'jumlah_dus' => 6,
                    'jumlah_kotak' => 6,
                    'jumlah_satuan' => 0,
                    'satuan' => 'kotak',
                    'keterangan' => 'Penjualan',
                    'barang' => [
                        'nama' => 'Oyong Anggun Tavi',
                        'kemasan' => '75s',
                        'harga' => 1000,
                    ],
                ],
                [
                    'barang_id' => 1,
                    'jumlah_dus' => 11,
                    'jumlah_kotak' => 14,
                    'jumlah_satuan' => 0,
                    'keterangan' => 'Penjualan',
                    'satuan' => 'dus',
                    'barang' => [
                        'nama' => 'Kubis PM 48',
                        'kemasan' => '15gr',
                        'harga' => 1000,
                    ],
                ]
            ],

        ]);

        $pdf = PDF::loadView('laporan.surat-jalan-pindah-gudang', [
            'item' => $item->toArray()
        ]);

        return $pdf->stream();
    }
}
