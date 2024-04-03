<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Mexion\BedrockUsersv2\Domain\User\Models\Admin;
use Mexion\BedrockUsersv2\Domain\User\Models\Member;
use Mexion\BedrockUsersv2\Domain\User\Models\NotificationSent;
use Mexion\BedrockUsersv2\Domain\User\Models\NotificationSentLog;
use Mexion\BedrockUsersv2\Services\Resolvers\IpResolver;
use Mexion\BedrockUsersv2\Services\Resolvers\UserAgentResolver;

class NotificationsSentRepository
{
    public function __construct(private ?NotificationSent $model = null)
    {
        if (! $model) {
            $this->model = new NotificationSent();
        }
    }

    public function markReadForUser(Admin|Member|null $user, string $notificationId): NotificationSent
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

    public function getAllForUser(Admin|Member|null $user): Collection
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
            ->orderByRaw('(ISNULL(read_at)) desc, created_at DESC')
            ->get();
    }

    public function getAllNewForUser(Admin|Member|null $user): Collection
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
            ->whereNull('read_at')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function getNotificationForUser(Admin|Member|null $user, string $notificationId): NotificationSent
    {
        /**
         * @var NotificationSent
         */
        return $this->queryForUser($user)
            ->where('id', $notificationId)
            ->firstOrFail();
    }

    private function queryForUser(Admin|Member|null $user): Builder
    {
        if (! $user) {
            return $this->model::where('notifiable_id', -1); // always empty
        }

        return $this->model::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user));
    }
}
