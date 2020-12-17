<?php

declare(strict_types=1);

namespace BoldBrush\Bread\View;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Field\FieldContainer;

class Adder extends Renderer
{
    public function __construct(Bread $bread, object $model)
    {
        parent::__construct($bread, $bread->getFields()->for(FieldContainer::ADD)->toArray());

        $this->model = $model;

        $this->setupFields();
    }

    public function render(): string
    {
        $layout = $this->layout() ?? $this->bread->globalLayout();
        $view = $this->view() ?? $this->bread->globalView(FieldContainer::ADD);

        $view = view($view, [
            'adder' => $this,
            'layout' => $layout,
        ]);

        return strval($view);
    }
}
