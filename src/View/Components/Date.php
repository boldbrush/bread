<?php

namespace BoldBrush\Bread\View\Components;

use Illuminate\View\Component;

class Date extends AbstractComponent
{
    protected $date;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $label, ?string $date)
    {
        parent::__construct($name, $label);

        $this->date = $date;
    }

    public static function factory(string $name, string $label, $value = null): Component
    {
        return new self($name, $label, strval($value));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view($this->components . '.date', [
            'label' => $this->label,
            'name' => $this->name,
            'date' => $this->date,
        ]);
    }
}
