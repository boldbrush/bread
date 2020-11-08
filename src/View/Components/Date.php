<?php

namespace BoldBrush\Bread\View\Components;

use BoldBrush\Bread\View\Components\AbstractComponent;

class Date extends AbstractComponent
{
    protected $date;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $label, string $date)
    {
        parent::__construct($name, $label);

        $this->date = $date;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('bread::components.date', [
            'label' => $this->label,
            'name' => $this->name,
            'date' => $this->date,
        ]);
    }
}
