<?php

namespace Tests\Unit;

use App\Models\PengajuanPembelian;
use App\Services\PengajuanPembelianService;
use Tests\TestCase;

class PengajuanPembelianServiceTest extends TestCase
{
    public function test_cari_berdasarkan_nomor_pengajuan()
    {
        $this->markTestIncomplete('Belum diimplementasikan');

        // arrange
        $service = new PengajuanPembelianService();

        $model = $this->getMockBuilder(PengajuanPembelian::class)
            ->addMethods(['where', 'firstOrFail'])
            ->enableProxyingToOriginalMethods()
            ->getMock();

        $model->expects($this->once())
            ->method('where')
            ->with('nomor', '123')
            ->willReturnSelf();

        $model->expects($this->once())
            ->method('firstOrFail')
            ->willReturn((object) ['nomor' => '123']);

        // act
        $actual = $service->cari('123');

        // assert
        $this->assertEquals(
            '123',
            $actual->getNomorPengajuan()
        );
    }
}
