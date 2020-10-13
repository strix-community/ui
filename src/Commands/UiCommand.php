<?php

namespace Strix\Ui\Commands;

use Illuminate\Console\Command;

class UiCommand extends Command
{
    public $signature = 'ui';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
