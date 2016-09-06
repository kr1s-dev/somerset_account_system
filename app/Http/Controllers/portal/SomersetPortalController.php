<?php

namespace App\Http\Controllers\portal;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class SomersetPortalController extends Controller
{
	use UtilityHelper;
    public function getPortal(){
    	$blockLotList = $this->getAddress(null);
    	return view('somerset_page.index',
    					compact('blockLotList'));
    }
}
