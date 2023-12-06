<?php

namespace Yormy\ChaskiLaravel\Routes\Api;

use Illuminate\Support\Facades\Route;
use Mexion\BedrockUsersv2\Domain\User\Http\Controllers\Api\V1\User\UserNotificationsController;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\SentEmailController;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\SentNotificationsController;

class SentEmailRoutes
{
    public static function register(): void
    {
        Route::macro('ChaskiSentEmailApiRoutes', function (string $prefix = '') {
            Route::prefix($prefix)
                ->name('chaski.')
                ->group(function () {

                    Route::prefix('emails')
                        ->name('emails.')
                        ->group(function () {
                            Route::get('/', [SentEmailController::class, 'index'])->name('sent.index');
                            Route::put('/mark-opened/{xid}', [SentEmailController::class, 'markOpened'])->name('mark-opened');

                            Route::get('/xid/{xid}', [SentEmailController::class, 'getEmailContentsByXid'])->name('email-show-xid');
                            Route::get('/uuid/{uuid}', [SentEmailController::class, 'getEmailContentsByUuid'])->name('email-show-uuid');
                        });
                });
        });

        Route::macro('ChaskiSentNotificationsApiRoutes', function (string $prefix = '') {
            Route::prefix($prefix)
                ->name('chaski.')
                ->group(function () {

                    Route::prefix('notifications')
                        ->name('notifications.')
                        ->group(function () {
                            Route::get('/', [SentNotificationsController::class, 'index'])->name('index');
                            Route::get('/attention', [SentNotificationsController::class, 'attention'])->name('attention'); // user
                            Route::put('/mark-opened/{id}', [SentNotificationsController::class, 'markOpened'])->name('mark-opened');
                        });

                });
        });
    }
}
