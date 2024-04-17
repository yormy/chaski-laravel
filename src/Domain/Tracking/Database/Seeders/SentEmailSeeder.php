<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Database\Seeders;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Seeder;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmail;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmailLog;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmailUrlClicked;

class SentEmailSeeder extends Seeder
{
    public function run(Authenticatable $memberModel, Authenticatable $adminModel): void
    {
        $this->memberEmailSeeder($memberModel);
        $this->adminEmailSeeder($adminModel);
    }

    private function memberEmailSeeder(Authenticatable $memberModel): void
    {
        $member = $memberModel->where('id', 1)->first();
        SentEmail::factory()
            ->forMember($member)
            ->has(SentEmailUrlClicked::factory()->count(rand(1, 5)), 'urlsClicked')
            ->has(SentEmailLog::factory()->count(rand(1, 5)), 'logs')
            ->create();

        $member = $memberModel->where('id', 2)->first();
        SentEmail::factory(2)
            ->forMember($member)
            ->has(SentEmailUrlClicked::factory()->count(rand(1, 5)), 'urlsClicked')
            ->has(SentEmailLog::factory()->count(rand(1, 5)), 'logs')
            ->create();
    }

    private function adminEmailSeeder(Authenticatable $adminModel): void
    {
        $admin = $adminModel->where('id', 1)->first();
        SentEmail::factory()
            ->forAdmin($admin)
            ->has(SentEmailUrlClicked::factory()->count(rand(1, 5)), 'urlsClicked')
            ->has(SentEmailLog::factory()->count(rand(1, 5)), 'logs')
            ->create();

        $admin = $adminModel->where('id', 2)->first();
        SentEmail::factory(2)
            ->forAdmin($admin)
            ->has(SentEmailUrlClicked::factory()->count(rand(1, 5)), 'urlsClicked')
            ->has(SentEmailLog::factory()->count(rand(1, 5)), 'logs')
            ->create();
    }
}
