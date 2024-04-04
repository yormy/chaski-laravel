<?php

namespace Yormy\ChaskiLaravel\Tests\Unit\Domain\Create\Parsing\Traits;

use Illuminate\Support\Facades\App;
use Spatie\MailTemplates\Models\MailTemplate;
use Yormy\ChaskiLaravel\Domain\Create\Models\TranslatableMailTemplate;
use Yormy\ChaskiLaravel\Domain\Create\Notifications\TestTemplateMailable;
use Yormy\ChaskiLaravel\Domain\Create\Notifications\TestTemplateNotification;
use Yormy\ChaskiLaravel\Domain\Create\Notifications\TestTemplateNotificationDTO;
use Yormy\ChaskiLaravel\Domain\Shared\DataObjects\MailTemplateObject;

trait EmailParsingTrait
{
    private string $username = 'MY_NAME';

    private string $dutch = 'DUTCH';

    private string $english = 'ENGLISH';

    private string $layoutHardcodedLabel = 'LAYOUT_LABEL_TO_HARDCODED_LINK';

    private string $layoutHardcodedDestination = 'https://hardcoded-destination.com';

    private array $link1 = ['signup now' => 'https://sdddnu.nl'];

    private array $link2 = ['cancel' => 'www.cancel.com'];

    private array $button1 = ['Signup Here' => 'www.signup.com'];

    private array $button2 = ['Delete' => 'www.delete.com'];

    private array $promo = ['P.S. Did you know:', 'We just released some new <a href="www.google.com">features available</a>', 'check <tag>out</tag> our <b>upgrade</b> plan'];

    private array $signature = ['Cheers', 'The team from <b>chaski</b>', 'make each day an epic adventure'];

    private array $tableHeader = ['col1', 'col2'];

    private array $tableRows = [
        ['row1', 'row1b'],
        ['row2', 'row2b'],
    ];

    private array $tableHeaderHardcoded = ['HardcodedHeader1', 'HardcodedHeader12'];

    private array $tableRowsHardcoded = [
        ['apples', 'oranges'],
        ['bikes', 'cars'],
    ];

    private string $htmlViewEnglish;

    private string $htmlViewDutch;

    private function createHtmlView(string $locale = 'en'): string
    {
        $currentLocale = App::getLocale();
        App::setLocale($locale);

        $data = $this->createNotificationData();

        $htmlView = (new TestTemplateMailable($this->notifiable, $data))->buildView()['html'];

        App::setLocale($currentLocale);

        return $htmlView;
    }

    private function createNotificationData(): TestTemplateNotificationDTO
    {
        return TestTemplateNotificationDTO::make()
            ->userName($this->username)
            ->links(array_merge($this->link1, $this->link2))
            ->signature($this->signature)
            ->promo($this->promo)
            ->buttons(array_merge($this->button1, $this->button2));
    }

    private function generateComponent(array $variables, string $template, string $viewRoot): string
    {
        return view("$viewRoot.$template", $variables)->render();
    }

    private function createTemplate(array $data = [])
    {
        MailTemplate::truncate();

        $htmlTemplate = '
    <h1>Hello, '.$this->english.'{{ name }}!</h1>
<p>The standard Lorem Ipsum passage, used since the 1500s
"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
</p>
    [[link:1]]
    [[link:2]]
    [[link:'.$this->layoutHardcodedLabel.'|{{link_1}}]]
    [[link:'.$this->layoutHardcodedLabel.'|'.$this->layoutHardcodedDestination.']]
<p>
Section 1.10.32 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC
"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"
</p>

    [[button:1]]
    [[button:2]]
    [[button:'.$this->layoutHardcodedLabel.'|{{button_1}}]]
    [[button:'.$this->layoutHardcodedLabel.'|'.$this->layoutHardcodedDestination.']]

    [[button_danger:1]]
    [[button_danger:'.$this->layoutHardcodedLabel.'|'.$this->layoutHardcodedDestination.']]

    [[table:'.$this->tableHeader[0].'|'.$this->tableHeader[1].';'
            .$this->tableRows[0][0].'|'.$this->tableRows[0][1].';'
            .$this->tableRows[1][0].'|'.$this->tableRows[1][1].';
    ]]

    [[table:'.implode('|', $this->tableHeaderHardcoded).';'
            .implode('|', $this->tableRowsHardcoded[0]).';'
            .implode('|', $this->tableRowsHardcoded[1]).';
    ]]

    ---
    [[signature]]

    [[promo]]

    [[link_unsubscribe]]
    ';
        $textTemplate = 'Hello, {{ name }}!';

        $mailTemplateObject = MailTemplateObject::make()
            ->mailable(TestTemplateMailable::class)
            ->notification(TestTemplateNotification::class)
            ->subject('nl', 'NEDERLANDS')
            ->summary('nl', 'Hoi')
            ->htmlTemplate('nl', '<h1>'.$this->dutch.'{{ name }}!</h1> [[link_unsubscribe]]')
            ->textTemplate('nl', 'hoi, {{ name }}!')
            ->subject('en', 'ENGELS')
            ->summary('en', 'Hello')
            // ???? [[button:Click to abort,{{abort_link}}]]
            ->htmlTemplate('en', $htmlTemplate)
            ->textTemplate('en', $textTemplate)
            ->textLayout(null)
            ->htmlLayout('chaski-laravel::layouts.html.default')
            ->name('INTERNAL NAME')
            ->tags(['a', 'b'])
            ->notes('some notes')
            ->isHidden(true)
            ->cannotEdit(true)
            ->slackUnsubscribable(false)
            ->mailUnsubscribable($data['mail_unsubscribable'] ?? true)
            ->smsUnsubscribable(false);

        $mail = (new TranslatableMailTemplate())->create($mailTemplateObject);
    }
}
