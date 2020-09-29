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
        $this->name = $name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setEditable(bool $editable): self
    {
        $this->editable = $editable;

        return $this;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function setSortable(bool $sortable): self
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function setSearchable(bool $searchable): self
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function setHelpText(string $helpText): self
    {
        $this->helpText = $helpText;

        return $this;
    }

    public function setDefault($default): self
    {
        $this->default = $default;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setCustomElementAfter(callable $function): self
    {
        $this->customElementAfter = $function;

        return $this;
    }

    public function setDataSource(callable $function): self
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
}
