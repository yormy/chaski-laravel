<?php

namespace Yormy\ChaskiLaravel\Tests\Unit\Domain\Create\Parsing;

use Yormy\ChaskiLaravel\Domain\Shared\Services\Purifier;
use Yormy\ChaskiLaravel\Tests\TestCase;
use Yormy\ChaskiLaravel\Tests\Traits\UserTrait;
use Yormy\ChaskiLaravel\Tests\Unit\Domain\Create\Parsing\Traits\EmailParsingTrait;

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
        $variables = $this->convertToLines($this->promo);

        $renderedHtml = $this->generateTextComponent($variables, 'promo');

        $this->assertStringContainsString($renderedHtml, $this->htmlEmailEnglish);
    }

    private function convertToLines(array $data): array
    {
        $new = [];

        foreach ($data as $key => $dirty) {
            $key = $key + 1;

            $line = Purifier::cleanHtml($dirty, 'h2');
            $new["line_$key"] = $line;
        }

        return $new;
    }

    private function generateTextComponent($variables, $template): string
    {
        return $this->generateComponent($variables, $template, 'chaski-laravel::_partials.texts');
    }

    /**
     * @test
     *
     * @group chaski-parsing
     */
    public function Email_includes_signature_from_data(): void
    {
        $variables = $this->convertToLines($this->signature);

        $renderedHtml = $this->generateTextComponent($variables, 'signature');
        $this->assertStringContainsString($renderedHtml, $this->htmlEmailEnglish);
    }
}
