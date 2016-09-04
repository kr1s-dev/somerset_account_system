<?php

namespace App\Http\Controllers\maps;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class MapController extends Controller
{
	use UtilityHelper;
    public function getMap(){
    	$blockLotList = $this->getAddress(null);
    	return view('map.somerset_map',
    					compact('blockLotList'));
    }
}
