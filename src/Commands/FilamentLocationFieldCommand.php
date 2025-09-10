<?php

namespace Damarev\FilamentLocationField\Commands;

use Illuminate\Console\Command;

class FilamentLocationFieldCommand extends Command
{
    public $signature = 'filament-location-field';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
