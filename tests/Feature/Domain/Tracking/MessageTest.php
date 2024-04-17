<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Tests\Feature\Domain\Tracking;

use Yormy\AssertLaravel\Traits\RouteHelperTrait;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\NotificationSent;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmail;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmailLog;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmailUrlClicked;
use Yormy\ChaskiLaravel\Tests\TestCase;
use Yormy\ChaskiLaravel\Tests\Traits\UserTrait;

class MessageTest extends TestCase
{
    use RouteHelperTrait;
    use UserTrait;
    /**
     * @test
     * @group xxx
     *
     */
    public function GetCronScheduleLogs()
    {
        //$this->dumpRouteName('indexxx');
        $member = $this->createUser();
        $this->createSentEmails($member);


        $this->createSentNotifications($member);
        $response = $this->actingAs($member)->json('GET', route('api.v1.member.account.chaski.messages.index'));
        dd($response->getContent());



//        $response->assertJsonDataArrayHasElement('name', $commandName); // @phpstan-ignore-line
//        $createdTask->delete();
    }

    public function createSentEmails($member)
    {
        SentEmail::factory()
            ->forMember($member)
            ->has(SentEmailUrlClicked::factory()->count(rand(1, 5)), 'urlsClicked')
            ->has(SentEmailLog::factory()->count(rand(1, 5)), 'logs')
            ->create();
    }

    public function createSentNotifications($member)
    {
        NotificationSent::factory(2)->forMember($member)->create();
        NotificationSent::factory(3)->forMemberWithEmail($member)->create();
    }

}
