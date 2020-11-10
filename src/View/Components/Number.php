<?php

namespace BoldBrush\Bread\View\Components;

use BoldBrush\Bread\View\Components\AbstractComponent;

class Number extends AbstractComponent
{
    protected $number;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $label, ?int $number)
    {
        parent::__construct($name, $label);

        $this->number = $number;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('bread::components.number', [
            'label' => $this->label,
            'name' => $this->name,
            'number' => $this->number,
        ]);
    }
}
