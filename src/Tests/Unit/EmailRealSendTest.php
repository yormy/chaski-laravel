<?php

namespace Yormy\ChaskiLaravel\Tests\Unit\Parsing;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Spatie\MailTemplates\Models\MailTemplate;
use Yormy\ChaskiLaravel\Notifications\TestTemplateNotification;
use Yormy\ChaskiLaravel\Services\StringableUser;
use Yormy\ChaskiLaravel\Tests\TestCase;
use Yormy\ChaskiLaravel\Tests\Traits\ConfigMailTrait;
use Yormy\ChaskiLaravel\Tests\Traits\UserTrait;
use Yormy\ChaskiLaravel\Tests\Unit\Parsing\Traits\EmailParsingTrait;

class EmailRealSendTest extends TestCase
{
    use ConfigMailTrait;
    use UserTrait;
    use EmailParsingTrait;

    public function SetUp(): void
    {
        parent::SetUp();

        $this->createTemplate();
        $this->notifiable = $this->createUser();
        $this->htmlEmailEnglish = $this->createHtmlView();
    }

    /**
     * @test
     *
     * @group RealSend
     */
    public function Email_send_to_mailgun(): void
    {
//        $unsubtoken = 'eyJpdiI6InUyd3Fzd3k4djNlNEJjSUJaYWZOR3c9PSIsInZhbHVlIjoiQnBoTjBmalpsblRzTE10Y1hJRzQ1dz09IiwibWFjIjoiMGJkNTVjNGQxOGY2N2Q1NWNlMDRjNjg5NjMwNDk3YmUwMzI0NGIzYTU3ZWQ1MjljYWE0MDc4M2FjZDUzMjIwMiIsInRhZyI6IiJ9|EAZvfYfaR4mA6FcsW3dkAQ186';
//        $this->unsubscribe($unsubtoken);

        //App::setLocale('nl');
        //Mail::fake(); // uncomment mail:fake to see the mail in your mail catcher
        $this->configMail();
        $this->createTemplate();
        $user = $this->createUser();

        $data = $this->createNotificationData();

        $user->notify(new TestTemplateNotification($data));

        $this->assertTrue(true);
    }

    private function unsubscribe(string $unsubscribeToken)
    {
        $tokenItems = explode('|', $unsubscribeToken);
        $stringableUser = StringableUser::fromString($tokenItems[0]);
        $mailableXid = $tokenItems[1];

        $userClass = $stringableUser->type;
        $user = $userClass::where('id', $stringableUser->id)->firstOrFail();

        $mailTemplate = MailTemplate::where('xid', $mailableXid)->firstOrFail();

        if(!$mailTemplate->mail_preventable) {
            // unsubscribe disabled
        }

        $notificationClass = $mailTemplate->notification;
        $user->unsubscribe($notificationClass);
    }
}
