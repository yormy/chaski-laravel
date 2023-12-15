<?php

namespace Yormy\ChaskiLaravel\Routes\Api\Admin;

use Illuminate\Support\Facades\Route;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\Admin\AdminUserEmailsSentController;

class AdminUserEmailsSentRoutes
{
    public static function register(): void
    {
        Route::macro('ChaskiAdminUserEmailsSentApiRoutes', function (string $prefix = '') {
            Route::prefix($prefix)
                ->name('chaski.')
                ->group(function () {

                    Route::prefix('emails')
                        ->name('emails.')
                        ->group(function () {
                            Route::get('/xid/{xid}', [AdminUserEmailsSentController::class, 'getEmailContentsByXid'])->name('email-show-xid');
                            Route::get('/uuid/{uuid}', [AdminUserEmailsSentController::class, 'getEmailContentsByUuid'])->name('email-show-uuid');
                            Route::get('/{member_xid}', [AdminUserEmailsSentController::class, 'index'])->name('sent.index');
                        });
                });
        });
    }
}
