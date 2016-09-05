<?php

namespace App\Http\Controllers\maps;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class MapController extends Controller
{
	use UtilityHelper;

	/**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        $this->middleware('user.type:map');
    }
    
    public function getMap(){
    	$blockLotList = $this->getAddress(null);
    	return view('map.somerset_map',
    					compact('blockLotList'));
    }
}
