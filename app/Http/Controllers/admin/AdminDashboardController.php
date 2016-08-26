<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

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

    	$incStatementItemsList = $this->getJournalEntryRecordsWithFilter('5',null,date('Y'));
    	$expStatementItemsList = $this->getJournalEntryRecordsWithFilter('6',null,date('Y'));

    	if(count($incStatementItemsList)>0){
    		$incomeItemsList = $this->getItemsAmountList($incStatementItemsList,'Income');
    		$incomeAmountPerMonth = $this->getAmountPerMonth($incStatementItemsList);
    	}

    	if(count($expStatementItemsList)>0){
    		$expenseItemsList = $this->getItemsAmountList($expStatementItemsList,'Expense');
    		$expenseAmountPerMonth = $this->getAmountPerMonth($expStatementItemsList);
    	}


    	$incTotalSum = $this->getTotalSum($incomeItemsList);
    	$expTotalSum = $this->getTotalSum($expenseItemsList);
        return view('admin_dashboard.admin_dashboard',
        				compact('incTotalSum',
        						'expTotalSum',
        						'incomeAmountPerMonth',
        						'expenseAmountPerMonth'));
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
}
