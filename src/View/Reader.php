<?php

namespace BoldBrush\Bread\View;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Field\Field;
use BoldBrush\Bread\Helper\Route\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Reader extends Renderer
{
    protected $model;

    /** @var Field[] */
    protected $fields;

    /** @var Bread */
    protected $bread;

    public function __construct(Bread $bread, object $model)
    {
        parent::__construct($bread);
        $this->model = $model;
        $this->fields = $bread->getFieldsFor('read');
    }

    public function render(): string
    {
        $layout = $this->layout() ?? 'bread::master';
        $view = $this->view() ?? 'bread::read';

        $view = view($view, [
            'reader' => $this,
            'layout' => $layout,
        ]);

        return strval($view);
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
