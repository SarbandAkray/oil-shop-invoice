<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MyCommand extends Command
{
    protected $signature = 'pennant:purge';
    protected $description = 'Clear Pennant data safely';
    public function handle()
    {
        // Handle command functionality here
        $this->info('Pennant data purged!');
    }
}
