<?php

namespace BoldBrush\Bread\Test;

use BoldBrush\Bread\Bread;
use Orchestra\Testbench\TestCase;

class BreadTest extends TestCase
{
    public function testInstance()
    {
        $bread = new Bread();

        $this->assertInstanceOf(Bread::class, $bread);
    }
}
