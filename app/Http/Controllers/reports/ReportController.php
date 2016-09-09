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
        try{
            $monthFilter = $request->input('month_filter');
            $yearFilter = $request->input('year_filter');
            return $this->generateIncomeStatement($monthFilter,$yearFilter);
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
		
	}

    public function getGenerateIncomeStatement(){
        try{
            return $this->generateIncomeStatement(null,null);
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
    	

    }

    public function postGenerateOwnersEquityStatement(Request $request){
        try{
            $monthFilter = $request->input('month_filter');
            $yearFilter = $request->input('year_filter');
            return $this->generateOwnersEquityStatement($monthFilter,$yearFilter);
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
		
	}

    public function getGenerateOwnersEquityStatement(){
        try{
            return $this->generateOwnersEquityStatement(null,null);
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
    	

    }

    public function postGenerateBalanceSheet(Request $request){
        try{
            $monthFilter = $request->input('month_filter');
            $yearFilter = $request->input('year_filter');
            return $this->generateBalanceSheet($monthFilter,$yearFilter);    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
        
    }

    public function getGenerateBalanceSheet(){
        try{
            return $this->generateBalanceSheet(null,null);    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
        
    }

    public function postGenerateSubsidiaryLedger(Request $request){
        try{
            $monthFilter = $request->input('month_filter');
            $yearFilter = $request->input('year_filter');
            return $this->generateSubsidiaryLedger($monthFilter,$yearFilter,$request->input('type'));    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
        
    }

    public function getGenerateSubsidiaryLedger($type){
        try{
            return $this->generateSubsidiaryLedger(null,null,$type);    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
        
    }

    public function getGenerateAssetRegistry(){
        try{
            $assetItemList = $this->getAssetModel(null);
            return view('reports.asset_registry',
                            compact('assetItemList'));    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
        
    }

    public function getGenerateStatementOfCashFlow(){
        try{
            return $this->generateStatementOfCashFlow(date('Y'));
        }catch(\Exception $ex){
            echo $ex->getMessage();
            ////return view('errors.404'); 
            echo $ex->getMessage();
        }
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


    public function generateStatementOfCashFlow($yearFilter){
        $accountGroupList = $this->getAccountGroups(null);
        $incStatementItemsList = $this->getJournalEntryRecordsWithFilter('5',null,$yearFilter);
        $expStatementItemsList = $this->getJournalEntryRecordsWithFilter('6',null,$yearFilter);
        $incomeItemsList = $this->getItemsAmountList($incStatementItemsList,'Income');
        $incTotalSum = $this->getTotalSum($incomeItemsList);
        $expenseItemsList = $this->getItemsAmountList($expStatementItemsList,'Expense');
        $arBalance = 0;
        $expenseList = array();
        $investmentList = array();
        $financingList = array();
        $totalCashInHand = array();
        if($yearFilter == date('Y')){
            $aTitleItemsList = $this->getJournalEntryRecordsWithFilter(null,null,$yearFilter);
            $eBalanceSheetItemsList = $this->getItemsAmountList($aTitleItemsList,null);
            foreach ($accountGroupList as $accountGroup) {
                if(strrpos($accountGroup->account_group_name, 'Assets') || strrpos($accountGroup->account_group_name, 'Liabilities')){
                    foreach ($accountGroup->accountTitles as $actTitle) {
                        if(array_key_exists($actTitle->account_sub_group_name, $eBalanceSheetItemsList))
                            $actTitle->opening_balance += $eBalanceSheetItemsList[$actTitle->account_sub_group_name];
                        if($actTitle->account_sub_group_name=='Accounts Receivable')
                            $arBalance = $actTitle->opening_balance;
                    }
                }
            }
            foreach ($accountGroupList as $accountGroup) {
                if($accountGroup->account_group_name === 'Non-Current Assets'){
                    foreach ($accountGroup->accountTitles as $actTitle) {
                        $investmentList[$actTitle->account_sub_group_name] = $actTitle->opening_balance;

                        foreach ($actTitle->assetItems as $astItem) {
                            if($astItem->mode_of_acquisition == 'Payable'){
                                $investmentList[$actTitle->account_sub_group_name] -= $astItem->total_cost;
                            }else if($astItem->mode_of_acquisition == 'Both'){
                                $investmentList[$actTitle->account_sub_group_name] -= $astItem->down_payment;
                            }
                        }
                    }
                }

                if($accountGroup->account_group_name === 'Owners Equity'){
                    foreach ($accountGroup->accountTitles as $actTitle) {
                        $financingList[$actTitle->account_sub_group_name] = $actTitle->opening_balance;
                    }
                }
                foreach ($accountGroup->accountTitles as $actTitle) {
                    if(strrpos($actTitle->account_sub_group_name,'Loans')){
                        $financingList[$actTitle->account_sub_group_name] = $actTitle->opening_balance;
                    }
                }

            }
            $expenseList = $this->getOperationalExpense($expenseItemsList,$accountGroupList);
        }else{

        }

        $totalCashInHand = ($incTotalSum - $arBalance) - ($this->getTotalSum($expenseList)) - ($this->getTotalSum($investmentList)) + ($this->getTotalSum($financingList));

        return view('reports.statement_of_cash_flow',
                        compact('incTotalSum',
                                'arBalance',
                                'expenseList',
                                'yearFilter',
                                'investmentList',
                                'financingList',
                                'totalCashInHand'));

    }

    public function getOperationalExpense($expenseItemsList,$accountGroupList){
        $expPayableList;
        foreach ($accountGroupList as $accountGroup) {
            if($accountGroup->account_group_name == 'Current Liabilities'){
                $expPayableList = $accountGroup->accountTitles;
            }
        }

        foreach ($expenseItemsList as $key=>$value) {
            foreach ($expPayableList as $exPpay) {
                $tTitle = str_replace(strpos($key, 'Expense')?'Expense':'Expenses', '', $key);
                if(strcmp($exPpay->account_sub_group_name,$tTitle) > 1){
                    $expenseItemsList[$key] -= $exPpay->opening_balance;
                    break;
                }
            }
        }
        return $expenseItemsList;
    }
}
