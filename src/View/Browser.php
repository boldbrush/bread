<?php

namespace BoldBrush\Bread\View;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Field\Field;
use BoldBrush\Bread\Helper\Route\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Browser extends Renderer
{
    /** @var LengthAwarePaginator */
    protected $paginator;

    protected $pkColumn;

    protected $editRoute;

    protected $readRoute;

    protected $viewRoute;

    /** @var Builder */
    protected $routeBuilder;

    protected $table;

    /** @var Field[] */
    protected $fields;

    /** @var Bread */
    protected $bread;

    public function __construct(Bread $bread, LengthAwarePaginator $paginator)
    {
        parent::__construct($bread);

        $this->fields = $bread->getFieldsFor('browse');
        $this->paginator = $paginator;
    }

    public function render(): string
    {
        $layout = $this->layout() ?? 'bread::master';
        $view = $this->view() ?? 'bread::browse';

        $view = view($view, [
            'browser' => $this,
            'layout' => $layout,
        ]);

        return strval($view);
    }

    public function records()
    {
        $fields = $this->fields;

        $collection = collect($this->paginator->items())->map(function ($record) use ($fields) {
            if (isset($record->row_num)) {
                unset($record->row_num);
            }

            if ($record instanceof Model) {
                $arr = $record->toArray();
            } elseif ($record instanceof stdClass) {
                $arr = json_decode(json_encode($record), true);
            }

            foreach ($arr as $key => $value) {
                if (isset($fields[$key]) && $fields[$key]->isVisible() === false) {
                    unset($record->$key);
                }
            }

            return $record;
        });

        $this->paginator->setCollection($collection);

        return $this->paginator->items();
    }

    public function routeBuilder(): Builder
    {
        return $this->routeBuilder;
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
}
