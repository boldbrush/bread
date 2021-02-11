<?php

namespace BoldBrush\Bread\View\Components;

use BoldBrush\Bread\Field\Field;
use Illuminate\View\Component;
use InvalidArgumentException;

class Select extends AbstractComponent
{
    protected $selected;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $label, Field $field, $selected = null)
    {
        parent::__construct($name, $label, $field);

        $this->selected = $selected;
    }

    public static function factory(string $name, string $label, Field $field, $value = null): Component
    {
        return new self($name, $label, $field, $value);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $dataSource = $this->field->getDataSource();

        return view($this->components . '.select', [
            'label' => $this->label,
            'name' => $this->name,
            'selected' => $this->selected,
            'options' => $dataSource(),
        ]);
    }
}
