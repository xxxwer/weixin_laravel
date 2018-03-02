<?php

namespace App\Repo\Common;

use Illuminate\Support\Facades\Log as LaravelLog;

class Log
{
    public static function info($str, $data)
    {
        if (config('app.log_level') === 'debug') {
            LaravelLog::info($str, $data);
        }
    }
}
