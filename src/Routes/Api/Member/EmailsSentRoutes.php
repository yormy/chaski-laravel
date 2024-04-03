<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Routes\Api\Member;

use Illuminate\Support\Facades\Route;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\User\UserEmailsSentController;

class EmailsSentRoutes
{
    public static function register(): void
    {
        Route::macro('ChaskiEmailsSentApiRoutes', function (string $prefix = ''): void {
            Route::prefix($prefix)
                ->name('chaski.')
                ->group(function (): void {
                    Route::prefix('emails')
                        ->name('emails.')
                        ->group(function (): void {
                            Route::get('/', [UserEmailsSentController::class, 'index'])->name('sent.index');
                            Route::put('/mark-opened/{xid}', [UserEmailsSentController::class, 'markOpened'])->name('mark-opened');

                            Route::get('/xid/{xid}', [UserEmailsSentController::class, 'getEmailContentsByXid'])->name('email-show-xid');
                            Route::get('/uuid/{uuid}', [UserEmailsSentController::class, 'getEmailContentsByUuid'])->name('email-show-uuid');
                        });
                });
        });
    }
}
