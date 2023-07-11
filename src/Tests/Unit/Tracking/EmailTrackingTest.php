<?php

namespace Yormy\ChaskiLaravel\Tests\Unit\Tracking;

use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSending;
use jdavidbakr\MailTracker\MailTracker;
use jdavidbakr\MailTracker\MailTrackerController;
use jdavidbakr\MailTracker\Model\SentEmail;
use jdavidbakr\MailTracker\Model\SentEmailUrlClicked;
use Symfony\Component\Mime\Email;
use Yormy\ChaskiLaravel\Models\MailTracker\SentEmailLog;
use Yormy\ChaskiLaravel\Tests\TestCase;
use Yormy\ChaskiLaravel\Tests\Traits\UserTrait;
use Yormy\ChaskiLaravel\Tests\Unit\Parsing\Traits\EmailParsingTrait;

class EmailTrackingTest extends TestCase
{
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
     * @group chaski-tracking
     */
    public function Email_send_Email_Opens_Counted(): void
    {
        $trackables = $this->prepareEmailGetTrackables();

        $emailHash = $this->getOpenHash($trackables);
        $sentEmail = SentEmail::where('hash', $emailHash)->first();

        $sentEmail->refresh();
        $this->assertEquals(0, $sentEmail->opens);

        $this->triggerEmailOpen($emailHash);
        $sentEmail->refresh();
        $this->assertEquals(1, $sentEmail->opens);

        $this->triggerEmailOpen($emailHash);
        $sentEmail->refresh();
        $this->assertEquals(2, $sentEmail->opens);
    }

    /**
     * @test
     *
     * @group chaski-tracking
     */
    public function Email_send_Email_Opens_Log_added(): void
    {
        $trackables = $this->prepareEmailGetTrackables();

        $emailHash = $this->getOpenHash($trackables);
        $sentEmail = SentEmail::where('hash', $emailHash)->first();

        $sentEmail->refresh();
        $this->assertEquals(0, $sentEmail->opens);

        $this->triggerEmailOpen($emailHash);
        $sentEmailLogCount = SentEmailLog::where('sent_email_id', $sentEmail->id)->count();
        $this->assertEquals(1, $sentEmailLogCount);

        $this->triggerEmailOpen($emailHash);
        $sentEmailLogCount = SentEmailLog::where('sent_email_id', $sentEmail->id)->count();
        $this->assertEquals(2, $sentEmailLogCount);
    }

    /**
     * @test
     *
     * @group chaski-tracking1
     */
    public function Email_send_Link_clicked_Counted(): void
    {
        $trackables = $this->prepareEmailGetTrackables();

        $emailHash = $this->getOpenHash($trackables);
        $sentEmail = SentEmail::where('hash', $emailHash)->first();

        $trackableLinks = $this->getTrackableLinks($trackables);

        $this->triggerEmailLinkClick($trackableLinks[0]);
        $sentEmail->refresh();
        $this->assertEquals(1, $sentEmail->clicks);

        $this->triggerEmailLinkClick($trackableLinks[0]);
        $sentEmail->refresh();
        $this->assertEquals(2, $sentEmail->clicks);

        $this->triggerEmailLinkClick($trackableLinks[1]);
        $sentEmail->refresh();
        $this->assertEquals(3, $sentEmail->clicks);
    }

    /**
     * @test
     *
     * @group chaski-tracking
     */
    public function Email_send_Link_clicked_Url_logged(): void
    {
        $trackables = $this->prepareEmailGetTrackables();

        $emailHash = $this->getOpenHash($trackables);
        $sentEmail = SentEmail::where('hash', $emailHash)->first();

        $trackableLinks = $this->getTrackableLinks($trackables);

        $this->triggerEmailLinkClick($trackableLinks[0]);
        $sentEmailUrlClicks = SentEmailUrlClicked::where('sent_email_id', $sentEmail->id)->get();
        $this->assertEquals(1, $sentEmailUrlClicks->count());

        $this->triggerEmailLinkClick($trackableLinks[0]);
        $sentEmailUrlClicks = SentEmailUrlClicked::where('sent_email_id', $sentEmail->id)->get();
        $this->assertEquals(1, $sentEmailUrlClicks->count());
        $this->assertEquals(2, $sentEmailUrlClicks->first()->clicks);

        $this->triggerEmailLinkClick($trackableLinks[1]);
        $sentEmailUrlClicks = SentEmailUrlClicked::where('sent_email_id', $sentEmail->id)->get();
        $this->assertEquals(2, $sentEmailUrlClicks->count());
        $this->assertEquals(1, $sentEmailUrlClicks->last()->clicks);
    }

    // --------- HELPERS ---------
    private function prepareEmailGetTrackables(): array
    {
        $variables = [
            'label' => array_key_first($this->link1),
            'destination' => $this->link1[array_key_first($this->link1)],
        ];

        $htmlRenderedLink = $this->generateComponent($variables, 'link');
        $injectedHtml = $this->injectTrackingPixels($this->htmlEmailEnglish);

        return $this->getTrackables($injectedHtml);
    }

    private function getTrackableLinks(array $trackables): array
    {
        $trackableLinks = [];
        foreach ($trackables as $link) {
            $patternUrl = '#n\?l=(.*)&h#s';
            $found = preg_match($patternUrl, $link, $matches);
            if ($found) {
                $trackableLink['link'] = $link;
                $trackableLink['url'] = $matches[1];

                $patternHash = '#n\?l=.*&h=(.*)#s';
                $found = preg_match($patternHash, $link, $matches);
                if ($found) {
                    $hash = $matches[1];
                    //$hash = substr($hash,2, strlen($matches[1]));
                    $hash = preg_replace('/'.'=3D'.'/', '', $hash, 1);
                    $hash = preg_replace('/'.'3D'.'/', '', $hash, 1);
                    $hash = str_replace('=', '', $hash);

                    $trackableLink['hash'] = $hash;
                    $trackableLinks[] = $trackableLink;
                }
            }
        }

        return $trackableLinks;
    }

    private function getOpenHash(array $trackables): ?string
    {
        foreach ($trackables as $link) {
            $pattern = '#t\/([a-zA-Z0-9]+)#';
            $found = preg_match_all($pattern, $link, $matches);
            if ($found) {
                return $matches[1][0];
            }
        }

        return null;
    }

    private function getTrackables(string $injectedHtml): array
    {
        $domain = 'testapp.local';
        $pattern = "#http[s]*:\/\/$domain\/email\/(.*)\"#sU";
        preg_match_all($pattern, $injectedHtml, $matches);

        return array_map(function ($item) {
            $item = trim($item);
            $item = str_replace("\r", '', $item);
            $item = str_replace("\n", '', $item);

            return $item;
        }, $matches[1]);
    }

    private function triggerEmailOpen(string $hash)
    {
        $mailtrackController = new MailTrackerController();
        $mailtrackController->getT($hash);
    }

    private function triggerEmailLinkClick(array $link)
    {
        $request = new Request();
        $request->merge(['l' => $link['link']]);
        $request->merge(['h' => $link['hash']]);

        $mailtrackController = new MailTrackerController();
        $mailtrackController->getN($request);
    }

    private function injectTrackingPixels(string $html): string
    {
        $email = new Email();
        $email->html($html);
        $email->to('test@test.com');
        $email->from('test@test.com');

        $event = new MessageSending($email);
        $tracker = new MailTracker;
        $tracker->messageSending($event);

        return $email->getBody()->toString();
    }
}
