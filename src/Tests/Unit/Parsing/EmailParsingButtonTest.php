<?php

namespace Yormy\ChaskiLaravel\Tests\Unit\Parsing;

use Yormy\ChaskiLaravel\Tests\TestCase;
use Yormy\ChaskiLaravel\Tests\Traits\UserTrait;
use Yormy\ChaskiLaravel\Tests\Unit\Parsing\Traits\EmailParsingTrait;

class EmailParsingButtonTest extends TestCase
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
     * @group chaski-parsing
     */
    public function Email_includes_button1_from_data_Label_destination_from_data(): void
    {
        $variables = [
            'label' => array_key_first($this->button1),
            'destination' => $this->button1[array_key_first($this->button1)],
        ];
        $htmlRendered = $this->generateButtonComponent($variables, 'button');

        $this->assertStringContainsString($htmlRendered, $this->htmlEmailEnglish);
    }

    private function generateButtonComponent(array $variables, string $template): string
    {
        return $this->generateComponent($variables, $template, 'chaski-laravel::_partials.buttons');
    }

    /**
     * @test
     *
     * @group chaski-parsing
     */
    public function Email_includes_button2_from_data_Label_destination_from_data(): void
    {
        $variables = [
            'label' => array_key_first($this->button2),
            'destination' => $this->button2[array_key_first($this->button2)],
        ];

        $htmlRenderedLink = $this->generateButtonComponent($variables, 'button');

        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
    }

    /**
     * @test
     *
     * @group chaski-parsing
     */
    public function Email_includes_button_from_data_Label_hardcoded(): void
    {
        $variables = [
            'label' => $this->layoutHardcodedLabel,
            'destination' => $this->button1[array_key_first($this->button1)],
        ];
        $htmlRenderedLink = $this->generateButtonComponent($variables, 'button');

        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
    }

    /**
     * @test
     *
     * @group chaski-parsing
     */
    public function Email_includes_button_Label_and_destination_hardcoded(): void
    {
        $variables = [
            'label' => $this->layoutHardcodedLabel,
            'destination' => $this->layoutHardcodedDestination,
        ];
        $htmlRenderedLink = $this->generateButtonComponent($variables, 'button');

        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
    }
}
