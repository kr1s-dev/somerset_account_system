<?php

namespace App\Http\Controllers\admin;

use DB;
use Carbon;
use App\ReceiptModel;
use App\ExpenseModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class AdminDashboardController extends Controller
{
    use UtilityHelper;
    public function getDashBoard(){
    	$yearFilter = date('Y');
    	$incomeAmountPerMonth = array();
    	$expenseAmountPerMonth = array();
        $homeOwnerSubsidiaryLedgerPerWeek = array(); 
        $totalHomeOwnerAmountPerWeek = 0;
        $homeVendorSubsidiaryLedgerPerWeek = array(); 
        $totalVendorAmountPerWeek = 0;
        $incTotalSum = 0;
        $expTotalSum = 0;

    	$incStatementItemsList = $this->getJournalEntryRecordsWithFilter('5',null,date('Y'));
    	$expStatementItemsList = $this->getJournalEntryRecordsWithFilter('6',null,date('Y'));

    	if(count($incStatementItemsList)>0){
    		$incomeItemsList = $this->getItemsAmountList($incStatementItemsList,'Income');
    		$incomeAmountPerMonth = $this->getAmountPerMonth($incStatementItemsList);
            $incTotalSum = $this->getTotalSum($incomeItemsList);
    	}else{
            foreach(range(1, 12) as $month) {
                $incomeAmountPerMonth[$month] = 0;
            }
        }   

    	if(count($expStatementItemsList)>0){
    		$expenseItemsList = $this->getItemsAmountList($expStatementItemsList,'Expense');
    		$expenseAmountPerMonth = $this->getAmountPerMonth($expStatementItemsList);
            $expTotalSum = $this->getTotalSum($expenseItemsList);
    	}else{
            foreach(range(1, 12) as $month) {
                $expenseAmountPerMonth[$month] = 0;
            }
        }
        $homeOwnerSubsidiaryLedgerPerWeek = $this->generateSubsidiaryLedger('homeowner');
        $totalHomeOwnerAmountPerWeek = $this->getTotalSum($homeOwnerSubsidiaryLedgerPerWeek);

        $homeVendorSubsidiaryLedgerPerWeek = $this->generateSubsidiaryLedger('vendor');
        $totalVendorAmountPerWeek = $this->getTotalSum($homeVendorSubsidiaryLedgerPerWeek);
        return view('admin_dashboard.admin_dashboard',
        				compact('incTotalSum',
        						'expTotalSum',
        						'incomeAmountPerMonth',
        						'expenseAmountPerMonth',
                                'homeOwnerSubsidiaryLedgerPerWeek',
                                'totalHomeOwnerAmountPerWeek',
                                'homeVendorSubsidiaryLedgerPerWeek',
                                'totalVendorAmountPerWeek'));
    }

    public function getAmountPerMonth($dataList){
    	$amountPerMonth = array();
    	foreach(range(1, 12) as $month) {
    		$amountPerMonth[$month] = 0;
    	}
    	//print_r($amountPerMonth);
		foreach ($dataList as $data) {
			$amountPerMonth[trim(date('m',strtotime($data->created_at)),'0')] += ($data->credit_amount+$data->debit_amount);
			//echo $data;
		}
		return $amountPerMonth;
    }

    public function generateSubsidiaryLedger($type){
        $amountPerDay = array();
        $objectToShowList;
        $fromDate = Carbon\Carbon::now()->startOfWeek()->toDateString(); // or ->format(..)
        $tillDate = Carbon\Carbon::now()->subDay()->startOfWeek()->addDays(6)->toDateString();

        for ($i=0; $i <= 6; $i++) { 
            $amountPerDay[date('d',strtotime($fromDate . '+'.$i.'day'))] = 0;
        }
        
        if($type=='homeowner'){
            $objectToShowList = ReceiptModel::whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])
                                    ->get();
        }elseif($type=='vendor'){   
            $objectToShowList = ExpenseModel::whereBetween(DB::raw('date(created_at)'), [$fromDate, $tillDate])
                                    ->get();
        }
        if(count($objectToShowList)>0){
            foreach ($objectToShowList as $objectToShow) {
                $amountPerDay[date('d',strtotime($objectToShow->created_at))] += $type=='homeowner'?$objectToShow->invoice->total_amount:$objectToShow->total_amount;
            }
        }
        return $amountPerDay;
    }
}
