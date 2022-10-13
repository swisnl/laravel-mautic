<?php

use Swis\Laravel\Mautic\Facades\Mautic;
use Swis\Laravel\Mautic\Tests\mock\User;

it('can do a call or something', function () {
    expect(true)->toBeTrue();

    $response = Mautic::contacts()->get(1);

    // dd($response);
});

it('creates a new instance in Mautic when the model does not have a mautic_id', function () {
    $user = new User([
        'name' => 'John Doe',
        'email' => 'john@exampel.com',
    ]);

    $mock = mock(\Mautic\Api\Contacts::class)->expect(
        itemName: fn () => 'contact'
    )->shouldReceive('create')
        ->once()
        ->with($user->toMauticArray())
        ->andReturn(['contact' => ['id' => '1337']])
        ->getMock();

    Mautic::shouldReceive('connection')
        ->andReturnSelf();
    Mautic::shouldReceive('contacts')
        ->once()
        ->andReturn($mock);

    $user->save();

    expect($user->refresh()->getMauticId())->toBe('1337');
});

it('updates an existing Mautic entity when a mautic_id is found on the model', function () {
    $user = new User([
        'name' => 'John Doe',
        'email' => 'john@exampel.com',
        'mautic_id' => '1337',
    ]);

    $mock = mock(\Mautic\Api\Contacts::class)
        ->shouldReceive('edit')
        ->once()
        ->with('1337', $user->toMauticArray())
        ->getMock();

    Mautic::shouldReceive('connection')
        ->andReturnSelf();
    Mautic::shouldReceive('contacts')
        ->once()
        ->andReturn($mock);

    $user->save();
});

it('tries to delete a user from Mautic when a user is deleted', function () {
    $mock = mock(\Mautic\Api\Contacts::class)
        ->shouldReceive('delete')
        ->once()
        ->with('1337')
        ->getMock();

    Mautic::shouldReceive('connection')
        ->andReturnSelf();
    Mautic::shouldReceive('contacts')
        ->once()
        ->andReturn($mock);

    $user = new User([
        'name' => 'John Doe',
        'email' => 'john@exampel.com',
        'mautic_id' => '1337',
    ]);

    $user->saveQuietly();
    $user->delete();
});
