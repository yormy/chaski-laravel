<?php

namespace Yormy\ChaskiLaravel\Tests\Unit\Domain\Create\Parsing;

use Illuminate\Support\Facades\App;
use Yormy\ChaskiLaravel\Tests\TestCase;
use Yormy\ChaskiLaravel\Tests\Traits\UserTrait;
use Yormy\ChaskiLaravel\Tests\Unit\Domain\Create\Parsing\Traits\EmailParsingTrait;

class EmailParsingLanguageTest extends TestCase
{
    use EmailParsingTrait;
    use UserTrait;

    public function SetUp(): void
    {
        parent::SetUp();

        $this->createTemplate();
        $this->notifiable = $this->createUser();

        $this->htmlEmailDutch = $this->createHtmlView('nl');
        $this->htmlEmailEnglish = $this->createHtmlView('en');
    }

    /**
     * @test
     *
     * @group chaski-mail-translation
     */
    public function Email_as_dutch_No_English(): void
    {
        App::setLocale('nl');
        $this->assertStringNotContainsString($this->english.$this->username, $this->htmlEmailDutch);
    }

    /**
     * @test
     *
     * @group chaski-mail-translation
     */
    public function Email_as_english_No_dutch(): void
    {
        App::setLocale('nl');
        $this->assertStringNotContainsString($this->dutch.$this->username, $this->htmlEmailEnglish);
    }

    /**
     * @test
     *
     * @group chaski-mail-translation
     */
    public function Email_as_english_Show_english(): void
    {
        App::setLocale('nl');
        $this->assertStringContainsString($this->english.$this->username, $this->htmlEmailEnglish);
    }

    /**
     * @test
     *
     * @group chaski-mail-translation
     */
    public function Email_as_dutch_Show_dutch(): void
    {
        App::setLocale('nl');
        $this->assertStringContainsString($this->dutch.$this->username, $this->htmlEmailDutch);
    }
}
