<?php

namespace App\Http\Controllers\reports;

use Illuminate\Http\Request;
use App\ReceiptModel;
use App\ExpenseModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class ReportController extends Controller
{
    use UtilityHelper;
    
    /**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        $this->middleware('user.type:reports');
    }

	public function postGenerateIncomeStatement(Request $request){
		$monthFilter = $request->input('month_filter');
		$yearFilter = $request->input('year_filter');
		return $this->generateIncomeStatement($monthFilter,$yearFilter);
	}

    public function getGenerateIncomeStatement(){
    	return $this->generateIncomeStatement(null,null);

    }

    public function postGenerateOwnersEquityStatement(Request $request){
		$monthFilter = $request->input('month_filter');
		$yearFilter = $request->input('year_filter');
		return $this->generateOwnersEquityStatement($monthFilter,$yearFilter);
	}

    public function getGenerateOwnersEquityStatement(){
    	return $this->generateOwnersEquityStatement(null,null);

    }

    public function postGenerateBalanceSheet(Request $request){
        $monthFilter = $request->input('month_filter');
        $yearFilter = $request->input('year_filter');
        return $this->generateBalanceSheet($monthFilter,$yearFilter);
    }

    public function getGenerateBalanceSheet(){
        return $this->generateBalanceSheet(null,null);
    }

    public function postGenerateSubsidiaryLedger(Request $request){
        $monthFilter = $request->input('month_filter');
        $yearFilter = $request->input('year_filter');
        return $this->generateSubsidiaryLedger($monthFilter,$yearFilter,$request->input('type'));
    }

    public function getGenerateSubsidiaryLedger($type){
        return $this->generateSubsidiaryLedger(null,null,$type);
    }


    public function generateIncomeStatement($monthFilter,$yearFilter){
    	$yearFilter = $yearFilter==NULL?date('Y'):date($yearFilter);
    	$monthArray = $this->monthsGenerator();

    	$incStatementItemsList = $this->getJournalEntryRecordsWithFilter('5',$monthFilter,$yearFilter);
    	$expStatementItemsList = $this->getJournalEntryRecordsWithFilter('6',$monthFilter,$yearFilter);

    	$incomeItemsList = $this->getItemsAmountList($incStatementItemsList,'Income');
    	$expenseItemsList = $this->getItemsAmountList($expStatementItemsList,'Expense');

    	$incTotalSum = $this->getTotalSum($incomeItemsList);
    	$expTotalSum = $this->getTotalSum($expenseItemsList);

		return view('reports.income_statement',
						compact('incomeItemsList',
								'expenseItemsList',
								'incTotalSum',
								'expTotalSum',
								'monthArray',
								'yearFilter',
								'monthFilter'));
    }

    public function generateOwnersEquityStatement($monthFilter,$yearFilter){
    	$yearFilter = $yearFilter==NULL?date('Y'):date($yearFilter);
    	$monthArray = $this->monthsGenerator();

    	$incStatementItemsList = $this->getJournalEntryRecordsWithFilter('5',$monthFilter,$yearFilter);
        $expStatementItemsList = $this->getJournalEntryRecordsWithFilter('6',$monthFilter,$yearFilter);

        $incomeItemsList = $this->getItemsAmountList($incStatementItemsList,'Income');
        $expenseItemsList = $this->getItemsAmountList($expStatementItemsList,'Expense');

        $incTotalSum = $this->getTotalSum($incomeItemsList);
        $expTotalSum = $this->getTotalSum($expenseItemsList);

    	$totalProfit = ($incTotalSum  - $expTotalSum);

    	$ownerEquityItemsList = $this->getJournalEntryRecordsWithFilter('7',$monthFilter,$yearFilter);

    	$equityItemsList = $this->getItemsAmountList($ownerEquityItemsList,'Equity');

    	$eqTotalSum = ($this->getTotalSum($equityItemsList)) + $totalProfit ;

    	//print_r($equityItemsList);
    	return view('reports.statement_of_owners_equity',
    					compact('yearFilter',
    							'monthFilter',
    							'monthArray',
    							'eqTotalSum',
    							'equityItemsList',
    							'totalProfit'));
    }

    public function generateBalanceSheet($monthFilter,$yearFilter){
        $yearFilter = $yearFilter==NULL?date('Y'):date($yearFilter);
        $monthArray = $this->monthsGenerator();
        $accountTitlesList =  $this->getAccountTitles(null);
        $accountTitleGroupList = $this->getAccountGroups(null);
        $fBalanceSheetItemsList = array();
        $totalAssets = 0;
        $totalEquity = 0;
        $totalLiability = 0;

        $incStatementItemsList = $this->getJournalEntryRecordsWithFilter('5',$monthFilter,$yearFilter);
        $expStatementItemsList = $this->getJournalEntryRecordsWithFilter('6',$monthFilter,$yearFilter);

        $incomeItemsList = $this->getItemsAmountList($incStatementItemsList,'Income');
        $expenseItemsList = $this->getItemsAmountList($expStatementItemsList,'Expense');

        $incTotalSum = $this->getTotalSum($incomeItemsList);
        $expTotalSum = $this->getTotalSum($expenseItemsList);

        $totalProfit = ($incTotalSum  - $expTotalSum);

        $aTitleItemsList = $this->getJournalEntryRecordsWithFilter(null,$monthFilter,$yearFilter);
        //print_r($aTitleItemsList);
        $eBalanceSheetItemsList = $this->getItemsAmountList($aTitleItemsList,null);


        foreach ($accountTitleGroupList as $accountTitleGroup) {
            if(!array_key_exists($accountTitleGroup->account_group_name,$fBalanceSheetItemsList)){
                $fBalanceSheetItemsList[$accountTitleGroup->account_group_name] = array();
            }
        }
        //print_r($eBalanceSheetItemsList);
        foreach ($accountTitlesList as $accountTitle) {
            if (array_key_exists($accountTitle->account_sub_group_name,$eBalanceSheetItemsList)) {
                if(array_key_exists($accountTitle->group->account_group_name,$fBalanceSheetItemsList)){
                    $tArray = $fBalanceSheetItemsList[$accountTitle->group->account_group_name];
                    $tArray[$accountTitle->account_sub_group_name] = strpos($accountTitle->account_sub_group_name, 'Capital') || $accountTitle->account_sub_group_name === 'Capital'? 
                                                                        ($eBalanceSheetItemsList[$accountTitle->account_sub_group_name] + $totalProfit) 
                                                                            : $eBalanceSheetItemsList[$accountTitle->account_sub_group_name];
                    $fBalanceSheetItemsList[$accountTitle->group->account_group_name] = $tArray;
                }
            }
        }

        //print_r($fBalanceSheetItemsList);
        
        foreach (array_keys($fBalanceSheetItemsList) as $key) {
            if(strpos($key, 'Assets')){
                $totalAssets+= ($this->getTotalSum($fBalanceSheetItemsList[$key]));
            }else if(strpos($key, 'Equity')){
                $totalEquity+= ($this->getTotalSum($fBalanceSheetItemsList[$key]));
            }else if(strpos($key, 'Liabilities')){
                $totalLiability+= ($this->getTotalSum($fBalanceSheetItemsList[$key]));
            }
        }
        //echo $totalAssets;
        return view('reports.balance_sheet',
                        compact('yearFilter',
                                'monthFilter',
                                'monthArray',
                                'fBalanceSheetItemsList',
                                'totalAssets',
                                'totalEquity',
                                'totalLiability'));
    }

    public function generateSubsidiaryLedger($monthFilter,$yearFilter,$type){
        $yearFilter = $yearFilter==NULL?date('Y'):date($yearFilter);
        $monthArray = $this->monthsGenerator();
        $listOfItem = array(); //Key => Payee, Value => array(Items)
        $itemsList = array();
        $query;
        if($type=='homeowner'){
            $query = ReceiptModel::whereYear('created_at','=',$yearFilter);
        }else if($type=='vendor'){
            $query = ExpenseModel::whereYear('created_at','=',$yearFilter);
        }

        if(!empty($monthFilter))
            $query->whereMonth('created_at','=',$monthFilter);
        
        $itemsList = $query->get();
        
        foreach ($itemsList as $item) {
            $payeeName = $type=='homeowner' ? $item->invoice->homeOwner->first_name . ' ' . 
                                $item->invoice->homeOwner->middle_name . ' ' .
                                $item->invoice->homeOwner->last_name : 
                                ($item->paid_to!=''?$item->paid_to:$item->vendor->vendor_name);

            
            foreach (($type=='homeowner'? $item->invoice->invoiceItems : $item->expenseItems)  as $val) {
                if(array_key_exists($payeeName, $listOfItem)){
                    $tItems = $listOfItem[$payeeName];
                    $tItems[] = $val;
                    $listOfItem[$payeeName] = $tItems;
                }else{
                    $listOfItem[$payeeName] = array($val);
                }
            }
        }

        return view('reports.subsidiary_ledger',
                        compact('listOfItem',
                                'monthArray',
                                'yearFilter',
                                'monthFilter',
                                'type'));
    }
}
