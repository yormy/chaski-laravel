<?php

namespace Yormy\ChaskiLaravel\Routes\Api\Admin;

use Illuminate\Support\Facades\Route;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\UserManagement\AdminAdminNotificationsSentController;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\UserManagement\AdminUserNotificationsSentController;

class AdminUserNotificationsSentRoutes
{
    public static function register(): void
    {
        Route::macro('ChaskiAdminUserNotificationsSentApiRoutes', function (string $prefix = '') {
            Route::prefix($prefix)
                ->name('chaski.')
                ->group(function () {

                    Route::prefix('notifications')
                        ->name('notifications.')
                        ->group(function () {
                            Route::get('/{member_xid}', [AdminUserNotificationsSentController::class, 'index'])->name('index');
                        });

                });
        });

        Route::macro('ChaskiAdminAdminNotificationsSentApiRoutes', function (string $prefix = '') {
            Route::prefix($prefix)
                ->name('chaski.')
                ->group(function () {

                    Route::prefix('notifications')
                        ->name('notifications.')
                        ->group(function () {
                            Route::get('/{admin_xid}', [AdminAdminNotificationsSentController::class, 'index'])->name('index');
                        });

                });
        });
    }
}
