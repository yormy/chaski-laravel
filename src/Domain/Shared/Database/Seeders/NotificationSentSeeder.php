<?php

namespace Yormy\ChaskiLaravel\Domain\Shared\Database\Seeders;


use Illuminate\Database\Seeder;
use Mexion\BedrockUsersv2\Domain\Standby\Models\StandbyReason;
use Mexion\BedrockUsersv2\Domain\User\Models\PersonalAccessToken;
use Mexion\TestappCore\Domain\Billing\Database\Seeders\BillingMainSeeder;
use Yormy\ChaskiLaravel\Domain\Shared\Models\NotificationSent;

class NotificationSentSeeder extends Seeder
{
    public function run()
    {
        NotificationSent::factory()->create();
    }
}
