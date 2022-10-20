<?php

namespace BoldBrush\Bread\View\Components;

use BoldBrush\Bread\Field\Field;
use Illuminate\View\Component;

abstract class AbstractComponent extends Component
{
    protected $name;

    protected $label;

    protected $components;

    protected $field;

    public function __construct(string $name, string $label, Field $field)
    {
        $this->name = $name;
        $this->label = $label;
        $this->field = $field;
        $this->components = config('bread')['theme'] . '.components';
    }

    abstract public static function make(string $name, string $label, Field $field, $value = null): Component;

    abstract public function render();
}
