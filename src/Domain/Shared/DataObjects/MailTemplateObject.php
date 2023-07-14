<?php

namespace Yormy\ChaskiLaravel\Domain\Shared\DataObjects;

use Illuminate\Support\Str;

class MailTemplateObject
{
    private ?string $defaultLanguage = null;

    private string $mailable;

    private string $notification;

    private ?string $htmlLayout;

    private ?string $textLayout;

    private string $name;

    private array $tags = [];

    private array $subject;

    private array $summary;

    private array $htmlTemplate;

    private array $textTemplate;

    private bool $isHidden = false;

    private bool $slackUnsubscribable = true;

    private bool $mailUnsubscribable = true;

    private bool $smsUnsubscribable = true;

    private bool $cannotEdit = false;

    private string $notes = '';

    public static function make(): static
    {
        return new static();
    }

    public function defaultLanguage(?string $language): static
    {
        $this->defaultLanguage = $language;

        return $this;
    }

    public function mailable(string $mailable): static
    {
        $this->mailable = $mailable;

        return $this;
    }

    public function notification(string $notification): static
    {
        $this->notification = $notification;

        return $this;
    }

    public function TextLayout(?string $layout): static
    {
        $this->textLayout = $layout;

        return $this;
    }

    public function HtmlLayout(?string $layout): static
    {
        $this->htmlLayout = $layout;

        return $this;
    }

    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function tags(array $tags): static
    {
        $this->tags = $tags;

        return $this;
    }

    public function subject(string $language, string $subject): static
    {
        $this->subject[$language] = $subject;

        return $this;
    }

    public function summary(string $language, string $summary): static
    {
        $this->summary[$language] = $summary;

        return $this;
    }

    public function htmlTemplate(string $language, string $htmlTemplate): static
    {
        $this->htmlTemplate[$language] = $htmlTemplate;

        return $this;
    }

    public function textTemplate(string $language, string $textTemplate): static
    {
        $this->textTemplate[$language] = $textTemplate;

        return $this;
    }

    public function notes(string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function isHidden(bool $hidden = false): static
    {
        $this->isHidden = $hidden;

        return $this;
    }

    public function slackUnsubscribable(bool $unsubscribable = true): static
    {
        $this->slackUnsubscribable = $unsubscribable;

        return $this;
    }

    public function mailUnsubscribable(bool $unsubscribable = true): static
    {
        $this->mailUnsubscribable = $unsubscribable;

        return $this;
    }

    public function smsUnsubscribable(bool $unsubscribable = true): static
    {
        $this->smsUnsubscribable = $unsubscribable;

        return $this;
    }

    public function cannotEdit(bool $cannotEdit = false): static
    {
        $this->cannotEdit = $cannotEdit;

        return $this;
    }

    public function getDefaultLanguge()
    {
        if (! isset($this->defaultLanguage)) {
            return config('chaski.default_language', 'en');
        }

        return $this->defaultLanguage;
    }

    public function getLanguages(): array
    {
        $languages = [];
        $summary = array_keys($this->summary);
        $subjects = array_keys($this->subject);
        $htmlTemplates = array_keys($this->htmlTemplate);
        $textTemplates = array_keys($this->textTemplate);

        return array_unique(array_merge($languages, $summary, $subjects, $htmlTemplates, $textTemplates));
    }

    public function getMailable(): string
    {
        return $this->mailable;
    }

    public function getNotification(): string
    {
        return $this->notification;
    }

    public function getTextLayout(): ?string
    {
        if (! isset($this->textLayout)) {
            return null;
        }

        return $this->textLayout;
    }

    public function getHtmlLayout(): ?string
    {
        if (! isset($this->htmlLayout)) {
            return null;
        }

        return $this->htmlLayout;
    }

    /**
     * @psalm-suppress RedundantPropertyInitializationCheck
     */
    public function getName(): string
    {
        if (! isset($this->name)) {
            return Str::random(10);
        }

        return $this->name;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getSubjects(): array
    {
        return $this->subject;
    }

    public function getSummaries(): array
    {
        return $this->summary;
    }

    public function getHtmlTemplates(): array
    {
        return $this->htmlTemplate;
    }

    public function getTextTemplates(): array
    {
        return $this->textTemplate;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function getIsHidden(): bool
    {
        return $this->isHidden;
    }

    public function getSlackUnsubscribable(): bool
    {
        return $this->slackUnsubscribable;
    }

    public function getMailUnsubscribable(): bool
    {
        return $this->mailUnsubscribable;
    }

    public function getSmsUnsubscribable(): bool
    {
        return $this->smsUnsubscribable;
    }

    public function getCannotEdit(): bool
    {
        return $this->cannotEdit;
    }
}
