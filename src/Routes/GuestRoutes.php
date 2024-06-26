<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Routes;

use Illuminate\Support\Facades\Route;
use Yormy\ChaskiLaravel\Domain\Subscription\Http\Controllers\UnsubscribeController;

class GuestRoutes
{
    public static function register(): void
    {
        Route::macro('ChaskiUnsubscribeRoutes', function (string $prefix = ''): void {
            Route::prefix($prefix)
                ->name('chaski.')
                ->group(function (): void {
                    Route::prefix('email')
                        ->name('email.')
                        ->group(function (): void {
                            Route::get('/u/{token}', [UnsubscribeController::class, 'unsubscribe'])->name('unsubscribe');
                        });
                });
        });
    }
}
