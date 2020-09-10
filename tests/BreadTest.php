<?php

namespace BoldBrush\Bread\Test;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Test\App\Model;
use Orchestra\Testbench\Dusk\TestCase;

class BreadTest extends TestCase
{
    public function testInstance()
    {
        $bread = new Bread();

        $this->assertInstanceOf(Bread::class, $bread);
    }

    public function testModelInstance()
    {
        $bread = (new Bread())->model(Model\User::class);

        $this->assertInstanceOf(Bread::class, $bread);
    }
}
