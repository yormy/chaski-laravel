<?php

namespace Yormy\ChaskiLaravel\Routes;

use Illuminate\Support\Facades\Route;
use Yormy\ChaskiLaravel\Http\Controllers\ResetController;
use Yormy\ChaskiLaravel\Http\Middleware\ValidateSignature;
use Yormy\ChaskiLaravel\Subscriptions\Http\Controllers\UnsubscribeController;

class GuestRoutes
{
    public static function register(): void
    {
        Route::macro('ChaskiUnsubscribeRoutes', function (string $prefix = '') {
            Route::prefix('')
                ->name('chaski.')
                ->group(function () {

                    Route::prefix('email')
                        ->name('email.')
                        ->group(function () {
                            Route::get('/u/{token}', [UnsubscribeController::class, 'unsubscribe'])->name('unsubscribe');
                        });
                });
        });
    }
}
