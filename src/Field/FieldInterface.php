<?php

namespace BoldBrush\Bread\Field;

interface FieldInterface
{
    public function setEditable(bool $editable): FieldInterface;
    public function setVisible(bool $visible): FieldInterface;
    public function setSortable(bool $sortable): FieldInterface;
    public function setSearchable(bool $searchable): FieldInterface;
    public function setHelpText(string $helpText): FieldInterface;
    public function setDefault($default): FieldInterface;
    public function setType(string $type): FieldInterface;
    public function setCustomElementAfter(callable $function): FieldInterface;
    public function setDataSource(callable $function): FieldInterface;
}
