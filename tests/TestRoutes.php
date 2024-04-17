<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Tests;

use Illuminate\Support\Facades\Route;

class TestRoutes
{
    public static function setup()
    {
        Route::ChaskiUnsubscribeRoutes();
        Route::prefix('api/v1')
            ->name('api.v1.')
            ->group(function () {

                Route::prefix('member/account/')
                    ->name('member.account.')
                    ->group(function () {
                        Route::ChaskiNotificationsSentApiRoutes();
                    });
            });
    }
}
