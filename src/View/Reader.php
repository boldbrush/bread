<?php

namespace BoldBrush\Bread\View;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Field\Field;
use BoldBrush\Bread\Helper\Route\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Reader implements RendererInterface
{
    protected $pkColumn;

    /** @var Builder */
    protected $routeBuilder;

    protected $model;

    protected $table;

    protected $title;

    /** @var Field[] */
    protected $fields;

    /** @var Bread */
    protected $bread;

    public function __construct(Bread $bread, object $model)
    {
        $this->bread = $bread;
        $this->model = $model;
        $this->table = $bread->getModelData()->getTable();
        $this->title = $bread->getModelData()->getTable();
        $this->pkColumn = $bread->getModelData()->getPrimaryKeyName();
        $this->routeBuilder = new Builder($bread->actionLinks(), $this->pkColumn);
        $this->fields = $bread->getFieldsFor('read');
    }

    public function render(): string
    {
        return '';
    }

    public function setTitle($title)
    {
        $this->title = strval($title);

        return $this;
    }

    public function title()
    {
        $title = $this->title;

        if ($title === null) {
            $title = $this->table;
        }

        $title = Str::snake($title);
        $title = str_replace('-', ' ', $title);
        $title = str_replace('_', ' ', $title);

        return Str::title($title);
    }

    public function routeBuilder(): Builder
    {
        return $this->routeBuilder;
    }

    public function getFields()
    {
        $item = $this->model;

        if (isset($item->row_num)) {
            unset($item->row_num);
        }

        if ($item instanceof Model) {
            $item = $item->toArray();
        } elseif ($item instanceof stdClass) {
            $item = json_decode(json_encode($item), true);
        }

        $fields = $this->fields;

        foreach ($item as $key => $value) {
            if (isset($fields[$key]) && $fields[$key]->isVisible() === false) {
                unset($item[$key]);
            }
        }

        return array_keys($item);
    }
}
