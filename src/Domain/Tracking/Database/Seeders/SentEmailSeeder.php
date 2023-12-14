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
        $member = Member::where('id', 1)->first();
        SentEmail::factory()->forMember($member)->create();

        $admin = Admin::where('id', 1)->first();
        SentEmail::factory()->forAdmin($admin)->create();
    }
}
