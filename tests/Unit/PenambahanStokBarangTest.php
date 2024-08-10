<?php

namespace Tests\Unit;

use App\Models\Barang;
use App\Services\BarangService;
use PHPUnit\Framework\TestCase;

class PenambahanStokBarangTest extends TestCase
{

    public function testPenambahanStokBarang()
    {
        $barang = $this->getMockBuilder(Barang::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['save'])
            ->getMock();

        $barang->expects($this->once())
            ->method('save')
            ->willReturn(true);

        $barang->jumlah_dus = 10;
        $barang->jumlah_kotak = 10;
        $barang->jumlah_satuan = 10;

        $barangService = new BarangService();
        $updatedBarang = $barangService->tambahStokBarang($barang, 5, 10, 15);

        $this->assertEquals(15, $updatedBarang->jumlah_dus);
        $this->assertEquals(20, $updatedBarang->jumlah_kotak);
        $this->assertEquals(25, $updatedBarang->jumlah_satuan);
    }

    public function testPenguranganStokBarang()
    {
        $barang = $this->getMockBuilder(Barang::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['save'])
            ->getMock();

        $barang->expects($this->once())
            ->method('save')
            ->willReturn(true);

        $barang->jumlah_dus = 10;
        $barang->jumlah_kotak = 10;
        $barang->jumlah_satuan = 10;

        $barangService = new BarangService();
        $updatedBarang = $barangService->kurangiStok($barang, 5, 10, 2);

        $this->assertEquals(5, $updatedBarang->jumlah_dus);
        $this->assertEquals(0, $updatedBarang->jumlah_kotak);
        $this->assertEquals(8, $updatedBarang->jumlah_satuan);
    }
}
