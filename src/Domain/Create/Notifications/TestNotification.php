<?php

namespace Yormy\ChaskiLaravel\Domain\Create\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $notifications;

    public function __construct(
    ) {
        $this->notifications = config('tripwire.notifications');
    }

    /**
     * @psalm-return list<mixed>
     */
    public function via($notifiable): array
    {
        $channels = ['mail'];

        return $channels;
    }

    public function toMail($notifiable): Mailable
    {
        return (new TestMailable())
            ->to($notifiable->email);
    }

    /*    public function toSlack($notifiable)
        {
            $domain = request()->getHttpHost();

            $message = __('tripwire::notifications.slack.message', [
                'domain' => $domain,
            ]);

            $mailSettings = $this->settings;

            return (new SlackMessage)
                ->error()
                ->from($mailSettings['from'], $mailSettings['emoji'])
                ->to($mailSettings['channel'])
                ->content($message)
                ->attachment(function ($attachment) use ($domain) {
                    $attachment->fields([
                        'IP' => $this->ipAddress,
                        'User ID' => $this->userId,
                        'domain' => $domain,
                    ]);
                });
        }*/
}
