<?php

namespace App\Http\Controllers\guest;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class GuestController extends Controller
{
    use UtilityHelper;
    public function getHomeOwnerPendingPayments(){
        try{
            $pendingPaymentsList = $this->getObjectRecords('home_owner_invoice',array('home_owner_id'=>$this->getHomeOwner(),
                                                                                        'is_paid'=>0));
            return view('guest_pending_payments.show_guest_pending_payment',
                            compact('pendingPaymentsList'));    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }

    public function getTransactionHistory(){
        try{
            $arrayMonth = $this->monthsGenerator();
            $outstandingBalance = 0;
            $totalDuesPaid = 0;
            $lastTransaction = 0;
            $pendingPaymentsList = $this->getObjectRecords('home_owner_invoice',array('home_owner_id'=>$this->getHomeOwner(),
                                                                                        'is_paid'=>0));
            $transactionHistory = DB::table('home_owner_invoice')->where('home_owner_id','=',$this->getHomeOwner())
                                                                    ->where('is_paid','=',1)
                                                                    ->orderBy('created_at','desc')
                                                                    ->first();
            
            if($transactionHistory != NULL)
                $lastTransaction = $transactionHistory->total_amount;
            // //$this->getObjectRecords('home_owner_invoice',array('home_owner_id'=>$this->getHomeOwner()->id,
                        //                                                              'is_paid'=>1));
            foreach ($pendingPaymentsList as $value) {
                $outstandingBalance += ($value->total_amount);
            }

            $transactionHistoryList = $this->getObjectRecords('home_owner_invoice',array('home_owner_id'=>$this->getHomeOwner(),
                                                                                        'is_paid'=>1));

            foreach ($transactionHistoryList as $value) {
                $totalDuesPaid += ($value->total_amount);
            }

            return view('guest_transaction_history.show_guest_transaction_history',
                            compact('outstandingBalance',
                                    'totalDuesPaid',
                                    'announcementsList',
                                    'transactionHistory',
                                    'transactionHistoryList',
                                    'arrayMonth'));    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }

    public function getDashBoard(){
        try{
            $arrayMonth = $this->monthsGenerator();
            $outstandingBalance = 0;
            $totalDuesPaid = 0;
            $lastTransaction = 0;
            $pendingPaymentsList = $this->getObjectRecords('home_owner_invoice',array('home_owner_id'=>$this->getHomeOwner(),
                                                                                        'is_paid'=>0));
            $transactionHistoryList = $this->getObjectRecords('home_owner_invoice',array('home_owner_id'=>$this->getHomeOwner(),
                                                                                        'is_paid'=>1));
            
            $transactionHistory = DB::table('home_owner_invoice')->where('home_owner_id','=',$this->getHomeOwner())
                                                                    ->where('is_paid','=',1)
                                                                    ->orderBy('created_at','desc')
                                                                    ->first();

            if($transactionHistory != NULL)
                $lastTransaction = $transactionHistory->total_amount;

            foreach ($pendingPaymentsList as $value) {
                $outstandingBalance += ($value->total_amount);
            }

            foreach ($transactionHistoryList as $value) {
                $totalDuesPaid += ($value->total_amount);
            }

            $announcementsList = $this->getObjectRecords('announcements','');
            return view('guest_dashboard.show_guest_dashboard',
                            compact('outstandingBalance',
                                    'totalDuesPaid',
                                    'announcementsList',
                                    'lastTransaction',
                                    'transactionHistory',
                                    'arrayMonth'));    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }


    public function getHomeOwner(){
        $eUser = $this->getUser($this->getLogInUserId());
        //$homeOwner = $this->getHomeOwnerInformation($eUser->home_owner_id);
        return $eUser->home_owner_id;
    }
}