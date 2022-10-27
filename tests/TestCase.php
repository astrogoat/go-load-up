<?php

namespace Astrogoat\GoLoadUp\Tests;

use Astrogoat\GoLoadUp\GoLoadUpServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Astrogoat\\GoLoadUp\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            GoLoadUpServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_go-load-up_table.php.stub';
        $migration->up();
        */
    }
}
