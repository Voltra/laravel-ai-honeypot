<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Orchestra\Testbench\TestCase as Orchestra;
use Voltra\LaravelAiHoneypot\LaravelAiHoneypotServiceProvider;

class TestCase extends Orchestra
{
    use MakesHttpRequests; // compat for Filament v3, v4 and v5

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Voltra\\LaravelAiHoneypot\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-ai-honeypot_table.php.stub';
        $migration->up();
        */
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelAiHoneypotServiceProvider::class,
        ];
    }
}
