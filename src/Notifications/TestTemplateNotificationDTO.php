<?php

namespace Yormy\ChaskiLaravel\Notifications;

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
        return $this->signature;
    }

    public function getPromo(): array
    {
        return $this->promo;
    }
}
