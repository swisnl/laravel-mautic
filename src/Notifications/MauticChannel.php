<?php

namespace Swis\Laravel\Mautic\Notifications;

use Illuminate\Notifications\Notification;
use Swis\Laravel\Mautic\Facades\Mautic;

class MauticChannel
{
    public function send(mixed $notifiable, Notification $notification)
    {
        if (! method_exists($notification, 'toMautic')) {
            throw new \InvalidArgumentException('The toMautic method does not exist in your notification class.');
        }
        $message = $notification->toMautic($notifiable);

        if (! $message instanceof MauticMessage) {
            throw new \InvalidArgumentException('Your notification is incorrectly formatted or needs to use an instance of the MauticMessage class.');
        }

        if (! $message->getTo()) {
            $to = $notifiable->routeNotificationFor('mautic', $notification)
                ?? $notifiable->routeNotificationFor(self::class, $notification);

            if (! $to) {
                return null;
            }

            $message->to($to);
        }

        return Mautic::emails()->sendToContact(
            $message->getMailId(),
            $message->getTo(),
            [
                'tokens' => $message->getTokens(),
            ]
        );
    }
}
