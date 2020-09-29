<?php

namespace BoldBrush\Bread\Field;

use function ucfirst;

class Factory
{
    public static function forData(array $data, string $name): Field
    {
        $field = new Field($name);

        foreach ($data as $property => $value) {
            if (property_exists($field, $property)) {
                $setter = 'set' . ucfirst($property);

                $field->$setter($value);
            }
        }

        return $field;
    }
}
