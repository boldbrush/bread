<?php

namespace BoldBrush\Bread\View\Components;

use BoldBrush\Bread\Field\Field;
use Illuminate\View\Component;

class Date extends AbstractComponent
{
    protected $date;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $label, Field $field, ?string $date)
    {
        parent::__construct($name, $label, $field);

        $this->date = $date;
    }

    public static function make(string $name, string $label, Field $field, $value = null): Component
    {
        return new self($name, $label, $field, strval($value));
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
