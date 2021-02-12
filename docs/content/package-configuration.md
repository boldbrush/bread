# Package configuration.

The BREAD package has a very simple configuration file. The `bread.php` config file is meant to configure the global views/appearance.

```php
<?php

return [
    'theme' => env('BREAD.THEME', 'bread::tailwind'),
    'layout' => env('BREAD.LAYOUT', 'master'),
    'view' => [
        'browse' => env('BREAD.VIEW.BROWSE', 'browse'),
        'read' => env('BREAD.VIEW.READ', 'read'),
        'edit' => env('BREAD.VIEW.EDIT', 'edit'),
        'add' => env('BREAD.VIEW.ADD', 'add'),
    ],
];
```

In order to easily override your default configuration options run the artisan command `vendor:publish`. This will copy the `bread.php` file to the application's `config` directory.

## The theme

The `theme` configuration let the `Bread` class know where the base views are stored. You can see how the theme directory is structured in the next file tree.

```
📦resources
 ┗ 📂views
   ┣ 📂tailwind <--- Theme directory
   ┃ ┣ 📂components
   ┃ ┃ ┣ 📂nolength
   ┃ ┃ ┃ ┗ text.blade.php
   ┃ ┃ ┣ checkbox.blade.php
   ┃ ┃ ┣ date.blade.php
   ┃ ┃ ┣ number.blade.php
   ┃ ┃ ┣ select.blade.php
   ┃ ┃ ┗ text.blade.php
   ┃ ┣ add.blade.php
   ┃ ┣ browse.blade.php
   ┃ ┣ edit.blade.php
   ┃ ┣ master.blade.php
   ┃ ┗ read.blade.php
   ┗ 📂other-themes
     ...
```

## The layout

The `layout` configuration specify which base layout to use. By default the `Bread` class uses the `master.blade.php` file inside the chosen theme directory. 

## The view(s)

The `view` configuration array specify which view to use for each of the B.R.E.A actions. Since the way `Bread` works does not need a view for the delete action we don't need one in the package configuration. By default the `Bread` class uses the `[action].blade.php` file inside the chosen theme directory.

?> The `[action]` is replaced by the browse, read, edit, add accordingly. 
