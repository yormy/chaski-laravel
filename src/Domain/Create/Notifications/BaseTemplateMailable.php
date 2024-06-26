<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Create\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\HtmlString;
use Spatie\MailTemplates\TemplateMailable;
use Yormy\ChaskiLaravel\Domain\Create\Models\TranslatableMailTemplate;
use Yormy\ChaskiLaravel\Domain\Shared\Services\Encryption;
use Yormy\ChaskiLaravel\Domain\Shared\Services\StringableUser;

class BaseTemplateMailable extends TemplateMailable
{
    use Queueable, SerializesModels;

    public const ALLOW_CONTENT_LOGGING = true;

    public string $userName;

    public string $userEmail;

    public string $appName;

    public string $mailSubject;

    public string $appAbbreviation;

    public ?string $title;

    public string $link_1 = '';

    public string $link_2 = '';

    public string $link_3 = '';

    public string $link_4 = '';

    public string $button_1 = '';

    public string $button_2 = '';

    public string $button_3 = '';

    public string $button_4 = '';

    public string $unsubscribeLink = '';

    public array $custom = [];

    protected static $templateModelClass = TranslatableMailTemplate::class;

    private array $links;

    private array $buttons;

    private array $promo;

    private array $signature;

    private $notifiable;

    private string $uuid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notifiable, BaseNotificationData $data)
    {
        $this->notifiable = $notifiable;

        $this->userName = $data->getUserName();
        $this->userEmail = $data->getUserEmail();

        $this->title = $data->getTitle() ?? null;

        $this->links = $data->getLinks();
        $linkValues = array_values($this->links);

        if (isset($linkValues[0])) {
            $this->link_1 = $linkValues[0];
        }
        if (isset($linkValues[1])) {
            $this->link_2 = $linkValues[1]; // 0 based, so just call it as the second link
        }
        if (isset($linkValues[2])) {
            $this->link_3 = $linkValues[2];
        }
        if (isset($linkValues[3])) {
            $this->link_4 = $linkValues[3];
        }

        $this->buttons = $data->getButtons();
        $buttonValues = array_values($this->buttons);
        if (isset($buttonValues[0])) {
            $this->button_1 = $buttonValues[0];
        }
        if (isset($buttonValues[1])) {
            $this->button_2 = $buttonValues[1]; // 0 based, so just call it as the second link
        }
        if (isset($buttonValues[2])) {
            $this->button_3 = $buttonValues[2];
        }
        if (isset($buttonValues[3])) {
            $this->button_4 = $buttonValues[3];
        }

        $this->promo = $data->getPromo();
        $this->signature = $data->getSignature();

        $this->appName = $data->getAppName();
        $this->appAbbreviation = $data->getAppAbbreviation();

        $this->custom = $data->getCustom();

        $templateModel = $this->resolveTemplateModel();

        $this->mailSubject = ''; // pre-initialize
        $this->mailSubject = $this
            ->getMailTemplateRenderer()
            ->renderSubject($this->buildViewData());

        $this->unsubscribeLink = route('chaski.email.unsubscribe', $this->getUnsubscribeToken());

        $this->uuid = $data->uuid;
    }

    public function send($mailer): void
    {
        $this->addHeaders($this->notifiable);

        parent::send($mailer);
    }

    public function addHeaders($notifiable): void
    {
        $this->withSymfonyMessage(function ($message) use ($notifiable): void {
            $stringedUser = StringableUser::toString($notifiable);
            $message->getHeaders()
                ->addTextHeader('X-UXID', Encryption::encrypt($stringedUser));

            $mailableClass = static::class;
            $message->getHeaders()
                ->addTextHeader('X-MX', Encryption::encrypt($mailableClass));

            $message->getHeaders()
                ->addTextHeader('X-TX', Encryption::encrypt(Carbon::now()->toString()));

            $message->getHeaders()
                ->addTextHeader('X-NX', Encryption::encrypt($this->uuid));
        });
    }

    //
    //
    //    public function addHeaders(string $notificationId = null, string $mailTemplate = null)
    //    {
    //        foreach ($this->trackingHeaders as $name => $value) {
    //            $this->withSymfonyMessage(function (Email $message) use ($name, $value) {
    //                $message->getHeaders()
    //                    ->addTextHeader($name, base64_encode($value));
    //            });
    //        }
    //    }
    public function getHtmlLayout(): string
    {
        $variables = $this->createVariablesArray();

        $layout = $this->mailTemplate->html_layout;
        if (! $layout) {
            $layout = config('chaski.default_layout.html');
        }

        return view($layout, $variables)->render();
    }

    public function getTextLayout(): string
    {
        $variables = $this->createVariablesArray();

        $layout = $this->mailTemplate->text_layout;
        if (! $layout) {
            $layout = config('chaski.default_layout.text');
        }

        return view($layout, $variables)->render();
    }

    public function buildView()
    {
        $view = parent::buildView();

        $result = $this->parseHtmlInjectables($view['html']->__toString());

        $view['html'] = new HtmlString($result);

        return $view;
    }

    /**
     * @psalm-param 'link_unsubscribe'|'promo'|'signature' $componentName
     */
    private function parseTextComponent(string $org, array $variables, string $componentName): string
    {
        $result = $org;

        $signaturePattern = "#\[\[{$componentName}\]\]#iUs";
        $matches = [];
        preg_match_all($signaturePattern, $org, $matches);
        $outerSignatures = $matches[0];
        foreach ($outerSignatures as $outerSignature) {
            $htmlRenderedSignature = view("chaski-laravel::_partials.texts.{$componentName}", $variables)->render();

            $result = str_ireplace($outerSignature, $htmlRenderedSignature, $result);
        }

        return $result;
    }

    private function linkDetailsDetermine(array $data, string $item): array
    {
        if (is_numeric($item)) {
            $zerobasedIndex = (int) $item - 1;
            $i = 0;
            foreach ($data as $label => $destination) {
                if ($i === $zerobasedIndex) {
                    // render this one
                    $variables = [
                        'destination' => $destination,
                        'label' => $label,
                    ];
                    break;
                }
                $i++;
            }

            return $variables;
        }

        $buttonDetails = explode('|', $item);

        $buttonLabel = $buttonDetails[0];
        $buttonDestination = $buttonDetails[1];

        return [
            'destination' => $buttonDestination,
            'label' => $buttonLabel,
        ];
    }

    private function parseTextSectionComponent(string $org, array $customVariables, string $linkName, string $viewRoot = 'chaski-laravel::_partials.texts'): string
    {
        $result = $org;

        $pattern = "#\[\[{$linkName}:(.*)\]\]#iUs";

        $matches = [];
        preg_match_all($pattern, $org, $matches);
        $outer = $matches[0];
        $inner = $matches[1];

        foreach ($inner as $matchIndex => $item) {
            $htmlRenderedButton = view($viewRoot.'.'.$linkName, $customVariables)->render();

            $result = str_ireplace($outer[$matchIndex], $htmlRenderedButton, $result);
        }

        return $result;
    }

    private function parseButtonLinkComponent(string $org, array $data, string $linkName, string $viewRoot): string
    {
        $result = $org;

        $pattern = "#\[\[{$linkName}:(.*)\]\]#iUs";

        $matches = [];
        preg_match_all($pattern, $org, $matches);
        $outer = $matches[0];
        $inner = $matches[1];

        foreach ($inner as $matchIndex => $item) {
            $variables = $this->linkDetailsDetermine($data, $item);

            $htmlRenderedButton = view($viewRoot.'.'.$linkName, $variables)->render();

            $result = str_ireplace($outer[$matchIndex], $htmlRenderedButton, $result);
        }

        return $result;
    }

    private function getUnsubscribeToken(): ?string
    {
        $mailableXid = $this->mailTemplate->xid;
        $token = StringableUser::toString($this->notifiable).'-'.$mailableXid.'-'.App::getLocale();

        return Encryption::encrypt($token);
    }

    private function parseLinkComponent(string $org, string $linkName): string
    {
        return $this->parseButtonLinkComponent($org, $this->links, $linkName, 'chaski-laravel::_partials.links');
    }

    private function parseButtonComponent(string $org, string $linkName): string
    {
        return $this->parseButtonLinkComponent($org, $this->buttons, $linkName, 'chaski-laravel::_partials.buttons');
    }

    /**
     * @psalm-param 'table' $componentName
     */
    private function parseTableComponent(string $org, string $componentName): string
    {
        $result = $org;

        $componentPattern = "#\[\[{$componentName}:(.*)\]\]#iUs";
        $matches = [];
        preg_match_all($componentPattern, $org, $matches);
        $outerComponent = $matches[0];
        $innerComponent = $matches[1];
        foreach ($innerComponent as $matchIndex => $innerComponent) {
            $innerComponent = trim($innerComponent);

            $tableLines = explode(';', $innerComponent);
            $headerItems = $tableLines[0];
            unset($tableLines[0]);

            $allRows = [];
            foreach ($tableLines as $row) {
                if ($row) {
                    $rowItems = explode('|', $row);
                    $allRows[] = $rowItems;
                }
            }

            $data = [
                'headerItems' => explode('|', $headerItems),
                'rows' => $allRows,
            ];

            $htmlRenderedComponent = view("chaski-laravel::_partials.tables.{$componentName}", $data)->render();

            $result = str_ireplace($outerComponent[$matchIndex], $htmlRenderedComponent, $result);
        }

        return $result;
    }

    private function parseHtmlInjectables(string $org): string
    {
        $variables = self::getVariables();
        $result = $org;

        $result = $this->parseTextSectionComponent($result, $this->custom, 'code');
        $result = $this->parseTableComponent($result, 'table');

        $result = $this->parseButtonComponent($result, 'button_danger');
        $result = $this->parseButtonComponent($result, 'button');

        $result = $this->parseTextComponent($result, $this->signature, 'signature');
        $result = $this->parseTextComponent($result, $this->promo, 'promo');

        $result = $this->parseLinkComponent($result, 'link');

        $variables['unsubscribeLink'] = $this->unsubscribeLink;

        return $this->parseTextComponent($result, $variables, 'link_unsubscribe');

        //        foreach ($variables as $variableName) {
        //            // $pattern ="#{!!(\s)*$variableName(\s)*!!}#i";
        //        }
    }

    private function createVariablesArray(): array
    {
        $variables = self::getVariables();

        $data = [];
        foreach ($variables as $value) {
            $data[$value] = $this->{$value};
        }

        return $data;
    }
}
