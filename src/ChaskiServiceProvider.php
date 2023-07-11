<?php

namespace Yormy\ChaskiLaravel;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use jdavidbakr\MailTracker\MailTracker;
use Yormy\ChaskiLaravel\Console\Commands\GenerateAccepts;
use Yormy\ChaskiLaravel\Http\Middleware\Honeypot;
use Yormy\ChaskiLaravel\Models\MailTracker\ChaskiEmailSent;
use Yormy\ChaskiLaravel\Models\MailTracker\EmailSent;
use Yormy\ChaskiLaravel\Models\MailTracker\SentEmail;
use Yormy\ChaskiLaravel\ServiceProviders\EventServiceProvider;
use Yormy\ChaskiLaravel\ServiceProviders\RouteServiceProvider;

class ChaskiServiceProvider extends ServiceProvider
{
    const CONFIG_FILE = __DIR__.'/../config/chaski.php';
    const CONFIG__MAIL_TRACKER_FILE = __DIR__.'/../config/mail-tracker.php';

    /**
     * @psalm-suppress MissingReturnType
     */
    public function boot(Router $router)
    {
        $this->publish();

        $this->registerCommands();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->registerMiddleware($router);

        $this->registerListeners();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'chaski-laravel');

        $this->registerTranslations();

        $this->morphMaps();

        $sentEmailModelClass = config('chaski.models.sent_email');
        MailTracker::useSentEmailModel($sentEmailModelClass);
    }

    /**
     * @psalm-suppress MixedArgument
     */
    public function register()
    {
        $this->mergeConfigFrom(static::CONFIG_FILE, 'chaski');
        $this->mergeConfigFrom(static::CONFIG__MAIL_TRACKER_FILE, 'mail-tracker');

        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    private function publish(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                self::CONFIG_FILE => config_path('chaski.php'),
                self::CONFIG__MAIL_TRACKER_FILE => config_path('mail-tracker.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../database/migrations/' => database_path('migrations'),
            ], 'migrations');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/chaski-views'),
            ], 'views');

            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/chaski'),
            ], 'translations');
        }
    }

    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateAccepts::class,
            ]);
        }
    }

    public function registerMiddleware(Router $router): void
    {
        $router->aliasMiddleware('tripwire.honeypotwire', Honeypot::class);
    }


    public function registerListeners(): void
    {
        //        $this->app['events']->listen(TripwireBlockedEvent::class, NotifyAdmin::class);
    }

    public function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'chaski');
    }

    private function morphMaps()
    {
//        $logModelpath = config('chaski.models.log');
//        $sections = explode('\\', $logModelpath);
//        $LogModelName = end($sections);
//
//        $blockModelpath = config('chaski.models.block');
//        $sections = explode('\\', $blockModelpath);
//        $blockModelName = end($sections);
//
//        Relation::enforceMorphMap([
//            $LogModelName => $logModelpath,
//            $blockModelName => $blockModelpath,
//        ]);
    }
}
