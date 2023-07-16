<?php

namespace Yormy\ChaskiLaravel\Tests\Unit;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Yormy\ChaskiLaravel\Domain\Create\Notifications\TestTemplateNotification;
use Yormy\ChaskiLaravel\Tests\TestCase;
use Yormy\ChaskiLaravel\Tests\Traits\ConfigMailTrait;
use Yormy\ChaskiLaravel\Tests\Traits\UserTrait;
use Yormy\ChaskiLaravel\Tests\Unit\Domain\Create\Parsing\Traits\EmailParsingTrait;

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
    public function Email_send_to_mailgun_English(): void
    {
        //App::setLocale('nl');
        //Mail::fake(); // uncomment mail:fake to see the mail in your mail catcher
        $this->configMail();
        $this->createTemplate();
        $user = $this->createUser();

        $data = $this->createNotificationData();

        $user->notify(new TestTemplateNotification($data));

        $this->assertTrue(true);
    }

    /**
     * @test
     *
     * @group RealSend
     */
    public function Email_send_to_mailgun_Dutch(): void
    {
        App::setLocale('nl');

        $this->configMail();
        $this->createTemplate();
        $user = $this->createUser();

        $data = $this->createNotificationData();

        $user->notify(new TestTemplateNotification($data));

        $this->assertTrue(true);
    }
}
