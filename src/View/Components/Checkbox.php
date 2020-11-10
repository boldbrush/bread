<?php

namespace BoldBrush\Bread\View\Components;

use BoldBrush\Bread\View\Components\AbstractComponent;

class Checkbox extends AbstractComponent
{
    protected $checkbox;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $label, ?bool $checkbox)
    {
        parent::__construct($name, $label);

        $this->checkbox = $checkbox;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('bread::components.checkbox', [
            'label' => $this->label,
            'name' => $this->name,
            'checkbox' => $this->checkbox,
        ]);
    }
}
