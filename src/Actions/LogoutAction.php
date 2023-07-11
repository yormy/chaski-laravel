<?php

namespace Yormy\ChaskiLaravel\Actions;

use Yormy\ChaskiLaravel\Actions\Interfaces\ActionInterface;

class LogoutAction implements ActionInterface
{
    public static function exec(): void
    {
        dd('do logoout, to implement');
    }
}
