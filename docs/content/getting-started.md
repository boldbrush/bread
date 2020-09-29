# Getting Started

> This package is dependent on Laravel [models](https://laravel.com/docs/eloquent) and the [query bilder](https://laravel.com/docs/queries)

## Installation

```bash
composer require boldbrush/bread
```

## Simple Examples

Bare bone browse/list view.

```php
<?php

use Illuminate\Support\Facades\Route;

use BoldBrush\Bread\Bread;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/users', function () {
    return (new Bread())
        ->model(User::class)
        ->browse();
});
```
