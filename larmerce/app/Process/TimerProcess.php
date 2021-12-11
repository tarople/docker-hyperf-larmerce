<?php

declare(strict_types=1);

namespace App\Process;

use Hyperf\Process\AbstractProcess;

class TimerProcess extends AbstractProcess
{
    public $name = 'timer-process';

    public function handle(): void
    {
        // todo 
    }
}