<?php

declare(strict_types=1);

namespace BoldBrush\Bread\Field\Config;

use BoldBrush\Bread\Field\Field;
use BoldBrush\Bread\Bread;
use Illuminate\Support\Collection;

class FieldConfigurator
{
    /** @var Field */
    protected $field;

    /** @var Collection */
    protected $fields;

    /** @var Config */
    protected $config;

    public function __construct(Field $field, Collection $fields, Config $config)
    {
        $this->field = $field;
        $this->fields = $fields;
        $this->config = $config;
    }

    public function editable(bool $editable): self
    {
        $this->field->setEditable($editable);

        return $this;
    }

    public function visible(bool $visible): self
    {
        $this->field->setVisible($visible);

        return $this;
    }

    public function sortable(bool $sortable): self
    {
        $this->field->setSortable($sortable);

        return $this;
    }

    public function searchable(bool $searchable): self
    {
        $this->field->setSearchable($searchable);

        return $this;
    }

    public function helpText(string $text): self
    {
        $this->field->setHelpText($text);

        return $this;
    }

    public function default($default): self
    {
        $this->field->setDefault($default);

        return $this;
    }

    public function type(string $type): self
    {
        $this->field->setType($type);

        return $this;
    }

    public function customElementAfter(callable $element): self
    {
        $this->field->setCustomElementAfter($element);

        return $this;
    }

    public function dataSource(callable $dataSource): self
    {
        $this->field->setDataSource($dataSource);

        return $this;
    }

    public function back(): Config
    {
        $this->fields->put($this->field->getName(), $this->field);

        return $this->config;
    }

    public function new(): Config
    {
        return $this->back();
    }

    public function field(string $name): FieldConfigurator
    {
        return $this->new()->field($name);
    }

    public function bread(): Bread
    {
        $this->fields->put($this->field->getName(), $this->field);

        return $this->config->bread();
    }
}
