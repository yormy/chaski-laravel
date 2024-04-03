<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmailLog;

class SentEmailLogFactory extends Factory
{
    protected $model = SentEmailLog::class;

    public function definition()
    {
        return [
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
            'type' => $this->faker->randomElement(['CLICK', 'OPEN']),
            'url' => $this->faker->url,
        ];
    }
}
