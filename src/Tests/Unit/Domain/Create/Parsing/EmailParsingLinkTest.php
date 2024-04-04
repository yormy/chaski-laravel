<?php

namespace Yormy\ChaskiLaravel\Tests\Unit\Domain\Create\Parsing;

use Yormy\ChaskiLaravel\Tests\TestCase;
use Yormy\ChaskiLaravel\Tests\Traits\UserTrait;
use Yormy\ChaskiLaravel\Tests\Unit\Domain\Create\Parsing\Traits\EmailParsingTrait;

class EmailParsingLinkTest extends TestCase
{
    use EmailParsingTrait;
    use UserTrait;

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
     * @group chaski-parsing
     * @group xxx
     */
    public function Email_includes_name_from_data(): void
    {
        $this->markTestSkipped();
        $this->assertStringContainsString($this->english.$this->username, $this->htmlEmailEnglish);
    }

    /**
     * @test
     *
     * @group chaski-parsing
     */
    public function Email_includes_link1_from_data_Label_destination_from_data(): void
    {
        $variables = [
            'label' => array_key_first($this->link1),
            'destination' => $this->link1[array_key_first($this->link1)],
        ];
        $htmlRenderedLink = $this->generateLinkComponent($variables);
        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
    }

    private function generateLinkComponent($variables): string
    {
        return $this->generateComponent($variables, 'link', 'chaski-laravel::_partials.links');
    }

    /**
     * @test
     *
     * @group chaski-parsing
     */
    public function Email_includes_link2_from_data_Label_destination_from_data(): void
    {
        $variables = [
            'label' => array_key_first($this->link2),
            'destination' => $this->link2[array_key_first($this->link2)],
        ];

        $htmlRenderedLink = $this->generateLinkComponent($variables);
        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
    }

    /**
     * @test
     *
     * @group chaski-parsing
     */
    public function Email_includes_link_from_data_Label_hardcoded(): void
    {
        $variables = [
            'label' => $this->layoutHardcodedLabel,
            'destination' => $this->link1[array_key_first($this->link1)],
        ];
        $htmlRenderedLink = $this->generateLinkComponent($variables);
        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
    }

    /**
     * @test
     *
     * @group chaski-parsing
     */
    public function Email_includes_Label_and_destination_hardcoded(): void
    {
        $variables = [
            'label' => $this->layoutHardcodedLabel,
            'destination' => $this->layoutHardcodedDestination,
        ];
        $htmlRenderedLink = $this->generateLinkComponent($variables);
        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
    }
}
