<?php

namespace Yormy\ChaskiLaravel\Tests\Unit;

use Illuminate\Support\Facades\Notification;
use Yormy\ChaskiLaravel\Domain\Create\Notifications\TestMailable;
use Yormy\ChaskiLaravel\Domain\Create\Notifications\TestNotification;
use Yormy\ChaskiLaravel\Tests\TestCase;
use Yormy\ChaskiLaravel\Tests\Traits\ConfigMailTrait;
use Yormy\ChaskiLaravel\Tests\Traits\UserTrait;
use Yormy\ChaskiLaravel\Tests\Unit\Domain\Create\Parsing\Traits\EmailParsingTrait;

class SendNotificationTest extends TestCase
{
    use ConfigMailTrait;
    use EmailParsingTrait;
    use UserTrait;

    /**
     * @test
     *
     * @group chaski-send
     */
    public function SendNotification(): void
    {
        $this->configMail();
        $this->createTemplate();
        $user = $this->createUser();

        Notification::fake();
        Notification::assertNothingSent();
        $user->notify(new TestNotification()); // default stored in log (mail log driver
    }

    /**
     * @test
     *
     * @group chaski-send
     */
    public function User_Send_notification_Notification_Sent(): void
    {
        $this->configMail();

        $user = $this->createUser();

        Notification::fake();
        Notification::assertNothingSent();
        $user->notify(new TestNotification()); // default stored in log (mail log driver

        Notification::assertSentTo([$user], TestNotification::class);
    }

    /**
     * @test
     *
     * @group chaski-send
     */
    public function User_Send_notification_mail_Mail_Sent(): void
    {
        $this->configMail();

        $user = $this->createUser();

        Notification::fake();

        $user->notify(new TestNotification()); // default stored in log (mail log driver

        $object = TestMailable::class;
        Notification::assertSentTo($user, TestNotification::class, function ($notification, $channels, $user) use ($object) {
            $this->assertContains('mail', $channels);

            $mailData = $notification->toMail($user);

            $this->assertTrue($mailData instanceof $object);

            return true;
        });
    }
}
