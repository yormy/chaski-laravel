<?php

namespace Yormy\ChaskiLaravel\Domain\Create\Notifications;

use Yormy\ChaskiLaravel\Domain\Shared\Services\Purifier;

abstract class BaseNotificationData
{
    private string $userName;

    private string $buttonLink;

    private array $links;

    private array $buttons;

    private array $signature;

    private array $promo;

    private string $title;

    public static function make(): static
    {
        $newObject =  new static();

        $defaultSignature = config('chaski.default_signature');
        if (!empty($defaultSignature)) {
            foreach ($defaultSignature as $translatable) {
                $newObject->signature[] = __($translatable);
            }
        }

        return $newObject;
    }

    public function userName(string $userName): static
    {
        $this->userName = $userName; // name of what ?

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
