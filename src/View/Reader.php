<?php

declare(strict_types=1);

namespace BoldBrush\Bread\View;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Field\FieldContainer;

class Reader extends Renderer
{
    protected $model;

    public function __construct(Bread $bread, object $model)
    {
        parent::__construct($bread, $bread->getFields()->for(FieldContainer::READ)->toArray());

        $this->model = $model;
    }

    public function render(): string
    {
        $layout = $this->layout() ?? $this->bread->globalLayout();
        $view = $this->view() ?? $this->bread->globalView(FieldContainer::READ);

        $view = view($view, [
            'reader' => $this,
            'layout' => $layout,
        ]);

        return strval($view);
    }
}
