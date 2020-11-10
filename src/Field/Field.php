<?php

namespace BoldBrush\Bread\Field;

use BoldBrush\Bread\System\FieldToInputTypeMapper;
use Illuminate\Support\Str;

class Field implements FieldInterface
{
    protected $name;

    protected $editable = true;

    protected $visible = true;

    protected $sortable = true;

    protected $searchable = true;

    protected $helpText;

    protected $default;

    protected $type;

    protected $customElementAfter;

    protected $dataSource;

    protected $component;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function setName(string $name): FieldInterface
    {
        $this->name = $name;

        return $this;
    }

    public function setEditable(bool $editable): FieldInterface
    {
        $this->editable = $editable;

        return $this;
    }

    public function setVisible(bool $visible): FieldInterface
    {
        $this->visible = $visible;

        return $this;
    }

    public function setSortable(bool $sortable): FieldInterface
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function setSearchable(bool $searchable): FieldInterface
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function setHelpText(string $helpText): FieldInterface
    {
        $this->helpText = $helpText;

        return $this;
    }

    public function setDefault($default): FieldInterface
    {
        $this->default = $default;

        return $this;
    }

    public function setType(string $type): FieldInterface
    {
        $this->type = $type;

        $this->setComponent(FieldToInputTypeMapper::getInputType($type));

        return $this;
    }

    public function setCustomElementAfter(callable $function): FieldInterface
    {
        $this->customElementAfter = $function;

        return $this;
    }

    public function setDataSource(callable $function): FieldInterface
    {
        $this->dataSource = $function;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isEditable(): bool
    {
        return boolval($this->editable);
    }

    public function isVisible(): bool
    {
        return boolval($this->visible);
    }

    public function isSortable(): bool
    {
        return boolval($this->sortable);
    }

    public function isSearchable(): bool
    {
        return boolval($this->searchable);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function label()
    {
        $label = Str::snake($this->getName());
        $label = str_replace('-', ' ', $label);
        $label = str_replace('_', ' ', $label);

        return Str::title($label);
    }

    public function setComponent(string $component): self
    {
        $this->component = $component;

        return $this;
    }

    public function component(): string
    {
        return $this->component;
    }

    public function render($value): string
    {
        $component = $this->component;
        $component = new $component($this->getName(), $this->label(), $value);

        return strval($component->render());
    }
}
