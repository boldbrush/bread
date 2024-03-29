# Getting Started

## Introduction

The BREAD package provides an easy way to create list/browse views, edit and create forms as well as read/display views for your Laravel powered application. The BREAD package allows you to easily customize the way each view renders.

> This package is dependent on Laravel [models](https://laravel.com/docs/eloquent) and the [query builder](https://laravel.com/docs/queries)

## Installation

You may use Composer to install the BREAD package into your Laravel project:

```bash
composer require boldbrush/bread
```

## Simple Example

Bare bones browse/list view.

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

This will yield a similar result like below

!> The image below shows sample data

![simple-browse](./../_media/screenshots/simple-browse.png ':class=img-center')

