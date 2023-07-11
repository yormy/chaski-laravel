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
            'rows' => $this->tableRows
        ];

        $htmlRenderedLink = $this->generateComponent($variables, 'table');
        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
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
            'rows' => $this->tableRowsHardcoded
        ];

        $htmlRendered = $this->generateComponent($variables, 'table');

        $this->assertStringContainsString($htmlRendered, $this->htmlEmailEnglish);
    }

//
//    /**
//     * @test
//     *
//     * @group chaski-parsing
//     */
//    public function Email_includes_link2_from_data_Label_destination_from_data(): void
//    {
//        $variables = [
//            'label' => array_key_first($this->link2),
//            'destination' => $this->link2[array_key_first($this->link2)]
//        ];
//
//        $htmlRenderedLink = $this->generateComponent($variables, 'link');
//        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
//    }
//
//    /**
//     * @test
//     *
//     * @group chaski-parsing
//     */
//    public function Email_includes_link_from_data_Label_hardcoded(): void
//    {
//        $variables = [
//            'label' => $this->layoutHardcodedLabel,
//            'destination' => $this->link1[array_key_first($this->link1)]
//        ];
//        $htmlRenderedLink = $this->generateComponent($variables, 'link');
//        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
//    }
//
//
//    /**
//     * @test
//     *
//     * @group chaski-parsing
//     */
//    public function Email_includes_Label_and_destination_hardcoded(): void
//    {
//        $variables = [
//            'label' => $this->layoutHardcodedLabel,
//            'destination' => $this->layoutHardcodedDestination
//        ];
//        $htmlRenderedLink = $this->generateComponent($variables, 'link');
//        $this->assertStringContainsString($htmlRenderedLink, $this->htmlEmailEnglish);
//    }
}
