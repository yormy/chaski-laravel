<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Yormy\ChaskiLaravel\Domain\Shared\Models\NotificationSent;

class NotificationsSentRepository
{
    public function __construct(private ?NotificationSent $model = null)
    {
        if (!$model) {
            $this->model = new NotificationSent();
        }
    }

    public function getAll($user): Collection
    {
        return $this->model->all();
    }
}
