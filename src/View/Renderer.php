<?php

namespace BoldBrush\Bread\View;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Field\Field;
use BoldBrush\Bread\Helper\Route\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use stdClass;

abstract class Renderer implements RendererInterface
{
    protected $bread;

    protected $table;

    protected $model;

    protected $title;

    protected $pkColumn;

    /** @var Builder */
    protected $routeBuilder;

    /** @var Field[] */
    protected $fields;

    protected $layout;

    protected $view;

    public function __construct(Bread $bread, array $fields)
    {
        $this->bread = $bread;
        $this->fields = $fields;
        $this->table = $bread->getModelData()->getTable();
        $this->pkColumn = $bread->getModelData()->getPrimaryKeyName();
        $this->routeBuilder = new Builder($bread->actionLinks(), $this->pkColumn);
        $this->setTitle($bread->getTitle())
            ->setLayout($bread->getLayout())
            ->setView($bread->getView())
            ->setupFields();
    }

    abstract public function render(): string;

    public function setTitle($title): self
    {
        if (is_callable($title)) {
            $title = $title();
        }

        $fn = function ($title) {
            $title = Str::snake($title);
            $title = str_replace('-', ' ', $title);
            $title = str_replace('_', ' ', $title);

            return $title;
        };

        $title = $title ?? $fn($this->bread->getModelData()->getTable());

        $this->title = $title;

        return $this;
    }

    public function title(): string
    {
        $title = $this->title;

        if (is_callable($title)) {
            return $title();
        }

        return Str::title($title);
    }

    public function setLayout(?string $layout = null): self
    {
        $this->layout = $layout;

        return $this;
    }

    public function layout(): ?string
    {
        return $this->layout;
    }

    public function setView(?string $view = null): self
    {
        $this->view = $view;

        return $this;
    }

    public function view(): ?string
    {
        return $this->view;
    }

    public function routeBuilder(): Builder
    {
        return $this->routeBuilder;
    }

    protected function setupFields(): self
    {
        $sm = $this->bread
            ->getConnectionConfigForModel()
            ->getSchemaManager();

        $columns = $sm->listTableColumns($this->table);

        foreach ($columns as $column) {
            if (isset($this->fields[$column->getName()])) {
                $this->fields[$column->getName()]
                    ->setType($column->getType()->getName());
            } else {
                $this->fields[$column->getName()] = (new Field($column->getName()))
                    ->setType($column->getType()->getName());
            }
        }

        return $this;
    }

    public function getFields(): array
    {
        $model = $this->getModel();

        if ($model instanceof Model) {
            $model = $model->toArray();
        } elseif ($model instanceof stdClass) {
            $model = json_decode(json_encode($model), true);
        }

        $fields = [];

        foreach ($model as $attribute => $value) {
            $fields[$attribute] = $this->fields[$attribute];
        }

        return $fields;
    }

    public function getModel(): ?object
    {
        return $this->model;
    }
}