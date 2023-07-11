<?php

namespace Yormy\ChaskiLaravel\Tests\Unit\Parsing;

use Yormy\ChaskiLaravel\Tests\TestCase;
use Yormy\ChaskiLaravel\Tests\Traits\UserTrait;
use Yormy\ChaskiLaravel\Tests\Unit\Parsing\Traits\EmailParsingTrait;

class EmailParsingTableTest extends TestCase
{
    use UserTrait;
    use EmailParsingTrait;

    protected $notifiable;

    public function SetUp(): void
    {
        parent::SetUp();

        $this->createTemplate();
        $this->notifiable = $this->createUser();
        $this->notifiable = $this->createUser();

        $this->htmlEmailEnglish = $this->createHtmlView();
    }

    /**
     * @test
     *
     * @group chaski-parsing
     */
    public function Email_includes_table_From_data(): void
    {
        $variables = [
            'headerItems' => $this->tableHeader,
            'rows' => $this->tableRows,
        ];

        $htmlRenderedLink = $this->generateTableComponent($variables, 'table');
        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
    }

    private function generateTableComponent($variables, $template): string
    {
        return $this->generateComponent($variables, $template, 'chaski-laravel::_partials.tables');
    }

    /**
     * @test
     *
     * @group chaski-parsing
     */
    public function Email_includes_table_Hardcoded(): void
    {
        $variables = [
            'headerItems' => $this->tableHeaderHardcoded,
            'rows' => $this->tableRowsHardcoded,
        ];

        $htmlRendered = $this->generateTableComponent($variables, 'table');

        $this->assertStringContainsString($htmlRendered, $this->htmlEmailEnglish);
    }

}
