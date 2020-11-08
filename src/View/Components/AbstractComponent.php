<?php

namespace BoldBrush\Bread\View\Components;

use Illuminate\View\Component;

abstract class AbstractComponent extends Component
{
    protected $name;

    protected $label;

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    abstract public function render();
}
