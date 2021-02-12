<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - BREAD</title>

    <!-- Fonts -->
    <!-- Styles -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <style>
    </style>
</head>

<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="mt-8">
                <div class="grid grid-cols-1 p-6">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>

</html>