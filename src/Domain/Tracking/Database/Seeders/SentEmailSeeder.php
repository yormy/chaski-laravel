<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Database\Seeders;

use Illuminate\Database\Seeder;
use Mexion\BedrockUsersv2\Domain\User\Models\Admin;
use Mexion\BedrockUsersv2\Domain\User\Models\Member;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmail;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmailLog;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmailUrlClicked;

class SentEmailSeeder extends Seeder
{
    public function run(): void
    {
        $this->memberEmailSeeder();
        $this->adminEmailSeeder();
    }

    private function memberEmailSeeder(): void
    {
        $member = Member::where('id', 1)->first();
        SentEmail::factory()
            ->forMember($member)
            ->has(SentEmailUrlClicked::factory()->count(rand(1, 5)), 'urlsClicked')
            ->has(SentEmailLog::factory()->count(rand(1, 5)), 'logs')
            ->create();

        $member = Member::where('id', 2)->first();
        SentEmail::factory(2)
            ->forMember($member)
            ->has(SentEmailUrlClicked::factory()->count(rand(1, 5)), 'urlsClicked')
            ->has(SentEmailLog::factory()->count(rand(1, 5)), 'logs')
            ->create();
    }

    private function adminEmailSeeder(): void
    {
        $admin = Admin::where('id', 1)->first();
        SentEmail::factory()
            ->forAdmin($admin)
            ->has(SentEmailUrlClicked::factory()->count(rand(1, 5)), 'urlsClicked')
            ->has(SentEmailLog::factory()->count(rand(1, 5)), 'logs')
            ->create();

        $admin = Admin::where('id', 2)->first();
        SentEmail::factory(2)
            ->forAdmin($admin)
            ->has(SentEmailUrlClicked::factory()->count(rand(1, 5)), 'urlsClicked')
            ->has(SentEmailLog::factory()->count(rand(1, 5)), 'logs')
            ->create();
    }
}
