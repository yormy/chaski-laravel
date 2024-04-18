<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Tests;

class TestConfig
{
    public static function setup(): void
    {
        config(['tripwire' => require __DIR__.'/../config/chaski.php']);
        config(['app.key' => 'base64:yNmpwO5YE6xwBz0enheYLBDslnbslodDqK1u+oE5CEE=']);
        config(['mail.default' => 'log']);

        config(['app.url' => 'https://hhh.conm']);
    }
}
