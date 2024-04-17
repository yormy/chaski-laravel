<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Shared\DataObjects;

use Illuminate\Support\Facades\App;
use Spatie\LaravelData\Data;

class SentNotificationResponseData extends Data
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

    protected static function constructorData($model): array
    {
        $locale = App::getLocale();
        return [
            json_decode($model->data)->title->$locale,
            'notification',
            $model->created_at->format('Y-m-d H:i:s')
//            self::status($model),
        ];
    }

    public static function fromModel($model): self
    {
        $constuctorData = self::constructorData($model);

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
                'text' => 'FAILED'
            ];
        }

        return $status;
    }
}


