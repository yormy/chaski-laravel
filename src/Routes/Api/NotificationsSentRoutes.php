<?php

namespace Yormy\ChaskiLaravel\Routes\Api;

use Illuminate\Support\Facades\Route;
use Mexion\BedrockUsersv2\Domain\User\Http\Controllers\Api\V1\User\UserNotificationsController;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\NotificationsSentController;

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
                            Route::get('/attention', [NotificationsSentController::class, 'attention'])->name('attention'); // user
                            Route::put('/mark-opened/{id}', [NotificationsSentController::class, 'markOpened'])->name('mark-opened');
                        });

                });
        });
    }
}
