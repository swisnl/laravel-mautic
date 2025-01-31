<?php

use Illuminate\Notifications\Notification;
use Swis\Laravel\Mautic\Exceptions\NotificationException;
use Swis\Laravel\Mautic\Notifications\MauticChannel;
use Swis\Laravel\Mautic\Notifications\MauticMessage;
use Swis\Laravel\Mautic\Tests\mock\User;

it('can send a notification', function () {
    $user = new User([
        'name' => 'John Doe',
        'email' => 'john@exampel.com',
        'mautic_id' => '12345',
    ]);
    $notification = new class extends Notification
    {
        public function toMautic($notifiable)
        {
            return MauticMessage::create(1)
                ->tokens(['foo' => 'bar']);
        }
    };
    $channel = new MauticChannel;

    $emailsMock = mock(\Mautic\Api\Emails::class)
        ->makePartial()
        ->shouldReceive('sendToContact')
        ->once()
        ->with(1, $user->routeNotificationFor('mautic', $notification), ['tokens' => ['foo' => 'bar']])
        ->andReturn(['succes' => true])
        ->getMock();

    mockManager('emails', $emailsMock);

    $channel->send($user, $notification);
});

it('throws when sending a notification fails', function () {
    $user = new User([
        'name' => 'John Doe',
        'email' => 'john@exampel.com',
        'mautic_id' => '12345',
    ]);
    $notification = new class extends Notification
    {
        public function toMautic($notifiable)
        {
            return MauticMessage::create(1)
                ->tokens(['foo' => 'bar']);
        }
    };
    $channel = new MauticChannel;

    $emailsMock = mock(\Mautic\Api\Emails::class)
        ->makePartial()
        ->shouldReceive('sendToContact')
        ->once()
        ->with(1, $user->routeNotificationFor('mautic', $notification), ['tokens' => ['foo' => 'bar']])
        ->andReturn(['errors' => [
            [
                'code' => 500,
                'message' => 'Something went wrong',
            ],
        ]])
        ->getMock();

    mockManager('emails', $emailsMock);

    $channel->send($user, $notification);
})->throws(NotificationException::class, 'Something went wrong');
