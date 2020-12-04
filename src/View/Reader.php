<?php

declare(strict_types=1);

namespace BoldBrush\Bread\View;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Field\Container;
use BoldBrush\Bread\Field\Field;
use BoldBrush\Bread\Helper\Route\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Reader extends Renderer
{
    protected $model;

    public function __construct(Bread $bread, object $model)
    {
        parent::__construct($bread, $bread->getFields()->for(Container::ADD)->toArray());

        $this->model = $model;
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
}
