<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Database\Factories;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\NotificationSent;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmail;

class NotificationSentFactory extends Factory
{
    protected $model = NotificationSent::class;

    public function definition()
    {
        return [
            'id' => Str::random(10),
            'type' => 'Mexion\TestappCore\Domain\User\Notifications\EmailOTP\EmailOTPNotification',
            'data' => $this->generateData(),
            'read_at' => $this->faker->boolean() ? $this->faker->dateTime() : null,
            'created_at' => $this->faker->dateTime(),
        ];
    }

    public function forMember(Authenticatable $member): Factory
    {
        return $this->state(function (array $attributes) use ($member) {
            $prefix = "(member {$member->id})";

            return [
                'notifiable_type' => $member::class,
                'notifiable_id' => $member->id,
                'data' => $this->generateData($prefix),
            ];
        });
    }

    public function forMemberWithEmail(Authenticatable $member): Factory
    {
        return $this->state(function (array $attributes) use ($member) {
            $sentEmail = SentEmail::factory()->forMember($member)->create();
            $prefix = "(member {$member->id})";

            return [
                'notifiable_type' => $member::class,
                'notifiable_id' => $member->id,
                'data' => $this->generateData($prefix, $sentEmail->sent_email_id),
            ];
        });
    }

    public function forAdmin(Authenticatable $admin): Factory
    {
        return $this->state(function (array $attributes) use ($admin) {
            $prefix = "(admin {$admin->id})";

            return [
                'notifiable_type' => $admin::class,
                'notifiable_id' => $admin->id,
                'data' => $this->generateData($prefix),
            ];
        });
    }

    public function forAdminWithEmail(Authenticatable $admin): Factory
    {
        return $this->state(function (array $attributes) use ($admin) {
            $sentEmail = SentEmail::factory()->forAdmin($admin)->create();
            $prefix = "(admin {$admin->id})";

            return [
                'notifiable_type' => $admin::class,
                'notifiable_id' => $admin->id,
                'data' => $this->generateData($prefix, $sentEmail->sent_email_id),
            ];
        });
    }

    public function generateData(string $prefix = '', ?string $sentEmailId = null): string
    {
        $translationsTitle = [
            'en' => $prefix.$this->faker->sentence(3),
        ];

        $translationsContent = [
            'en' => $this->faker->sentence(3),
        ];

        $data = [
            'title' => $translationsTitle,
            'content' => $translationsContent,
            'web_cta' => 'https//web-cta.com',
            'app_cta' => 'https//web-cta.com',
            'sent_email_id' => $sentEmailId,
            'image_name' => 'system',
            'image_file' => '/img/avatar/system.png',
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
