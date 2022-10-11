<?php

use Swis\Laravel\Mautic\Facades\LaravelMautic;

it('can do a call or something', function () {
    $response = LaravelMautic::contacts()->get(1);

    dd($response);
});
