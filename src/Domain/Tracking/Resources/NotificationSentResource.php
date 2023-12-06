<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Yormy\Dateformatter\Models\Traits\DateFormatterResource;

class NotificationSentResource extends JsonResource
{
    use DateFormatterResource;

    private array $dataAsArray;

    private static string $locale = '';

    public function toArray($request)
    {
        $this->dataAsArray = json_decode($this->data, true);

        if (!self::$locale) {
            self::$locale = App::getLocale();
        }

        $fields = [
            'id' => $this->id,
            'read_at' => $this->read_at,
            'title' => $this->getLocalizedFromTranslatable('title'), // TranslatableModelHelper::fromJsonFields($data->title),   // this takes much resources
            'content' => $this->getLocalizedFromTranslatable('content'),
            'web_cta' => $this->extractData('web_cta'),
            'app_cta' => $this->extractData('app_cta'),
            'image_name' => $this->extractData('image_name'),
            'image_file' => $this->extractData('image_file'),
            'sent_email_id' => $this->extractData('sent_email_id'),
        ];


        $dates = $this->getDates([
            'created_at',
        ]);

        return array_merge($fields, $dates);
    }

    private function extractData($field): ?string
    {
        if (array_key_exists($field, $this->dataAsArray)) {
            return $this->dataAsArray[$field];
        }

        return null;
    }

    private function getLocalizedFromTranslatable(string $field): ?string
    {
        $locale = self::$locale;
        if (array_key_exists($field, $this->dataAsArray)) {

            $translations = $this->dataAsArray[$field];
            if (!array_key_exists($locale, $translations)) {
                $locale = 'en';
            }
            return $translations[$locale];
        }

        return null;
    }
}
