<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\ServiceProviders;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Yormy\ChaskiLaravel\Routes\Api\Admin\AdminUserEmailsSentRoutes;
use Yormy\ChaskiLaravel\Routes\Api\Admin\AdminUserNotificationsSentRoutes;
use Yormy\ChaskiLaravel\Routes\Api\Member\EmailsSentRoutes;
use Yormy\ChaskiLaravel\Routes\Api\Member\NotificationsSentRoutes;
use Yormy\ChaskiLaravel\Routes\GuestRoutes;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
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
        GuestRoutes::register();
    }

    protected function mapApiRoutes(): void
    {
        EmailsSentRoutes::register();
        NotificationsSentRoutes::register();

        AdminUserEmailsSentRoutes::register();
        AdminUserNotificationsSentRoutes::register();
    }
}
