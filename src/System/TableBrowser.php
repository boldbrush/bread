<?php

namespace BoldBrush\Bread\System;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Field\Field;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class TableBrowser
{
    /** @var LengthAwarePaginator */
    protected $paginator;

    protected $pkColumn;

    protected $editRoute;

    protected $viewRoute;

    protected $table;

    protected $title;

    protected $fields;

    /** @var Bread */
    protected $bread;

    public function __construct(Bread $bread, LengthAwarePaginator $paginator)
    {
        $this->bread = $bread;
        $this->table = $bread->getModelData()->getTable();
        $this->title = $bread->getModelData()->getTable();
        $this->pkColumn = $bread->getModelData()->getPrimaryKeyName();
        $this->fields = $bread->getFieldsFor('browse');
        $this->paginator = $paginator;
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

    public function records()
    {
        if (
            $this->pkColumn !== null &&
            is_string($this->pkColumn) &&
            $this->editRoute !== null &&
            is_string($this->editRoute)
        ) {
            $route = $this->editRoute;
            $parts = explode('/', $route);
            $last = count($parts) - 1;
            $parts[$last] = '{{id}}';
            $routeTemplate = implode('/', $parts);

            $collection = collect($this->paginator->items())->map(function ($record) use ($routeTemplate) {
                $id = $record->{$this->pkColumn};

                $record->editUrl = str_replace('{{id}}', $id, $routeTemplate);

                return $record;
            });

            $this->paginator->setCollection($collection);
        }

        $fields = $this->fields;

        $collection = collect($this->paginator->items())->map(function ($record) use ($fields) {
            if (isset($record->row_num)) {
                unset($record->row_num);
            }

            foreach ($record->toArray() as $key => $value) {
                if (isset($fields[$key]) && $fields[$key]->isVisible() === false) {
                    unset($record->$key);
                }
            }

            return $record;
        });

        $this->paginator->setCollection($collection);

        return $this->paginator->items();
    }

    public function count()
    {
        return $this->paginator->count();
    }

    public function paginator()
    {
        return $this->paginator;
    }

    public function total()
    {
        return $this->paginator->total();
    }

    public function getColumns()
    {
        if ($this->count() === 0) {
            return [];
        }

        $item = $this->paginator->first();

        if (isset($item->row_num)) {
            unset($item->row_num);
        }

        $item = $item->toArray();

        $fields = $this->fields;

        foreach ($item as $key => $value) {
            if (isset($fields[$key]) && $fields[$key]->isVisible() === false) {
                unset($item[$key]);
            }
        }

        return array_keys($item);
    }

    public function rowHeaders()
    {
        $headers = $this->getColumns();

        $headers = collect($headers)->map(function ($header) {
            $header = Str::snake($header);
            $header = str_replace('-', ' ', $header);
            $header = str_replace('_', ' ', $header);
            return Str::title($header);
        });

        return $headers->toArray();
    }

    public function hasEditRoute()
    {
        return boolval($this->editRoute);
    }
}
