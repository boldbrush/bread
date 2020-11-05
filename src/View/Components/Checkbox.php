<?php

namespace BoldBrush\Bread\View\Components;

use Illuminate\View\Component;

class Checkbox extends Component
{
    protected $name;

    protected $checkbox;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, bool $checkbox)
    {
        $this->name = $name;
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
            'name' => $this->name,
            'checkbox' => $this->checkbox,
        ]);
    }
}
