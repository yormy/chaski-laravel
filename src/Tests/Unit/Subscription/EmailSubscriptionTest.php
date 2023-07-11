<?php

namespace Yormy\ChaskiLaravel\Tests\Unit\Subscription;

use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use jdavidbakr\MailTracker\MailTracker;
use jdavidbakr\MailTracker\MailTrackerController;
use jdavidbakr\MailTracker\Model\SentEmail;
use jdavidbakr\MailTracker\Model\SentEmailUrlClicked;
use LiranCo\NotificationSubscriptions\Events\NotificationSuppressed;
use Symfony\Component\Mime\Email;
use Yormy\ChaskiLaravel\Models\MailTracker\SentEmailLog;
use Yormy\ChaskiLaravel\Notifications\TestTemplateNotification;
use Yormy\ChaskiLaravel\Tests\TestCase;
use Yormy\ChaskiLaravel\Tests\Traits\ConfigMailTrait;
use Yormy\ChaskiLaravel\Tests\Traits\UserTrait;
use Yormy\ChaskiLaravel\Tests\Unit\Parsing\Traits\EmailParsingTrait;

class EmailSubscriptionTest extends TestCase
{
    use ConfigMailTrait;
    use UserTrait;
    use EmailParsingTrait;

    public function SetUp(): void
    {
        parent::SetUp();

        $this->createTemplate();
        $this->notifiable = $this->createUser();
    }


    /**
     * @test
     * @group chaski-subscription
     */
    public function Send_notification_Not_Unsubscribed_Send(): void
    {
        $this->configMail();
        $this->createTemplate();
        $user = $this->createUser();

        $data = $this->createNotificationData();

        Notification::fake();

        $user->notify(new TestTemplateNotification($data));

        Notification::assertSentTo($user, TestTemplateNotification::class);
    }


    /**
     * @test
     * @group subscription
     */
    public function Send_notification_Unsubscribed_Not_send(): void
    {
        $this->configMail();
        $this->createTemplate();
        $user = $this->createUser();

        $data = $this->createNotificationData();

        Event::fake([
            NotificationSuppressed::class,
        ]);

        $user->unsubscribe(TestTemplateNotification::class);
        $user->refresh();
        $user->notify(new TestTemplateNotification($data));

        Event::assertDispatched(NotificationSuppressed::class);
    }
}
