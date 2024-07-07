<?php

namespace Tests\Unit;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_can_see_homepage(): void
    {
        $this->get('/')->assertOk();
    }
}
