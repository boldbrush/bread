<?php

namespace BoldBrush\Bread;

use BoldBrush\Bread\Model\Data;

class Bread
{
    protected $model;

    protected $modelData;

    public function __construct(?array $config = null)
    {
    }

    public function model($model): self
    {
        $this->modelData = new Data($model);

        $this->model = $model;

        return $this;
    }
}
