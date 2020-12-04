<?php

namespace BoldBrush\Bread\Test;

use BoldBrush\Bread;
use BoldBrush\Bread\Test\App\Model;

class BreadTest extends TestCase
{
    public function testInstance()
    {
        $bread = new Bread\Bread();

        $this->assertInstanceOf(Bread\Bread::class, $bread);
    }

    public function testModelInstance()
    {
        $bread = (new Bread\Bread())->model(Model\User::class);

        $this->assertInstanceOf(Bread\Bread::class, $bread);
    }
}
