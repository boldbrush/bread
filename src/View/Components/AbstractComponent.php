<?php

namespace BoldBrush\Bread\View\Components;

use BoldBrush\Bread\Bread;
use Illuminate\View\Component;

abstract class AbstractComponent extends Component
{
    protected $name;

    protected $label;

    protected $components;

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
        $this->components = config('bread')['theme'] . '.components';
    }

    abstract public static function factory(string $name, string $label, $value = null): Component;

    abstract public function render();
}
