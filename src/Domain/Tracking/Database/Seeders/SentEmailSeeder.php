<?php

namespace Yormy\ChaskiLaravel\Domain\Tracking\Database\Seeders;

use Illuminate\Database\Seeder;

use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmail;

class SentEmailSeeder extends Seeder
{
    public function run()
    {
        SentEmail::factory()->create();

        SentEmail::factory()->forAdmin()->create();
    }
}
