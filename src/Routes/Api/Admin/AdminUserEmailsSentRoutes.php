<?php

namespace Yormy\ChaskiLaravel\Routes\Api\Admin;

use Illuminate\Support\Facades\Route;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\UserManagement\Admins\AdminAdminEmailsSentController;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\UserManagement\Members\AdminMemberEmailsSentController;

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
                            Route::get('/xid/{xid}', [AdminMemberEmailsSentController::class, 'getEmailContentsByXid'])->name('email-show-xid');
                            Route::get('/uuid/{uuid}', [AdminMemberEmailsSentController::class, 'getEmailContentsByUuid'])->name('email-show-uuid');
                            Route::get('/{member_xid}', [AdminMemberEmailsSentController::class, 'index'])->name('sent.index');
                        });
                });
        });

        Route::macro('ChaskiAdminAdminEmailsSentApiRoutes', function (string $prefix = '') {
            Route::prefix($prefix)
                ->name('chaski.')
                ->group(function () {

                    Route::prefix('emails')
                        ->name('emails.')
                        ->group(function () {
                            Route::get('/xid/{xid}', [AdminAdminEmailsSentController::class, 'getEmailContentsByXid'])->name('email-show-xid');
                            Route::get('/uuid/{uuid}', [AdminAdminEmailsSentController::class, 'getEmailContentsByUuid'])->name('email-show-uuid');
                            Route::get('/{admin_xid}', [AdminAdminEmailsSentController::class, 'index'])->name('sent.index');
                        });
                });
        });
    }
}
