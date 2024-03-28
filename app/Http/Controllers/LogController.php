<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    function log_info()
    {
        $logs = Log::latest()->get();
        return view('admin.log.log_info', [
            'logs' => $logs,
        ]);
    }
}
