<?php

declare(strict_types=1);

namespace BoldBrush\Bread\Field\Config;

use BoldBrush\Bread\Field\Field;
use BoldBrush\Bread\Bread;
use Illuminate\Support\Collection;

class Config
{
    /** @var string */
    protected $for;

    /** @var Collection */
    protected $fields;

    /** @var Bread */
    protected $bread;

    public function __construct(string $for, Collection $fields, Bread $bread)
    {
        $this->for = $for;
        $this->fields = $fields;
        $this->bread = $bread;
    }

    public function field(string $name): FieldConfigurator
    {
        $field = $this->fields->get($name);

        if ($field === null) {
            $field = new Field($name, $this);
        }

        return new FieldConfigurator($field, $this->fields, $this);
    }

    public function back(): Bread
    {
        $this->bread->getFields()->setFor($this->fields, $this->for);

        return $this->bread;
    }

    public function bread(): Bread
    {
        return $this->back();
    }
}
