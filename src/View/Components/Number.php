<?php

namespace BoldBrush\Bread\View\Components;

use Illuminate\View\Component;

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

    public static function factory(string $name, string $label, $value = null): Component
    {
        return new self($name, $label, intval($value));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view($this->components . '.number', [
            'label' => $this->label,
            'name' => $this->name,
            'number' => $this->number,
        ]);
    }
}
