<?php

namespace BoldBrush\Bread\View\Components;

use Illuminate\View\Component;

class Text extends Component
{
    protected $name;

    protected $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $text)
    {
        $this->name = $name;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('bread::components.text', [
            'name' => $this->name,
            'text' => $this->text,
        ]);
    }
}
