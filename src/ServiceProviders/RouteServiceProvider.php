<?php

namespace Yormy\ChaskiLaravel\ServiceProviders;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Yormy\ChaskiLaravel\Routes\AdminRoutes;
use Yormy\ChaskiLaravel\Routes\GuestRoutes;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        $this->map();

    }

    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    protected function mapWebRoutes(): void
    {
        AdminRoutes::register();
        GuestRoutes::register();
    }

    protected function mapApiRoutes(): void
    {
    }
}
