<?php

namespace BoldBrush\Bread\View\Components;

use Illuminate\View\Component;

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

    public static function factory(string $name, string $label, $value = null): Component
    {
        return new self($name, $label, boolval($value));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view($this->components . '.checkbox', [
            'label' => $this->label,
            'name' => $this->name,
            'checkbox' => $this->checkbox,
        ]);
    }
}
