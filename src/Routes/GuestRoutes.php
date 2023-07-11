<?php

namespace Yormy\ChaskiLaravel\Routes;

use Illuminate\Support\Facades\Route;
use Yormy\ChaskiLaravel\Http\Controllers\ResetController;
use Yormy\ChaskiLaravel\Http\Middleware\ValidateSignature;

class GuestRoutes
{
    public static function register(): void
    {
        //        Route::macro('TripwireResetRoutes', function (string $prefix = '') {
        //            if (config('tripwire.reset.enabled', false)) {
        //                Route::prefix($prefix)->name($prefix ? $prefix.'.' : '')->group(function () {
        //
        //                    Route::prefix('')
        //                        ->name('tripwire.')
        //                        ->group(function () {
        //
        //                            Route::prefix('guest')
        //                                ->name('guest.')
        //                                ->middleware(ValidateSignature::class)
        //                                ->group(function () {
        //                                    Route::get('/reset', [ResetController::class, 'reset'])->name('logs.reset');
        //                                });
        //                        });
        //                });
        //            }
        //        });
    }
}
