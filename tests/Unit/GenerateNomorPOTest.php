<?php

namespace Tests\Unit;

use App\Helper\GenerateNomorPO;
use App\Models\PurchaseOrder;
use PHPUnit\Framework\TestCase;

class GenerateNomorPOTest extends TestCase
{
    public function testGenerateNomorPo()
    {
        $this->markTestIncomplete();

        // example format -> 012/WPM/PO.4/2024
        $date = new \DateTime('2024-07-14');

        $POModelMock = $this->createMock(PurchaseOrder::class);

        $po = GenerateNomorPO::generate();

        $this->assertIsString($po);
        $this->assertStringContainsString('PO.' . $date->format('n'), $po);
        $this->assertStringContainsString($date->format('Y'), $po);

        $this->assertMatchesRegularExpression('/\d{3}\/WPM\/PO\.\d\/\d{4}/', $po);
    }

}
