<?php

namespace BoldBrush\Bread\Field;

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

    public function render(): string
    {
        return '';
    }
}
