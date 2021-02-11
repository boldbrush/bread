<?php

namespace BoldBrush\Bread\View\Components;

use BoldBrush\Bread\Field\Field;
use Illuminate\View\Component;

class Checkbox extends AbstractComponent
{
    protected $checkbox;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $label, Field $field, ?bool $checkbox)
    {
        parent::__construct($name, $label, $field);

        $this->checkbox = $checkbox;
    }

    public static function factory(string $name, string $label, Field $field, $value = null): Component
    {
        return new self($name, $label, $field, boolval($value));
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
