<?php

namespace App\Http\Controllers\reports;

use Illuminate\Http\Request;
use App\HomeOwnerPendingPaymentModel;
use App\ExpenseItemModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
	public function postGenerateIncomeStatement(Request $request){
		$monthFilter = $request->input('month_filter');
		$yearFilter = $request->input('year_filter');
		return $this->generateIncomeStatement($monthFilter,$yearFilter);
	}

    public function getGenerateIncomeStatement(){
    	return $this->generateIncomeStatement(null,null);

    }

    public function generateIncomeStatement($monthFilter,$yearFilter){
    	$monthArray = array('01'=>'January',
    						'02'=>'February',
    						'03'=>'March',
    						'04'=>'April',
    						'05'=>'May',
    						'06'=>'June',
    						'07'=>'July',
    						'08'=>'August',
    						'09'=>'September',
    						'10'=>'October',
    						'11'=>'November',
    						'12'=>'December');
    	
    	
    	//array for income and expense
    	$incomeItemsList = array();
    	$expenseItemsList = array();

    	$yearFilter = $yearFilter==NULL?date('Y'):date($yearFilter);
    	if(empty($monthFilter)){
    		//Get Income Statements
	    	$incStatementItemsList = HomeOwnerPendingPaymentModel::whereYear('created_at','=',$yearFilter)->get();

			$expStatementItemsList = ExpenseItemModel::whereYear('created_at','=',$yearFilter)->get();

    	}else{
    		$monthFilter = $monthFilter==NULL?date('m'):date($monthFilter);	
    		//Get Income Statements
	    	$incStatementItemsList = HomeOwnerPendingPaymentModel::whereYear('created_at','=',$yearFilter)
						    												->whereMonth('created_at','=',$monthFilter)
						    												->get();

			$expStatementItemsList = ExpenseItemModel::whereYear('created_at','=',$yearFilter)
						    												->whereMonth('created_at','=',$monthFilter)
						    												->get();

    	}
    	
		foreach ($incStatementItemsList as $incStatementItem) {
			if(array_key_exists($incStatementItem->accountTitle->account_sub_group_name,$incomeItemsList)){
				$incomeItemsList[$incStatementItem->accountTitle->account_sub_group_name] = ($incomeItemsList[$incStatementItem->accountTitle->account_sub_group_name] + $incStatementItem->amount);
			}else{
				$incomeItemsList[$incStatementItem->accountTitle->account_sub_group_name] = $incStatementItem->amount;
			}
		}


		foreach ($expStatementItemsList as $expStatementItem) {
			if(array_key_exists($expStatementItem->accountTitle->account_sub_group_name,$expenseItemsList)){
				$expenseItemsList[$expStatementItem->accountTitle->account_sub_group_name] = ($expenseItemsList[$expStatementItem->accountTitle->account_sub_group_name] + $expStatementItem->amount);
			}else{
				$expenseItemsList[$expStatementItem->accountTitle->account_sub_group_name] = $expStatementItem->amount;
			}
		}

		$incTotalSum = count($incomeItemsList)>0?array_sum($incomeItemsList):0;
		$expTotalSum = count($expenseItemsList)>0?array_sum($expenseItemsList):0;

		return view('reports.income_statement',
						compact('incomeItemsList',
								'expenseItemsList',
								'incTotalSum',
								'expTotalSum',
								'monthArray',
								'yearFilter',
								'monthFilter'));
    }
}
