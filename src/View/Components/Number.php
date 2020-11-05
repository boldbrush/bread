<?php

namespace BoldBrush\Bread\View\Components;

use Illuminate\View\Component;

class Number extends Component
{
    protected $name;

    protected $number;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, int $number)
    {
        $this->name = $name;
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
            'name' => $this->name,
            'number' => $this->number,
        ]);
    }
}
