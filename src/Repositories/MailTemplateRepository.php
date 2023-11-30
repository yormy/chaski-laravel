<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Repositories;

use Yormy\ChaskiLaravel\Domain\Create\Models\TranslatableMailTemplate;

class MailTemplateRepository
{
    public function __construct(?TranslatableMailTemplate $model = null)
    {
        if (!$model) {
            $this->model = new TranslatableMailTemplate();
            return;
        }

        $this->model = $model;
    }

    public function findOnMailable(string $mailableClass): ?TranslatableMailTemplate
    {
        return $this->model->where('mailable', $mailableClass)->first();
    }
}
