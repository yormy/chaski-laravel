<?php

namespace Yormy\ChaskiLaravel\Routes;

use Illuminate\Support\Facades\Route;
use Yormy\ChaskiLaravel\Http\Controllers\BlockController;
use Yormy\ChaskiLaravel\Http\Controllers\LogController;
use Yormy\ChaskiLaravel\Http\Controllers\ResetController;

class AdminRoutes
{
    public static function register(): void
    {
//        Route::macro('TripwireAdminRoutes', function (string $prefix = '') {
//            Route::prefix($prefix)->name($prefix ? $prefix.'.' : '')->group(function () {
//
//                Route::prefix('')
//                    ->name('tripwire.')
//                    ->group(function () {
//
//                        Route::prefix('admin')
//                            ->name('admin.')
////                            ->middleware("guest")
//                            ->group(function () {
//                                Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
//                                Route::get('/reset-key', [ResetController::class, 'getKey'])->name('reset-key');
//                                Route::get('/blocks', [BlockController::class, 'index'])->name('blocks.index');
//                                Route::get('/blocks/{block}', [BlockController::class, 'show'])->name('blocks.show');
//                            });
//                    });
//            });
//        });
    }
}
