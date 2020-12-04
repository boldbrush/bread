<?php

declare(strict_types=1);

namespace BoldBrush\Bread\View;

interface RendererInterface
{
    public function render(): string;
}
