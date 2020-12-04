<?php

declare(strict_types=1);

namespace BoldBrush\Bread\Test;

function root_path(): string
{
    return realpath(
        dirname(__DIR__)
    );
}

function database_path(string $dbName): string
{
    return root_path() . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . $dbName;
}
