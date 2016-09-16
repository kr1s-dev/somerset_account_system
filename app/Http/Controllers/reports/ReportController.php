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
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
		
	}

    public function getGenerateIncomeStatement(){
        try{
            return $this->generateIncomeStatement(null,null);
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
    	

    }

    public function postGenerateOwnersEquityStatement(Request $request){
        try{
            $monthFilter = $request->input('month_filter');
            $yearFilter = $request->input('year_filter');
            return $this->generateOwnersEquityStatement($monthFilter,$yearFilter);
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
		
	}

    public function getGenerateOwnersEquityStatement(){
        try{
            return $this->generateOwnersEquityStatement(null,null);
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
    	

    }

    public function postGenerateBalanceSheet(Request $request){
        try{
            $monthFilter = $request->input('month_filter');
            $yearFilter = $request->input('year_filter');
            return $this->generateBalanceSheet($monthFilter,$yearFilter);    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }

    public function getGenerateBalanceSheet(){
        try{
            return $this->generateBalanceSheet(null,null);    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }

    public function postGenerateSubsidiaryLedger(Request $request){
        try{
            $monthFilter = $request->input('month_filter');
            $yearFilter = $request->input('year_filter');
            return $this->generateSubsidiaryLedger($monthFilter,$yearFilter,$request->input('type'));    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }

    public function getGenerateSubsidiaryLedger($type){
        try{
            return $this->generateSubsidiaryLedger(null,null,$type);    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }

    public function getGenerateAssetRegistry(){
        try{
            $assetItemList = $this->getAssetModel(null);
            return view('reports.asset_registry',
                            compact('assetItemList'));    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }

    public function getGenerateStatementOfCashFlow(){
        try{
            return $this->generateStatementOfCashFlow(date('Y'));
        }catch(\Exception $ex){
            echo $ex->getMessage() . $ex->getLine();
            //return view('errors.404'); 
            //echo $ex->getMessage();
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
        $eBalanceSheetItemsList = $this->getCustomItemsAmountList($aTitleItemsList,null);


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
        $yearFilter = $yearFilter==NULL?date('Y'):$yearFilter;
        $accountGroupList = $this->getAccountGroups(null);
        $totalProfit = 0;
        $depreciationValue = 0;
        $totalCashInHand = 0;
        $totalOperationCash = 0;
        $totalInvestmentCash = 0;
        $totalFinancingCash = 0;
        $lastYearsBalanceSht = array();
        $thisYearsBalanceSht = array();
        $investmentActivities = array();
        $accountTitleList = array();
        $incStatementItemsList = $this->getJournalEntryRecordsWithFilter('5',null,$yearFilter);
        $expStatementItemsList = $this->getJournalEntryRecordsWithFilter('6',null,$yearFilter);

        $incomeItemsList = $this->getItemsAmountList($incStatementItemsList,'Income');
        $expenseItemsList = $this->getItemsAmountList($expStatementItemsList,'Expense');

        $incTotalSum = $this->getTotalSum($incomeItemsList);
        $expTotalSum = $this->getTotalSum($expenseItemsList);
        $totalProfit = ($incTotalSum  - $expTotalSum);
        $tLastYearsBalanceSht = $this->getJournalEntryRecordsWithFilter(null,null,$yearFilter - 1);
        $tThisYearsBalanceSht = $this->getJournalEntryRecordsWithFilter(null,null,$yearFilter);
        //echo count($tThisYearsBalanceSht);  
        $lastYearsBalanceSht = $this->getItemsAmountList($tLastYearsBalanceSht,null);
        $thisYearsBalanceSht = $this->getItemsAmountList($tThisYearsBalanceSht,null);

        foreach ($thisYearsBalanceSht as $key => $value) {
            if(array_key_exists($key, $lastYearsBalanceSht))
                $thisYearsBalanceSht[$key] -= $lastYearsBalanceSht[$key];
        }

        foreach ($expenseItemsList as $key => $value) {
            if(strrpos('x'.$key,'Depreciation'))
                $depreciationValue += $value;
        }

        foreach ($accountGroupList as $accountGrp) {
            $accountTitleList[$accountGrp->account_group_name] = $accountGrp->accountTitles;
        }

        foreach ($accountTitleList as $key => $value) {
            foreach ($value as $val) {
                if(array_key_exists($val->account_sub_group_name, $thisYearsBalanceSht)){
                    $val->opening_balance = $thisYearsBalanceSht[$val->account_sub_group_name];
                }
            }
        }
        
        foreach ($accountTitleList as $key => $value) {
            if($key == 'Current Assets'){
                foreach ($value as $val) {
                    if(strrpos('x'. $val->account_sub_group_name, 'Cash')===false){
                        if(strrpos($key, 'Asset')){
                            $totalOperationCash-=$val->opening_balance;
                        }else{
                            $totalOperationCash+=$val->opening_balance;
                        }
                    }
                }
            }
        } 
        $count = 0;
        //For Acquiring Asset via Cash
        foreach ($tThisYearsBalanceSht as $key) {
            if($key->asset_id != NULL){
                if($key->credit_title_id != NULL && $key->credit->account_sub_group_name == 'Cash'){
                    if($tThisYearsBalanceSht[$count-1]->debit_title_id!=NULL){
                        $tKey = 'Purchase of ' . $tThisYearsBalanceSht[$count-1]->debit->account_sub_group_name;
                    }else{
                        $tKey = 'Purchase of ' . $tThisYearsBalanceSht[$count-2]->debit->account_sub_group_name;
                    }
                    
                    if(!array_key_exists($tKey, $investmentActivities))
                        $investmentActivities[$tKey] = 0;
                    $investmentActivities[$tKey] +=$key->credit_amount;
                    $totalInvestmentCash += $key->credit_amount;
                }
            }
            $count+=1;
        }

        foreach ($accountTitleList as $key => $value) {
            if(strpos('x' . $key, 'Non-Current Liabilities')){
                foreach ($value as $val) {
                    if(strrpos('x'.$val->account_sub_group_name,'Loan')){
                        $totalFinancingCash+=$val->opening_balance;
                    }
                }
            }
        }

        foreach ($accountTitleList as $key => $value) {
            if(strpos('x' . $key, 'Equity')){
                foreach ($value as $val) {
                    $totalFinancingCash+=$val->opening_balance;
                }
            }
        }

        return view('reports.statement_of_cash_flow',
                        compact('totalProfit',
                                'depreciationValue',
                                'accountTitleList',
                                'totalOperationCash',
                                'totalInvestmentCash',
                                'totalFinancingCash',
                                'tThisYearsBalanceSht',
                                'investmentActivities',
                                'yearFilter'));

    }


    public function getCustomItemsAmountList($arrayToProcessList,$typeOfData){
        $data = array();
        if($typeOfData == 'Equity'){
            $accountGroup =  AccountGroupModel::where('account_group_name', 'like', '%'.$typeOfData.'%')
                                                ->get();
            foreach ($accountGroup as $accountGrp) {
                foreach ($accountGrp->accountTitles as $accountTitle) {
                    $data[$accountTitle->account_sub_group_name] = 0;
                }
            }
        }else if(is_null($typeOfData)){
            $accountGroup =  $this->getAccountGroups(null);
            foreach ($accountGroup as $accountGrp) {
                foreach ($accountGrp->accountTitles as $accountTitle) {
                    $data[$accountTitle->account_sub_group_name] = $accountTitle->opening_balance;
                }
            }
        }

        if(!empty($arrayToProcessList)){
            foreach ($arrayToProcessList as $arrayToProcess) {
                $typeOfData = $arrayToProcess->credit_title_id == NULL ? $arrayToProcess->debit->group->account_group_name : $arrayToProcess->credit->group->account_group_name;
                $amount = ($arrayToProcess->debit_amount - $arrayToProcess->credit_amount);
                $accountTitle = $arrayToProcess->credit_title_id == NULL ? $arrayToProcess->debit->account_sub_group_name : $arrayToProcess->credit->account_sub_group_name;

                if(array_key_exists($accountTitle,$data)){
                    $data[$accountTitle] += (strpos($typeOfData, 'Revenues') !== false || strpos($typeOfData, 'Equity') | strpos($typeOfData, 'Liabilities') ? 
                                                ($amount * -1)  : $amount);
                }else{
                    $data[$accountTitle] = $typeOfData == 'Revenues' ? ($amount * -1)  : $amount;
                }
            }
        }
        return $data;
    }
    
}
