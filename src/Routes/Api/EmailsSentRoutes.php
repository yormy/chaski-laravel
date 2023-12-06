<?php

namespace Yormy\ChaskiLaravel\Routes\Api;

use Illuminate\Support\Facades\Route;
use Mexion\BedrockUsersv2\Domain\User\Http\Controllers\Api\V1\User\UserNotificationsController;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\EmailsSentController;

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
                            Route::get('/', [EmailsSentController::class, 'index'])->name('sent.index');
                            Route::put('/mark-opened/{xid}', [EmailsSentController::class, 'markOpened'])->name('mark-opened');

                            Route::get('/xid/{xid}', [EmailsSentController::class, 'getEmailContentsByXid'])->name('email-show-xid');
                            Route::get('/uuid/{uuid}', [EmailsSentController::class, 'getEmailContentsByUuid'])->name('email-show-uuid');
                        });
                });
        });
    }
}
