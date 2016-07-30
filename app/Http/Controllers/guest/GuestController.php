<?php

namespace App\Http\Controllers\guest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;;

class GuestController extends Controller
{
	use UtilityHelper;
    public function getHomeOwnerPendingPayments(){
    	$pendingPaymentsList = $this->getObjectRecords('home_owner_invoice',array('home_owner_id'=>$this->getHomeOwner()->id,
    																				'is_paid'=>0));
    }

    public function getTransactionHistory(){
    	$outstandingBalance = 0;
    	$totalDuesPaid = 0;
    	$pendingPaymentsList = $this->getObjectRecords('home_owner_invoice',array('home_owner_id'=>$this->getHomeOwner()->id,
    																				'is_paid'=>0));
    	$transactionHistoryList = $this->getObjectRecords('home_owner_invoice',array('home_owner_id'=>$this->getHomeOwner()->id,
    																				'is_paid'=>1));
    	foreach ($pendingPaymentsList as $value) {
    		$outstandingBalance += ($value->total_amount);
    	}

    	foreach ($transactionHistoryList as $value) {
    		$totalDuesPaid += ($value->total_amount);
    	}
    }

    public function getDashBoard(){
    	$outstandingBalance = 0;
    	$totalDuesPaid = 0;
    	$pendingPaymentsList = $this->getObjectRecords('home_owner_invoice',array('home_owner_id'=>$this->getHomeOwner()->id,
    																				'is_paid'=>0));
    	$transactionHistoryList = $this->getObjectRecords('home_owner_invoice',array('home_owner_id'=>$this->getHomeOwner()->id,
    																				'is_paid'=>1));
    	foreach ($pendingPaymentsList as $value) {
    		$outstandingBalance += ($value->total_amount);
    	}

    	foreach ($transactionHistoryList as $value) {
    		$totalDuesPaid += ($value->total_amount);
    	}

    	$announcementsList = $this->getObjectRecords('announcements','');
    }


    public function getHomeOwner(){
    	$eUser = $this->getUser($this->getLogInUserId());
    	$homeOwner = $this->getHomeOwnerInformation($eUser->home_owner_id);
    	return $homeOwner;
    }
}
