<?php

namespace Yormy\ChaskiLaravel\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Yormy\CoreToolsLaravel\Helpers\TranslatableModelHelper;

class NotificationSentResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'read_at' => $this->read_at,
            'web_cta' => $this->extractData('web_cta'),
            'app_cta' => $this->extractData('app_cta'),
            'created_at' => $this->created_at,
        ];

        return array_merge($this->extractTranslatableData($this->data), $data);
    }

    private function extractData($field): ?string
    {
        $decoded = json_decode($this->data, true);

        if (array_key_exists($field, $decoded)) {
            return $decoded[$field];
        }

        return null;
    }

    private function extractTranslatableData($jsonData): array
    {
        $data = json_decode($jsonData);

        return [
            'title' => TranslatableModelHelper::fromJsonFields($data->title),
            'content' => TranslatableModelHelper::fromJsonFields($data->content),
        ];
    }
}
