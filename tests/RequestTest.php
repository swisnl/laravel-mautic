<?php

use Mautic\Api\Contacts;
use Swis\Laravel\Mautic\Tests\mock\User;

it('creates a new instance in Mautic when the model does not have a mautic_id', function () {
    $user = new User([
        'name' => 'John Doe',
        'email' => 'john@exampel.com',
    ]);

    $contactsMock = mock(Contacts::class);

    $contactsMock
        ->shouldReceive('itemName')
        ->andReturn('contact');

    $contactsMock
        ->shouldReceive('create')
        ->once()
        ->with($user->toMauticArray())
        ->andReturn(['contact' => ['id' => '1337']]);

    mockManager('contacts', $contactsMock);

    $user->save();

    expect($user->refresh()->getMauticId())->toBe('1337');
});

it('updates an existing Mautic entity when a mautic_id is found on the model', function () {
    $user = new User([
        'name' => 'John Doe',
        'email' => 'john@exampel.com',
        'mautic_id' => '1337',
    ]);

    $contactsMock = mock(Contacts::class)
        ->makePartial()
        ->shouldReceive('edit')
        ->once()
        ->with('1337', $user->toMauticArray())
        ->getMock();

    mockManager('contacts', $contactsMock);

    $user->save();
});

it('tries to delete a user from Mautic when a user is deleted', function () {
    $contactsMock = mock(Contacts::class)
        ->makePartial()
        ->shouldReceive('delete')
        ->once()
        ->with('1337')
        ->getMock();

    mockManager('contacts', $contactsMock);

    $user = new User([
        'name' => 'John Doe',
        'email' => 'john@exampel.com',
        'mautic_id' => '1337',
    ]);

    $user->saveQuietly();
    $user->delete();
});
