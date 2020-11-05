<?php

namespace BoldBrush\Bread\View;

use BoldBrush\Bread\Bread;

class Editor extends Renderer
{
    public function __construct(Bread $bread, object $model)
    {
        parent::__construct($bread, $bread->getFieldsFor('edit'));

        $this->model = $model;

        $this->setupFields();
    }

    public function render(): string
    {
        $layout = $this->layout() ?? 'bread::master';
        $view = $this->view() ?? 'bread::edit';

        $view = view($view, [
            'editor' => $this,
            'layout' => $layout,
        ]);

        return strval($view);
    }
}
