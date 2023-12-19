<?php

namespace Yormy\ChaskiLaravel\Domain\Tracking\Database\Seeders;

use Illuminate\Database\Seeder;

use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmail;
use Mexion\BedrockUsersv2\Domain\User\Models\Member;
use Mexion\BedrockUsersv2\Domain\User\Models\Admin;

class SentEmailSeeder extends Seeder
{
    public function run()
    {
        $this->memberEmailSeeder();
        $this->adminEmailSeeder();
    }

    private function memberEmailSeeder()
    {
        $member = Member::where('id', 1)->first();
        SentEmail::factory()->forMember($member)->create();

        $member = Member::where('id', 2)->first();
        SentEmail::factory(2)->forMember($member)->create();
    }

    private function adminEmailSeeder()
    {
        $admin = Admin::where('id', 1)->first();
        SentEmail::factory()->forAdmin($admin)->create();

        $admin = Admin::where('id', 2)->first();
        SentEmail::factory(2)->forAdmin($admin)->create();

    }
}
