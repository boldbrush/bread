<?php

namespace BoldBrush\Bread\Config\Resolver;

use BoldBrush\Bread\Bread;
use BoldBrush\Bread\Field\Field;

class FieldResolver implements ResolverInterface
{
    protected $data;

    protected $bread;

    public function __construct(array $data, Bread &$bread)
    {
        $this->data = $data;
        $this->bread = $bread;
    }

    public function resolve(): bool
    {
        foreach ($this->data as $name => $data) {
            $field = $this->bread->configureFields()->field($name);
            foreach ($data as $method => $value) {
                if (method_exists($field, $method)) {
                    $field->$method($value);
                }
                $this->bread = $field->bread();
            }
        }

        return true;
    }
}
