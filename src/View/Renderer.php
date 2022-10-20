<?php

declare(strict_types=1);

namespace BoldBrush\Bread\View;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Field\Field;
use BoldBrush\Bread\Helper\Route\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    /** @var Request  */
    protected $request;

    /** @var Response  */
    protected $response;

    public function __construct(Bread $bread, array $fields, ?Request $request = null, ?Response $response = null)
    {
        $this->bread = $bread;
        $this->fields = $fields;
        $this->table = $bread->getModelMetadata()->getTable();
        $this->pkColumn = $bread->getModelMetadata()->getPrimaryKeyName();
        $this->routeBuilder = new Builder($bread->actionLinks(), $this->pkColumn);
        $this->request = $request;
        $this->response = $response;
        $this->setTitle($bread->getTitle())
            ->setLayout($bread->getLayout())
            ->setView($bread->getView())
            ->setupFields();
    }

    abstract public function render(): string;

    public function request(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function response(Response $response): self
    {
        $this->response = $response;

        return $this;
    }

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

        $title = $title ?? $fn($this->bread->getModelMetadata()->getTable());

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
            ->createSchemaManager();

        $columns = $sm->listTableColumns($this->table);

        foreach ($columns as $column) {
            if (isset($this->fields[$column->getName()])) {
                $this->fields[$column->getName()]
                    ->setLength($column->getLength());
                if (!is_string($this->fields[$column->getName()]->getType())) {
                    $this->fields[$column->getName()]->setType($column->getType()->getName());
                }
            } else {
                $this->fields[$column->getName()] = (new Field($column->getName()))
                    ->setLength($column->getLength())
                    ->setType($column->getType()->getName());
            }

            if (isset($this->request)) {
                $this->fields[$column->getName()]
                    ->setSortBy($this->request->query());
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
            if (isset($this->fields[$attribute])) {
                $fields[$attribute] = $this->fields[$attribute];
            }
        }

        return $fields;
    }

    public function getModel(): ?object
    {
        return $this->model;
    }

    public function bread(): Bread
    {
        return $this->bread;
    }
}
