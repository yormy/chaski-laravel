<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Database\Seeders;

use Illuminate\Database\Seeder;
use Yormy\ChaskiLaravel\Domain\Tracking\Database\Seeders\SentEmailSeeder;

class MainChaskiSeeder extends Seeder
{
    public function run(): void
    {
        (new SentEmailSeeder())->run();
    }
}
