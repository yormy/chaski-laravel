<?php

namespace Yormy\ChaskiLaravel\Tests\Unit\Subscription;

use Illuminate\Support\Facades\Event;
use LiranCo\NotificationSubscriptions\Models\NotificationSubscription;
use Yormy\ChaskiLaravel\Notifications\TestTemplateNotification;
use Yormy\ChaskiLaravel\Subscription\Observers\Events\UnsubscribeFailed;
use Yormy\ChaskiLaravel\Subscription\Services\UnsubscribeService;
use Yormy\ChaskiLaravel\Subscription\Observers\Events\UnsubscribeCompleted;
use Yormy\ChaskiLaravel\Subscription\Observers\Events\UnsubscribePrevented;
use Yormy\ChaskiLaravel\Tests\TestCase;
use Yormy\ChaskiLaravel\Tests\Traits\ConfigMailTrait;
use Yormy\ChaskiLaravel\Tests\Traits\UserTrait;
use Yormy\ChaskiLaravel\Tests\Unit\Parsing\Traits\EmailParsingTrait;

class UnsubscribeTest extends TestCase
{
    use ConfigMailTrait;
    use UserTrait;
    use EmailParsingTrait;

    public function SetUp(): void
    {
        parent::SetUp();

        $this->notifiable = $this->createUser();
    }

    /**
     * @test
     *
     * @group chaski-unsubscribe
     */
    public function Email_sent_Click_unsubscribe_Success(): void
    {
        $this->configMail();

        $this->createTemplate();

        $data = $this->createNotificationData();

        Event::fake([
            UnsubscribeCompleted::class,
        ]);

        $unsubscribeToken = $this->sendEmailAndGetToken();

        $unsubscribe = new UnsubscribeService($unsubscribeToken);
        $view = $unsubscribe->execute();
        $this->assertEquals(config('chaski.unsubscribe_view.success'), $view);

        $lastUnsubscribe = NotificationSubscription::latest()->first();
        $this->assertEquals($lastUnsubscribe->notifiable_type, get_class($this->notifiable));
        $this->assertEquals($lastUnsubscribe->notifiable_id, $this->notifiable->id);
        $this->assertEquals($lastUnsubscribe->type, TestTemplateNotification::class);

        Event::assertDispatched(UnsubscribeCompleted::class);
    }

    /**
     * @test
     *
     * @group chaski-unsubscribe
     */
    public function Email_sent_Click_unsubscribe_invalid_token_Failed(): void
    {
        $this->configMail();

        $this->createTemplate();

        $data = $this->createNotificationData();

        Event::fake([
            UnsubscribeFailed::class,
        ]);

        $unsubscribeCountStart = NotificationSubscription::count();

        $unsubscribeToken = $this->sendEmailAndGetToken();

        $unsubscribe = new UnsubscribeService('invalid');
        $view = $unsubscribe->execute();
        $this->assertEquals(config('chaski.unsubscribe_view.invalid_token'), $view);

        Event::assertDispatched(UnsubscribeFailed::class);

        $unsubscribeCountEnd = NotificationSubscription::count();
        $this->assertEquals($unsubscribeCountStart, $unsubscribeCountEnd);
    }


    /**
     * @test
     *
     * @group chaski-unsubscribe
     */
    public function Email_sent_prevent_unsubscribe_Click_unsubscribe_Prevented(): void
    {
        $this->configMail();

        $this->createTemplate(['mail_preventable' => false]);

        $data = $this->createNotificationData();

        Event::fake([
            UnsubscribePrevented::class,
        ]);

        $unsubscribeCountStart = NotificationSubscription::count();
        $unsubscribeToken = $this->sendEmailAndGetToken();

        $unsubscribe = new UnsubscribeService($unsubscribeToken);
        $view = $unsubscribe->execute();

        $this->assertEquals(config('chaski.unsubscribe_view.prevented'), $view);

        Event::assertDispatched(UnsubscribePrevented::class);

        $unsubscribeCountEnd = NotificationSubscription::count();
        $this->assertEquals($unsubscribeCountStart, $unsubscribeCountEnd);
    }


    // ---------- HELPERS ----------
    private function sendEmailAndGetToken(): string
    {
        $htmlEmailEnglish = $this->createHtmlView();

        $unsubscribeLinkMatch = $this->getTrackables($htmlEmailEnglish);
        if (isset($unsubscribeLinkMatch[0])) {
            $unsubscribeToken = $unsubscribeLinkMatch[0];
        }
        return urldecode($unsubscribeToken);

        return 'eyJpdiI6Im1pM1UyNC9DYzB3UW81ZFhtaldPdHc9PSIsInZhbHVlIjoiYzliK2xGc0k1WFlSSWZZRjI4WjJadz09IiwibWFjIjoiMzgyYTU1MWJiM2JkMmYzMzg5OThhZWFjNjIyYjJkODRiYWMxNzRhMTQ1NzIzMTI4Y2Y5MmUzZGU2Y2FjNDBiZCIsInRhZyI6IiJ9-VRLtÆpviR9ÆJnHmWTkT3uA364';
    }

    private function getTrackables(string $injectedHtml): array
    {
        $domain = 'testapp.local';
        $pattern = "#http[s]*:\/\/$domain\/email\/u\/(.*)\"#sU";
        preg_match_all($pattern, $injectedHtml, $matches);

        return $matches[1];
    }

}

