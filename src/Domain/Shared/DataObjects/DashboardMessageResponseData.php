<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Shared\DataObjects;

use Illuminate\Support\Facades\App;
use Spatie\LaravelData\Data;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\NotificationSent;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmail;

class DashboardMessageResponseData extends Data
{
    public function __construct(
        public string $subject,
        public string $type,
        public string $created_at,
    ) {
    }

    public static function examples(): array
    {
        $data['subject'] = 'telescope:prune';

        return $data;
    }

    public static function descriptions(): array
    {
        $data['subject'] = 'Name of the cronjob';

        return $data;
    }

    protected static function constructorNotificationData(NotificationSent $model): array
    {
        $locale = App::getLocale();

        return [
            json_decode($model->data)->title->$locale,
            'notification',
            $model->created_at->format('Y-m-d H:i:s'),
            //            self::status($model),
        ];
    }

    protected static function constructorEmailData(SentEmail $model): array
    {
        return [
            $model->subject,
            'email',
            $model->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public static function fromModel(NotificationSent|SentEmail $model): self
    {
        $constuctorData = [];

        if ($model instanceof NotificationSent) {
            $constuctorData = self::constructorNotificationData($model);
        }
        if ($model instanceof SentEmail) {
            $constuctorData = self::constructorEmailData($model);
        }

        return new static(
            ...$constuctorData,
        );
    }

    private static function status($model): array
    {
        $status = [];
        if ($model->last_failed_at) {
            $status = [
                'key' => 'failed',
                'nature' => 'danger',
                'text' => 'FAILED',
            ];
        }

        return $status;
    }
}
