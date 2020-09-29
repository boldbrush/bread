<?php

namespace BoldBrush\Bread\Field;

interface FieldInterface
{
    public function setEditable(bool $editable): self;
    public function setVisible(bool $visible): self;
    public function setSortable(bool $sortable): self;
    public function setSearchable(bool $searchable): self;
    public function setHelpText(string $helpText): self;
    public function setDefault($default): self;
    public function setType(string $type): self;
    public function setCustomElementAfter(callable $function): self;
    public function setDataSource(callable $function): self;
}
