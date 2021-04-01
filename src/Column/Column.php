<?php

namespace BoldBrush\Bread\Column;

class Column
{
    protected $field;

    protected $header;

    public function __construct(string $field, string $header)
    {
        $this->field = $field;
        $this->header = $header;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getHeader()
    {
        return $this->header;
    }
}
