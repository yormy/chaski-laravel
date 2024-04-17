<?php

namespace Yormy\ChaskiLaravel\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

use jdavidbakr\MailTracker\MailTrackerServiceProvider;
use LiranCo\NotificationSubscriptions\NotificationSubscriptionsServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Spatie\LaravelData\LaravelDataServiceProvider;
use Spatie\LaravelRay\RayServiceProvider;
use Yormy\ChaskiLaravel\ChaskiServiceProvider;
use Yormy\AssertLaravel\Helpers\AssertJsonMacros;

abstract class TestCase extends BaseTestCase
{
    // disable after migration to inpect db during test
    use RefreshDatabase;

    protected function setUp(): void
    {
        $this->updateEnv();

        parent::setUp();

        TestConfig::setup();

        $this->withoutExceptionHandling();

        TestRoutes::setup();

        AssertJsonMacros::register();
    }

    protected function getPackageProviders($app)
    {
        return [
            ChaskiServiceProvider::class,
            RayServiceProvider::class,
            MailTrackerServiceProvider::class,
            NotificationSubscriptionsServiceProvider::class,
            LaravelDataServiceProvider::class,
        ];
    }

    /**
     * We need to update the .env.example
     * because in a job the previous settings in config are not used and the settings from .env are used.
     */
    protected function updateEnv()
    {
        copy('./tests/Setup/.env', './vendor/orchestra/testbench-core/laravel/.env');
    }

    /**
     * @psalm-return \Closure():'next'
     */
    public function getNextClosure(): \Closure
    {
        return function () {
            return 'next';
        };
    }
}
