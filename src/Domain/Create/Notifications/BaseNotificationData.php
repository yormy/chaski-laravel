<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Create\Notifications;

use Yormy\ChaskiLaravel\Domain\Shared\Services\Purifier;

abstract class BaseNotificationData
{
    public string $uuid;

    public string $userName = '';

    public string $userEmail = '';

    /**
     * Call to action link to on device app
     */
    public string $appCta = '';

    public array $signature;

    public array $promo;

    public string $title;

    public string $appName;

    public string $appAbbreviation;

    public array $custom = [];

    private string $buttonLink;

    private array $links;

    private array $buttons;

    private string $imageName;

    private string $imageFile;

    public function toArray(): array
    {
        return [
            'custom' => $this->custom,
        ];
    }

    public static function make($user = null): static
    {
        $newObject = new static();
        $newObject->setDefaults();

        return $newObject;
    }

    public function custom(array $custom): void
    {
        $this->custom = $custom;
    }

    public function userName(?string $userName): static
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

    public function appCta(string $appCta): static
    {
        $this->appCta = $appCta;

        return $this;
    }

    public function getAppCta(): string
    {
        return $this->appCta;
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
        return $this->userName ?? $this->userEmail;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function getTitle(): ?string
    {
        if (! isset($this->title)) {
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
        if (! isset($this->links)) {
            return [];
        }

        return $this->links;
    }

    public function getCustom(): array
    {
        return $this->custom;
    }

    public function getImageName(): string
    {
        return $this->imageName;
    }

    public function getImageFile(): string
    {
        return $this->imageFile;
    }

    public function getButtons(): array
    {
        if (! isset($this->buttons)) {
            return [];
        }

        return $this->buttons;
    }

    public function getSignature(): array
    {
        if (! isset($this->signature)) {
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
        if (! isset($this->promo)) {
            return [];
        }

        return $this->convertToLines($this->promo);
    }

    private function setDefaults(): void
    {
        $defaultSignature = config('chaski.default_signature');
        if (! empty($defaultSignature)) {
            foreach ($defaultSignature as $translatable) {
                $this->signature[] = __($translatable);
            }
        }

        $this->appName = config('chaski.branding.app_name');
        $this->appAbbreviation = config('chaski.branding.app_abbreviation');
        $this->title = '{{mailSubject}}';

        $this->imageName = 'system';
        $this->imageFile = '/img/avatar/system.png';
    }

    private function convertToLines(array $data): array
    {
        $new = [];

        foreach ($data as $key => $dirty) {
            /** @psalm-suppress InvalidOperand */
            $key += 1;

            $line = Purifier::cleanHtml($dirty, 'h2');
            $new["line_{$key}"] = $line;
        }

        return $new;
    }
}
