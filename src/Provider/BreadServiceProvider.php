<?php

declare(strict_types=1);

namespace BoldBrush\Bread\Provider;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

class BreadServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            realpath(dirname(dirname(__DIR__))) . '/config/bread.php',
            'bread'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(
            realpath(dirname(dirname(__DIR__))) . '/resources/views',
            'bread'
        );

        $this->publishes([
            realpath(dirname(dirname(__DIR__))) . '/config/bread.php' => config_path('bread.php'),
            realpath(dirname(dirname(__DIR__))) . '/resources/views' => resource_path('views/vendor/bread'),
        ]);

        Blade::componentNamespace('BoldBrush\\Bread\\Views\\Components', 'bread');

        Builder::macro('whereLikeBread', function ($attributes, string $searchTerm) {
            /** @var Builder $this */
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        Str::contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);

                            $query->orWhereHas(
                                $relationName,
                                function (Builder $query) use ($relationAttribute, $searchTerm) {
                                    $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                                }
                            );
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });

            return $this;
        });
    }
}
