<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use jdavidbakr\MailTracker\Model\SentEmailUrlClicked;

class SentEmailUrlClickedFactory extends Factory
{
    protected $model = SentEmailUrlClicked::class;

    public function definition()
    {
        return [
            'hash' => md5(Str::random(20)),
            'url' => $this->faker->url,
            'clicks' => 1,
        ];
    }
}
