<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Routes\Api\Member;

use Illuminate\Support\Facades\Route;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\User\UserNewMessagesController;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\User\UserNotificationsSentController;

class NotificationsSentRoutes
{
    public static function register(): void
    {
        Route::macro('ChaskiNotificationsSentApiRoutes', function (string $prefix = '') {
            Route::prefix($prefix)
                ->name('chaski.')
                ->group(function () {

                    Route::prefix('messages')
                        ->name('messages.')
                        ->group(function () {
                            Route::get('/', [UserNewMessagesController::class, 'index'])->name('index');
                        });

                    Route::prefix('notifications')
                        ->name('notifications.')
                        ->group(function () {
                            Route::get('/', [UserNotificationsSentController::class, 'index'])->name('index');
                            Route::put('/mark-opened/{id}', [UserNotificationsSentController::class, 'markOpened'])->name('mark-opened');
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
                            Route::get('/attention', [UserNotificationsSentController::class, 'attention'])->name('attention');
                        });

                });
        });

    }
}
