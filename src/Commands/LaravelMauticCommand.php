<?php

namespace Swis\LaravelMautic\Commands;

use Illuminate\Console\Command;

class LaravelMauticCommand extends Command
{
    public $signature = 'laravel-mautic';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
