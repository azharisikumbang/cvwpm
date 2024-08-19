<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\UserTrait;

abstract class TestCase extends BaseTestCase
{
    use UserTrait;
}
