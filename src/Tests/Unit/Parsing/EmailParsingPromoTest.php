<?php

namespace Yormy\ChaskiLaravel\Tests\Unit\Parsing;

use Yormy\ChaskiLaravel\Tests\TestCase;
use Yormy\ChaskiLaravel\Tests\Traits\UserTrait;
use Yormy\ChaskiLaravel\Tests\Unit\Parsing\Traits\EmailParsingTrait;

class EmailParsingPromoTest extends TestCase
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
    public function Email_includes_promo_from_data(): void
    {
        $variables = [
            'line1' => $this->promo[0] ?? '',
            'line2' => $this->promo[1] ?? '',
            'line3' => $this->promo[2] ?? '',
            'line4' => $this->promo[3] ?? '',
        ];

        $htmlRenderedLink = $this->generateComponent($variables, 'promo');
        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
    }

    /**
     * @test
     *
     * @group chaski-parsing
     */
    public function Email_includes_signature_from_data(): void
    {
        $variables = [
            'line1' => $this->signature[0] ?? '',
            'line2' => $this->signature[1] ?? '',
            'line3' => $this->signature[2] ?? '',
            'line4' => $this->signature[3] ?? '',
        ];

        $htmlRenderedLink = $this->generateComponent($variables, 'signature');
        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
    }
}
