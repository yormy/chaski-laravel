<?php

namespace Yormy\ChaskiLaravel\Actions;

use Yormy\ChaskiLaravel\Actions\Interfaces\ActionInterface;

class BlockAccountAction implements ActionInterface
{
    public static function exec(): void
    {
        //event(new TripwireBlockedAccount()); ?
        dd('block account');
    }
}
