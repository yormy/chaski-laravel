<?php

namespace Yormy\ChaskiLaravel\Actions;

use Yormy\ChaskiLaravel\Actions\Interfaces\ActionInterface;

class BlockIpAction implements ActionInterface
{
    public static function exec(): void
    {
        //
        dd('blockIP');
    }
}
