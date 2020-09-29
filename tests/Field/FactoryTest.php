<?php

namespace BoldBrush\Bread\Test\Field;

use BoldBrush\Bread\Field;
use Illuminate\Database\Eloquent\Model;
use BoldBrush\Bread\Test\TestCase;

class FactoryTest extends TestCase
{
    public function testFromData()
    {
        $path = '/edit/{{id}}';

        $field = Field\Factory::forData([
            'editable' => true,
            'visible' => true,
            'sortable' => false,
            'searchable' => true,
            'helpText' => "This is the help text for the title",
            'default' => "Default Title Value goes here",
            'type' => 'text',
            'customElementAfter' => function (Model $model, Field\Field $field) use ($path) {
                $key = $model->getKeyName();
                $path = str_replace('{{id}}', $model->$key, $path);
                return '<a href="'. $path .'">Add Medium</a>';
            },
            'dataSource' => function () {
                return ['guest', 'editor', 'admin'];
            },
        ], 'role');

        $this->assertInstanceOf(Field\Field::class, $field);
    }
}
