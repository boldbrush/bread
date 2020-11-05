<?php

namespace BoldBrush\Bread\View\Components;

use Illuminate\View\Component;

class Date extends Component
{
    protected $name;

    protected $date;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $date)
    {
        $this->name = $name;
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
            'name' => $this->name,
            'date' => $this->date,
        ]);
    }
}
