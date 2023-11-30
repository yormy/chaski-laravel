<?php

namespace Yormy\ChaskiLaravel\Domain\Create\Notifications;

use Yormy\ChaskiLaravel\Domain\Shared\Services\Purifier;

abstract class BaseNotificationData
{
    public string $uuid;
    
    private string $userName = '';

    private string $userEmail = '';

    private string $buttonLink;

    private array $links;

    private array $buttons;

    private array $signature;

    private array $promo;

    private string $title;

    private string $appName;

    private string $appAbbreviation;

    private array $custom = [];

    public function toArray(): array
    {
        return [
            'custom' => $this->custom,
        ];
    }

    public static function make($user = null): static
    {
        $newObject =  new static();
        $newObject->setDefaults();

        return $newObject;
    }

    private function setDefaults()
    {
        $defaultSignature = config('chaski.default_signature');
        if (!empty($defaultSignature)) {
            foreach ($defaultSignature as $translatable) {
                $this->signature[] = __($translatable);
            }
        }

        $this->appName = config('chaski.branding.app_name');
        $this->appAbbreviation = config('chaski.branding.app_abbreviation');
        $this->title = '{{mailSubject}}';
    }

    public function custom(array $custom)
    {
        $this->custom = $custom;
    }

    public function userName(string $userName): static
    {
        if ($userName) {
            $this->userName = $userName;
        }

        return $this;
    }

    public function userEmail(string $userEmail): static
    {
        if ($userEmail) {
            $this->userEmail = $userEmail;
        }

        return $this;
    }

    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function links(array $links): static
    {
        $this->links = $links;

        return $this;
    }

    public function buttons(array $buttons): static
    {
        $this->buttons = $buttons;

        return $this;
    }

    public function signature(array $signature): static
    {
        $this->signature = $signature;

        return $this;
    }

    public function noSignature(): static
    {
        $this->signature = [];

        return $this;
    }

    public function promo(array $promo): static
    {
        $this->promo = $promo;

        return $this;
    }

    public function buttonLink(string $url): static
    {
        $this->buttonLink = $url;

        return $this;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function getTitle(): ?string
    {
        if (!isset($this->title)) {
            return null;
        }

        return $this->title;
    }

    public function getButtonLink(): string
    {
        return $this->buttonLink;
    }

    public function getLinks(): array
    {
        if (!isset($this->links)) {
            return [];
        }
        return $this->links;
    }

    public function getCustom(): array
    {
        return $this->custom;
    }


    public function getButtons(): array
    {
        if (!isset($this->buttons)) {
            return [];
        }

        return $this->buttons;
    }

    public function getSignature(): array
    {
        if (!isset($this->signature)) {
            return [];
        }

        return $this->convertToLines($this->signature);
    }

    public function getAppName(): string
    {
        return $this->appName;
    }

    public function getAppAbbreviation(): string
    {
        return $this->appAbbreviation;
    }

    public function getPromo(): array
    {
        if (!isset($this->promo)) {
            return [];
        }

        return $this->convertToLines($this->promo);
    }

    private function convertToLines(array $data): array
    {
        $new = [];

        foreach ($data as $key => $dirty) {
            /** @psalm-suppress InvalidOperand */
            $key = $key + 1;

            $line = Purifier::cleanHtml($dirty, 'h2');
            $new["line_$key"] = $line;
        }

        return $new;
    }
}
