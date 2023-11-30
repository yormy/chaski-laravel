<?php

namespace Yormy\ChaskiLaravel\Domain\Create\Models;

use Spatie\MailTemplates\Models\MailTemplate;
use Spatie\Translatable\HasTranslations;
use Yormy\ChaskiLaravel\Domain\Shared\DataObjects\MailTemplateObject;
use Yormy\Xid\Models\Traits\Xid;

/**
 * Yormy\ChaskiLaravel\Domain\Create\Models\TranslatableMailTemplate
 *
 * @property-read array $variables
 *
 * @method static Builder|MailTemplate forMailable(\Illuminate\Contracts\Mail\Mailable $mailable)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslatableMailTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslatableMailTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslatableMailTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslatableMailTemplate whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslatableMailTemplate whereLocales(string $column, array $locales)
 *
 * @mixin \Eloquent
 */

/**
 * @psalm-suppress MethodSignatureMustProvideReturnType
 */
class TranslatableMailTemplate extends MailTemplate
{
    use HasTranslations;
    use Xid;

    protected $table = 'mail_templates';

    public $translatable = [
        'subject',
        'summary',
        'html_template',
        'text_template',
        'notification_title',
        'notification_content',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function create(MailTemplateObject $data): self
    {
        $this->mailable = $data->getMailable();

        $this->name = $data->getName();

        $subjects = $data->getSubjects();
        $this->setValue($data, 'subject', $subjects);

        $summaries = $data->getSummaries();
        $this->setValue($data, 'summary', $summaries);

        $htmlTemplates = $data->getHtmlTemplates();
        $this->setValue($data, 'html_template', $htmlTemplates);

        $textTemplates = $data->getTextTemplates();
        $this->setValue($data, 'text_template', $textTemplates);

        $this->is_hidden = $data->getIsHidden();
        $this->slack_unsubscribable = $data->getSlackUnsubscribable();
        $this->mail_unsubscribable = $data->getMailUnsubscribable();
        $this->sms_unsubscribable = $data->getSmsUnsubscribable();
        $this->cannot_edit = $data->getCannotEdit();
        $this->notes = $data->getNotes();

        $this->html_layout = $data->getHtmlLayout();
        $this->text_layout = $data->getTextLayout();

        $this->tags = $data->getTags();

        $this->notification = $data->getNotification();

        $this->notification_title = $data->getNotificationTitle();

        if($data->getNotificationContent()) {
            $this->notification_content = $data->getNotificationContent();
        }

        $this->save();

        return $this;
    }

    private function setValue(MailTemplateObject $data, string $field, array $translations): void
    {
        $languages = $data->getLanguages();
        $defaultLanguage = $data->getDefaultLanguge();

        foreach ($languages as $language) {
            if (isset($translations[$language])) {
                $value = $translations[$language];
            } else {
                $value = $translations[$defaultLanguage];
            }
            $this->setTranslation($field, $language, $value);
        }
    }
}
