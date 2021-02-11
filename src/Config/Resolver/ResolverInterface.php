<?php

declare(strict_types=1);

namespace BoldBrush\Bread\Config\Resolver;

use BoldBrush\Bread\Bread;

interface ResolverInterface
{
    public function __construct(array $data, Bread &$bread);

    public function resolve(): bool;
}
