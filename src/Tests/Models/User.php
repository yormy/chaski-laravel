<?php

namespace Yormy\ChaskiLaravel\Tests\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Yormy\ChaskiLaravel\Domain\Subscription\Traits\HasNotificationSubscriptions;

class User extends Authenticatable
{
    use Notifiable;
    use HasNotificationSubscriptions;

    protected $table = 'test_users';

    protected $fillable = [
        'email',
    ];

    public $timestamps = false;

    /**
     * Route notifications for the mail channel.
     *
     * @return  array<string, string>|string
     */
    public function routeNotificationForMail(Notification $notification): array|string
    {
        // Return email address only...
        return $this->email;

        // Return email address and name...
        // return [$this->email_address => $this->name];
    }
}
