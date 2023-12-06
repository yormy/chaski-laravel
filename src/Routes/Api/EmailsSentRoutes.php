<?php

namespace Yormy\ChaskiLaravel\Routes\Api;

use Illuminate\Support\Facades\Route;
use Mexion\BedrockUsersv2\Domain\User\Http\Controllers\Api\V1\User\UserNotificationsController;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\SentEmailController;

class EmailsSentRoutes
{
    public static function register(): void
    {
        Route::macro('ChaskiEmailsSentApiRoutes', function (string $prefix = '') {
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
    }
}
