<?php

declare(strict_types=1);

namespace BoldBrush\Bread\System;

use BoldBrush\Bread\View\Components;

class FieldToInputTypeMapper
{
    protected static $typeMap = [
        'boolean' => Components\Checkbox::class,
        'date' => Components\Date::class,
        'datetime' => Components\Text::class,
        'datetimetz' => Components\Text::class,
        'time' => Components\Date::class,
        'smallint' => Components\Number::class,
        'integer' => Components\Number::class,
        'smallint' => Components\Number::class,
        'smallint' => Components\Number::class,
        'bigint' => Components\Text::class,
        'decimal' => Components\Text::class,
        'float' => Components\Text::class,
        'string' => Components\Text::class,
        'ascii_string' => Components\Text::class,
        'text' => Components\Text::class,
        'ntext' => Components\NoLength\Text::class,
        'guid' => Components\Text::class,
        'enum' => Components\Select::class,
        'select' => Components\Select::class,
    ];

    public static function getInputType(string $type): string
    {
        return isset(self::$typeMap[$type]) ? self::$typeMap[$type] : Components\Text::class;
    }
}
