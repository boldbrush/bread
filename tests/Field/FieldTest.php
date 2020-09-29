<?php

namespace BoldBrush\Bread\Test\Field;

use BoldBrush\Bread\Field;
use BoldBrush\Bread\Test\TestCase;

class FieldTest extends TestCase
{
    public function testInstanceOf()
    {
        $field = new Field\Field('role');

        $this->assertInstanceOf(Field\Field::class, $field);
    }
}
