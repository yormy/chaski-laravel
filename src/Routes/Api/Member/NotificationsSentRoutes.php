<?php

namespace Yormy\ChaskiLaravel\Routes\Api\Member;

use Illuminate\Support\Facades\Route;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\Member\NotificationsSentController;

class NotificationsSentRoutes
{
    public static function register(): void
    {
        Route::macro('ChaskiNotificationsSentApiRoutes', function (string $prefix = '') {
            Route::prefix($prefix)
                ->name('chaski.')
                ->group(function () {

                    Route::prefix('notifications')
                        ->name('notifications.')
                        ->group(function () {
                            Route::get('/', [NotificationsSentController::class, 'index'])->name('index');
                            Route::put('/mark-opened/{id}', [NotificationsSentController::class, 'markOpened'])->name('mark-opened');
                        });

                });
        });

        /**
         * These routes will be polled every x time, so they need to not be rate-limited
         */
        Route::macro('ChaskiNotificationsSentApiPollingRoutes', function (string $prefix = '') {
            Route::prefix($prefix)
                ->name('chaski.')
                ->group(function () {
                    Route::prefix('notifications')
                        ->name('notifications.')
                        ->group(function () {
                            Route::get('/attention', [NotificationsSentController::class, 'attention'])->name('attention');
                        });

                });
        });

    }
}
