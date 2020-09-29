<?php

namespace BoldBrush\Bread\Test;

use BoldBrush\Bread\Provider\BreadServiceProvider;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use DatabaseMigrations, RefreshDatabase;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(realpath(dirname(__DIR__)) . '/database/migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            BreadServiceProvider::class
        ];
    }

    /**
     * Configure the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $config = $app->make('config');

        $config->set('database.default', 'sqlite');
        $config->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $config->set('view.paths', ['bread' => realpath(dirname(__DIR__)) . '/resources/views/']);
        $config->set('view.compiled', realpath(dirname(__DIR__)) . '/storage/views/');
    }
}
