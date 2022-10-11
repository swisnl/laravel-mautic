<?php

use Swis\Laravel\Mautic\Facades\Mautic;

it('can do a call or something', function () {
    expect(true)->toBeTrue();

    $response = Mautic::contacts()->get(1);

    // dd($response);
});
