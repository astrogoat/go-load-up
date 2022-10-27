<?php

namespace Astrogoat\GoLoadUp\Commands;

use Illuminate\Console\Command;

class GoLoadUpCommand extends Command
{
    public $signature = 'go-load-up';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
