<?php

namespace Yormy\ChaskiLaravel\Notifications;

use Yormy\ChaskiLaravel\Services\Purifier;

class TestTemplateNotificationDTO
{
    private string $name;

    private string $buttonLink;

    private array $links;

    private array $buttons;

    private array $signature;

    private array $promo;

    public static function make(): static
    {
        return new static();
    }

    public function name(string $name): static
    {
        $this->name = $name;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function getButtonLink(): string
    {
        return $this->buttonLink;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function getButtons(): array
    {
        return $this->buttons;
    }

    public function getSignature(): array
    {
        return $this->convertToLines($this->signature);
    }

    public function getPromo(): array
    {
        return $this->convertToLines($this->promo);
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
}
