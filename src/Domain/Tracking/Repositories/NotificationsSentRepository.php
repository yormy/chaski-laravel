<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Repositories;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\NotificationSent;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\NotificationSentLog;
use Yormy\ChaskiLaravel\Services\Resolvers\IpResolver;
use Yormy\ChaskiLaravel\Services\Resolvers\UserAgentResolver;

class NotificationsSentRepository
{
    public function __construct(private ?NotificationSent $model = null)
    {
        if (! $model) {
            $this->model = new NotificationSent();
        }
    }

    public function markReadForUser(?Authenticatable $user, string $notificationId): NotificationSent
    {
        $notification = $this->getNotificationForUser($user, $notificationId);

        NotificationSentLog::create([
            'notification_id' => $notificationId,
            'ip_address' => IpResolver::get(),
            'user_agent' => UserAgentResolver::get(),
            'opened_at' => Carbon::now(),
        ]);

        if (! $notification->read_at) {
            $notification->read_at = Carbon::now();
            $notification->save();
        }

        return $notification;
    }

    public function getAllForUser(?Authenticatable $user): Collection
    {
        return $this->queryAllForUser($user)
            ->get();
    }

    public function queryAllForUser(?Authenticatable $user): Builder
    {
        return $this->queryForUser($user)
            ->select([
                'id',
                'type',
                'data',
                'created_at',
                'updated_at',
                'read_at',
            ])
            ->orderByRaw('(ISNULL(read_at)) desc, created_at DESC');
    }

    public function getAllNewForUser(?Authenticatable $user): Collection
    {
        return $this->queryAllForUser($user)
            ->whereNull('read_at')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function getNotificationForUser(?Authenticatable $user, string $notificationId): NotificationSent
    {
        /**
         * @var NotificationSent
         */
        return $this->queryForUser($user)
            ->where('id', $notificationId)
            ->firstOrFail();
    }

    private function queryForUser(?Authenticatable $user): Builder
    {
        if (! $user) {
            return $this->model::where('notifiable_id', -1); // always empty
        }

        return $this->model::where('notifiable_id', $user->id)
            ->where('notifiable_type', $user::class);
    }
}
