<?php

namespace Yormy\ChaskiLaravel\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use jdavidbakr\MailTracker\MailTrackerServiceProvider;
use LiranCo\NotificationSubscriptions\NotificationSubscriptionsServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Spatie\LaravelRay\RayServiceProvider;
use Yormy\ChaskiLaravel\ChaskiServiceProvider;

abstract class TestCase extends BaseTestCase
{
    // disable after migration to inpect db during test
    //use RefreshDatabase;

    protected function setUp(): void
    {
        $this->updateEnv();

        parent::setUp();

        $this->setUpConfig();
    }

    protected function getPackageProviders($app)
    {
        return [
            ChaskiServiceProvider::class,
            RayServiceProvider::class,
            MailTrackerServiceProvider::class,
            NotificationSubscriptionsServiceProvider::class,
        ];
    }

    protected function setUpConfig(): void
    {
        config(['tripwire' => require __DIR__.'/../../config/chaski.php']);
        config(['app.key' => 'base64:yNmpwO5YE6xwBz0enheYLBDslnbslodDqK1u+oE5CEE=']);
        config(['mail.default' => 'log']);

        config(['app.url' => 'https://hhh.conm']);
        config(['app.url' => 'http://test.test?myNewParam=5']);
    }

    /**
     * We need to update the .env.example
     * because in a job the previous settings in config are not used and the settings from .env are used.
     */
    protected function updateEnv()
    {
        copy('./src/Tests/Setup/.env', './vendor/orchestra/testbench-core/laravel/.env');
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
