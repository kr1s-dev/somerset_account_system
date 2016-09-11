<?php

namespace App\Http\Controllers\systemlogs;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class SystemLogsController extends Controller
{
    use UtilityHelper;
    public function viewLogs(){
        $systemLogsList = $this->getObjectRecords('system_logs',null);
        return view('systemlogs.show_system_logs_list',
        				compact('systemLogsList'));
    }
    
}
