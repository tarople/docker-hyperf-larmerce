<?php

namespace App\Crontab;

use Hyperf\Crontab\Annotation\Crontab;

/**
 * // @Crontab(name="Echo", rule="* * * * *", callback="execute", memo="这是一个示例的定时任务")
 */
class EchoCrontab 
{
    public function execute()
    {
        // var_dump(Carbon::now()->toDateTimeString());
    }

    public function isEnable(): bool
    {
        return false;
    }
}