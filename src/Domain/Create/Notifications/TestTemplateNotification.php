<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Create\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TestTemplateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private TestTemplateNotificationDTO $data)
    {
    }

    /**
     * @psalm-return list<mixed>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function shouldSend(object $notifiable, string $channel): bool
    {
        return true;
    }

    public function toMail($notifiable): Mailable
    {
        return (new TestTemplateMailable($notifiable, $this->data))
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
