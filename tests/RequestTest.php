<?php

use Swis\Laravel\Mautic\Facades\Mautic;
use Swis\Laravel\Mautic\Tests\mock\User;

it('can do a call or something', function () {
    expect(true)->toBeTrue();

    $response = Mautic::contacts()->get(1);

    // dd($response);
});

it('creates a new instance in Mautic when the model does not have a mautic_id', function () {
    $mock = mock(\Mautic\Api\Contacts::class)->expect(
        create: fn (array $attributes) => ['contact' => ['id' => '1337']]
    );

    Mautic::shouldReceive('contacts')
        ->once()
        ->andReturn($mock);

    $user = new User([
        'name' => 'John Doe',
        'email' => 'john@exampel.com',
    ]);

    $user->save();

    expect($user->getMauticId())->toBe('1337');
});

it('updates an existing Mautic entity when a mautic_id is found on the model', function () {
    $mock = mock(\Mautic\Api\Contacts::class)->expect(
        edit: fn (string $id, array $attributes) => ['contact' => ['id' => '1337']]
    );

    Mautic::shouldReceive('contacts')
        ->once()
        ->andReturn($mock);

    $user = new User([
        'name' => 'John Doe',
        'email' => 'john@exampel.com',
        'mautic_id' => '1337'
    ]);

    $user->save();

    expect($user->isClean('mautic_id'))->toBeTrue();
});
