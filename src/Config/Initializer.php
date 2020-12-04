<?php

declare(strict_types=1);

namespace BoldBrush\Bread\Config;

use BoldBrush\Bread\Bread;
use Throwable;

class Initializer
{
    /** @var array $config */
    private $config = null;

    /** @var Bread $bread */
    private $bread = null;

    public function __construct(?array $config, Bread &$bread)
    {
        $this->config = $config;
        $this->bread = $bread;
    }

    public function init(): void
    {
        if (is_array($this->config)) {
            foreach ($this->config as $method => $value) {
                try {
                    $this->bread->$method($value);
                } catch (Throwable $th) {
                    if (!$this->resolve($method, $value)) {
                        throw $th;
                    }
                }
            }
        }
    }

    protected function resolve(string $method, $value): bool
    {
        return true;
    }
}
