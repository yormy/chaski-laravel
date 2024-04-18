<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Database\Seeders;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Seeder;
use Yormy\ChaskiLaravel\Domain\Tracking\Database\Seeders\NotificationSentSeeder;
use Yormy\ChaskiLaravel\Domain\Tracking\Database\Seeders\SentEmailSeeder;

class MainChaskiSeeder extends Seeder
{
    public function run(Authenticatable $memberModel, Authenticatable $adminModel): void
    {
        (new SentEmailSeeder())->run($memberModel, $adminModel);
        (new NotificationSentSeeder())->run($memberModel, $adminModel);
    }
}
