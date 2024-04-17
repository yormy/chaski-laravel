<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Repositories;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Yormy\ChaskiLaravel\Domain\Shared\Services\IpAddress;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmail;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmailLog;

class EmailsSentRepository
{
    public function __construct(private ?SentEmail $model = null)
    {
        if (! $model) {
            $this->model = new SentEmail();

            return;
        }

        $this->model = $model;
    }

    public function getAllForUser(Authenticatable $user): Collection
    {
        return $this->queryForUser($user)
            ->select([
                'id',
                'xid',
                'sender_name',
                'recipient_name',
                'recipient_email',
                'subject',
                'content',
                'opens',
                'opened_at',
                'created_at',
            ])
            ->orderByRaw('(ISNULL(opened_at)) desc, created_at DESC')
            ->get();
    }

    public function markOpenedForUser(Authenticatable $user, string $xid): SentEmail
    {
        $sentEmail = $this->getSentEmailForUser($user, $xid);

        if (! $sentEmail->opened_at) {
            $sentEmail->opened_at = Carbon::now();
        }
        $sentEmail->opens++;
        $sentEmail->save();

        SentEmailLog::create([
            'sent_email_id' => $sentEmail->id,
            'ip_address' => IpAddress::get(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'], //todo to use resolvers, resolvers to root / tools ?
            'type' => 'WEB-OPEN',
        ]);

        return $sentEmail;
    }

    public function getSentEmailForUser(Authenticatable $user, string $xid): SentEmail
    {
        /**
         * @var SentEmail
         */
        return $this->queryForUser($user)
            ->where('xid', $xid)
            ->firstOrFail();
    }

    public function getSentEmailForUserByUuid(Authenticatable $user, string $uuid): SentEmail
    {
        /**
         * @var SentEmail
         */
        return $this->queryForUser($user)
            ->where('sent_email_id', $uuid)
            ->firstOrFail();
    }

    public function getSentEmailByUuid(string $uuid): SentEmail
    {
        /**
         * @var SentEmail
         */
        return $this->model
            ->where('sent_email_id', $uuid)
            ->firstOrFail();
    }

    public function getSentEmailByXid(string $xid): SentEmail
    {
        /**
         * @var SentEmail
         */
        return $this->model
            ->where('xid', $xid)
            ->firstOrFail();
    }

    public function findSentEmailByIdOrFail($id): SentEmail
    {
        /**
         * @var SentEmail
         */
        return $this->model
            ->where('id', $id)
            ->firstOrFail();
    }

    private function queryForUser(Authenticatable $user): Builder
    {
        return $this->model::where('user_id', $user->id)
            ->where('user_type', $user::class);
    }
}
