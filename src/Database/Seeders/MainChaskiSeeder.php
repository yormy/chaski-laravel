<?php

namespace Yormy\ChaskiLaravel\Database\Seeders;

use Illuminate\Database\Seeder;
use Yormy\ChaskiLaravel\Domain\Tracking\Database\Seeders\SentEmailSeeder;

class MainChaskiSeeder extends Seeder
{
    public function run()
    {
        (new SentEmailSeeder())->run();
    }
}
