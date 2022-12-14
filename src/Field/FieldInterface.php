<?php

declare(strict_types=1);

namespace BoldBrush\Bread\Field;

use BoldBrush\Bread\Field\Config\FieldConfigurator;

interface FieldInterface
{
    public function setEditable(bool $editable): FieldInterface;
    public function setVisible(bool $visible): FieldInterface;
    public function setCustom(bool $visible): FieldInterface;
    public function setSortable(bool $sortable): FieldInterface;
    public function setSearchable(bool $searchable): FieldInterface;
    public function setHelpText(string $helpText): FieldInterface;
    public function setDefault($default): FieldInterface;
    public function setType(string $type): FieldInterface;
    public function setCustomElementAfter(callable $function): FieldInterface;
    public function setDataSource(callable $function): FieldInterface;
    public function sortLink(): ?string;
    public function setSortDirection(int $sortDirection): FieldInterface;
    public function setSortBy(array $httpQuery = []): FieldInterface;
    public function addCssClass(string $key, $class): FieldInterface;
    public function render(string $value): string;
}
