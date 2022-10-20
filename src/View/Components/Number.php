<?php

namespace BoldBrush\Bread\View\Components;

use BoldBrush\Bread\Field\Field;
use Illuminate\View\Component;

class Number extends AbstractComponent
{
    protected $number;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $label, Field $field, ?int $number)
    {
        parent::__construct($name, $label, $field);

        $this->number = $number;
    }

    public static function make(string $name, string $label, Field $field, $value = null): Component
    {
        return new self($name, $label, $field, intval($value));
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
