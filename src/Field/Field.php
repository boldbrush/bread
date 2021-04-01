<?php

declare(strict_types=1);

namespace BoldBrush\Bread\Field;

use BoldBrush\Bread\System\FieldToInputTypeMapper;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Field implements FieldInterface
{
    protected $name;

    protected $editable = true;

    protected $visible = true;

    protected $sortable = true;

    protected $sortDirection = 0;

    protected $searchable = true;

    protected $helpText;

    protected $default;

    protected $type;

    protected $customElementAfter;

    protected $dataSource;

    protected $component;

    protected $length = null;

    protected $cssClasses;

    protected $httpQuery;

    public function __construct(string $name)
    {
        $this->setName($name);
        $this->cssClasses = collect([]);

        $this->addCssClass('name', 'js-id-' . $this->getName());
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

        if ($this->sortable) {
            $this->addCssClass('sortable', 'js-bread-sortable');
        }

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

    public function setLength(?int $length): FieldInterface
    {
        $this->length = $length;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
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

    public function addCssClass(string $key, $class): FieldInterface
    {
        $this->cssClasses->put($key, $class);

        return $this;
    }

    public function getCssClasses(): array
    {
        if ($this->sortable && !$this->cssClasses->has('sortable')) {
            $this->addCssClass('sortable', 'js-bread-sortable');
        }

        return $this->cssClasses->toArray();
    }

    public function getStringCssClasses(): string
    {
        return implode(' ', $this->getCssClasses());
    }

    public function getDataSource(): callable
    {
        return $this->dataSource;
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

    public function getType(): ?string
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

    public function sortLink(): ?string
    {
        $link = null;

        if ($this->sortDirection === -1) {
            $this->addCssClass('sortable', 'js-bread-sortable desc');
            $direction = 'desc';
        } else {
            $this->addCssClass('sortable', 'js-bread-sortable asc');
            $direction = 'asc';
        }

        $parameters = ['sortBy' => "{$this->getName()},$direction"];

        if (count($this->httpQuery) > 0) {
            $parameters = array_merge($this->httpQuery, $parameters);
        }

        $url = url()->current() . '?' . Arr::query($parameters);

        return "href=$url";
    }

    public function setSortDirection(int $sortDirection): FieldInterface
    {
        $this->sortDirection = $sortDirection;

        return $this;
    }

    public function setSortBy(array $httpQuery = []): FieldInterface
    {
        $this->httpQuery = $httpQuery;

        if (isset($httpQuery['sortBy'])) {
            list($name, $direction) = explode(',', $httpQuery['sortBy']);

            if ($this->getName() === $name) {
                $direction = $direction == 'desc' ? 1 : -1;
                $this->setSortDirection($direction);
            }
        }

        return $this;
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
        $component = $component::factory($this->getName(), $this->label(), $this, $value);

        return strval($component->render());
    }
}
