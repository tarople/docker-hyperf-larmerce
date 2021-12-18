<?php

namespace App\Crontab;

use Carbon\Carbon;

class FooTask 
{
    public function execute()
    {
        var_dump(Carbon::now()->toDateTimeString());
    }   
}