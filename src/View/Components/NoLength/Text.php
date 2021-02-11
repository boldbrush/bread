<?php

namespace BoldBrush\Bread\View\Components\NoLength;

use BoldBrush\Bread\Field\Field;
use BoldBrush\Bread\View\Components\Text as ParentText;
use Illuminate\View\Component;

class Text extends ParentText
{
    public static function factory(string $name, string $label, Field $field, $value = null): Component
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
        return view($this->components . '.nolength.text', [
            'label' => $this->label,
            'name' => $this->name,
            'text' => $this->text,
        ]);
    }
}
