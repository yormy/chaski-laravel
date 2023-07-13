<?php

namespace Yormy\ChaskiLaravel\Tests\Unit\Subscription;

use Illuminate\Support\Facades\Event;
use LiranCo\NotificationSubscriptions\Models\NotificationSubscription;
use Yormy\ChaskiLaravel\Notifications\TestTemplateNotification;
use Yormy\ChaskiLaravel\Subscription\Actions\UnsubscribeAction;
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

        $this->createTemplate();
        $this->notifiable = $this->createUser();
    }

    /**
     * @test
     *
     * @group chaski-unsubscribe1
     */
    public function Email_unsubscribable_sent_Click_unsubscribe_Failed(): void
    {
        $this->configMail();
        $this->createTemplate();

        $data = $this->createNotificationData();

        Event::fake([
            UnsubscribePrevented::class,
            UnsubscribeCompleted::class,
        ]);

        $unsubscribeToken = $this->sendEmailAndGetToken();
        $result = UnsubscribeAction::execute($unsubscribeToken);

        Event::assertDispatched(UnsubscribePrevented::class);
        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @group chaski-unsubscribe
     */
    public function Email_sent_Click_subscribe_Success(): void
    {
        $this->configMail();

        $this->createTemplate();

        $data = $this->createNotificationData();

        Event::fake([
            UnsubscribeCompleted::class,
        ]);

        $unsubscribeToken = $this->sendEmailAndGetToken();
        $result = UnsubscribeAction::execute($unsubscribeToken);

        $lastUnsubscribe = NotificationSubscription::latest()->first();
        $this->assertEquals($lastUnsubscribe->notifiable_type, get_class($this->notifiable));
        $this->assertEquals($lastUnsubscribe->notifiable_id, $this->notifiable->id);
        $this->assertEquals($lastUnsubscribe->type, TestTemplateNotification::class);

        Event::assertDispatched(UnsubscribeCompleted::class);
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

