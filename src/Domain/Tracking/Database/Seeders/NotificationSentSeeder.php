<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Database\Seeders;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Seeder;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\NotificationSent;

class NotificationSentSeeder extends Seeder
{
    public function run(Authenticatable $memberModel, Authenticatable $adminModel): void
    {
        $this->memberNotifications($memberModel);
        $this->adminNotifications($adminModel);
    }

    private function memberNotifications(Authenticatable $memberModel): void
    {
        $member = $memberModel->where('id', 1)->first();
        NotificationSent::factory(2)->forMember($member)->create();
        NotificationSent::factory(3)->forMemberWithEmail($member)->create();

        $member = Member::where('id', 2)->first();
        NotificationSent::factory(1)->forMember($member)->create();
        NotificationSent::factory(1)->forMemberWithEmail($member)->create();
    }

    private function adminNotifications(Authenticatable $adminModel): void
    {
        $admin = $adminModel->where('id', 1)->first();
        NotificationSent::factory(20)->forAdmin($admin)->create();
        NotificationSent::factory(10)->forAdminWithEmail($admin)->create();

        $admin = Admin::where('id', 2)->first();
        NotificationSent::factory(20)->forAdmin($admin)->create();
        NotificationSent::factory(10)->forAdminWithEmail($admin)->create();
    }
}
