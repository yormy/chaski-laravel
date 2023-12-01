<?php

namespace Yormy\ChaskiLaravel\Domain\Shared\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Yormy\ChaskiLaravel\Domain\Shared\Models\NotificationSent;

class NotificationSentFactory extends Factory
{
    protected $model = NotificationSent::class;

    public function definition()
    {
        return [
            'id' => Str::random(10),
            'type' => '-',
            'notifiable_type' => '-',
            'notifiable_id' => 1,
            'data' => $this->generateData(),
            'read_at' => $this->faker->boolean() ?  $this->faker->dateTime() : null,
            'created_at' => $this->faker->dateTime(),
        ];
    }

    public function generateData(): string
    {
        $translationsTitle = [
            'en' => $this->faker->sentence(3),
        ];

        $translationsContent = [
            'en' => $this->faker->sentence(3),
        ];

        $data = [
            'title' => json_encode($translationsTitle),
            'content' => json_encode($translationsContent),
            'web_cta' => 'https//web-cta.com',
            'app_cta' => 'https//web-cta.com',
            'sent_email_id' => 1432,
        ];

        return json_encode($data);
    }

    public function unread(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'read_at' => null,
            ];
        });
    }
}
