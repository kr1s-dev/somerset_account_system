<?php

namespace App\Http\Controllers\admin;

use DB;
use Carbon;
use App\JournalEntryModel;
use App\ReceiptModel;
use App\ExpenseModel;
use App\InvoiceModel;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class AdminDashboardController extends Controller
{
    use UtilityHelper;
    public function getDashBoard(){
        try{
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
                foreach(range(1, date('m')) as $month) {
                    $incomeAmountPerMonth[date('m',strtotime(date('Y').'-'.$month))] = 0;
                }
            }   

            if(count($expStatementItemsList)>0){
                $expenseItemsList = $this->getItemsAmountList($expStatementItemsList,'Expense');
                $expenseAmountPerMonth = $this->getAmountPerMonth($expStatementItemsList);
                $expTotalSum = $this->getTotalSum($expenseItemsList);
            }else{
                foreach(range(1, date('m')) as $month) {
                    $expenseAmountPerMonth[date('m',strtotime(date('Y').'-'.$month))] = 0;
                }
            }
            $homeOwnerSubsidiaryLedgerPerWeek = $this->generateSubsidiaryLedger('homeowner');
            $totalHomeOwnerAmountPerWeek = $this->getTotalSum($homeOwnerSubsidiaryLedgerPerWeek);

            $homeVendorSubsidiaryLedgerPerWeek = $this->generateSubsidiaryLedger('vendor');
            $totalVendorAmountPerWeek = $this->getTotalSum($homeVendorSubsidiaryLedgerPerWeek);

            $invoiceList = InvoiceModel::where('payment_due_date','<',date('Y-m-d'))
                                         ->where('invoice_id','=',NULL) 
                                         ->where('is_paid','=','0')
                                         ->get();
            //print_r($homeOwnerSubsidiaryLedgerPerWeek);
            return view('admin_dashboard.admin_dashboard',
                            compact('incTotalSum',
                                    'expTotalSum',
                                    'incomeAmountPerMonth',
                                    'expenseAmountPerMonth',
                                    'homeOwnerSubsidiaryLedgerPerWeek',
                                    'totalHomeOwnerAmountPerWeek',
                                    'homeVendorSubsidiaryLedgerPerWeek',
                                    'totalVendorAmountPerWeek',
                                    'invoiceList')); 
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
        
    }


    public function getAmountPerMonth($dataList){
        $amountPerMonth = array();
        foreach(range(1, date('m')) as $month) {
            $amountPerMonth[trim(date('m',strtotime(date('Y').'-'.$month)),'0')] = 0;
        }
        foreach ($dataList as $data) {
            $amountPerMonth[trim(date('m',strtotime($data->created_at)),'0')] += ($data->credit_amount+$data->debit_amount);
            //echo $data;
        }
        return $amountPerMonth;
    }

    public function generateSubsidiaryLedger($type){
        $amountPerDay = array();
        $objectToShowList;
        $startOfTheWeek = date('Y-m-d',strtotime('monday this week'));
        $endOfTheWeek = date('Y-m-d',strtotime('sunday this week'));

        for ($i=0; $i <= 6; $i++) { 
            $amountPerDay[date('d',strtotime($startOfTheWeek . '+'.$i.'day'))] = 0;
        }
      
        if($type=='homeowner'){
            $objectToShowList = ReceiptModel::whereBetween(DB::raw('date(created_at)'), [$startOfTheWeek, $endOfTheWeek])
                                    ->get();
        }elseif($type=='vendor'){   
            $objectToShowList = ExpenseModel::whereBetween(DB::raw('date(created_at)'), [$startOfTheWeek, $endOfTheWeek])
                                    ->get();
        }
        if(count($objectToShowList)>0){
            foreach ($objectToShowList as $objectToShow) {
                $amountPerDay[date('d',strtotime($objectToShow->created_at))] += $type=='homeowner'?$objectToShow->invoice->total_amount:$objectToShow->total_amount;
            }
        }
        return $amountPerDay;
    }

    public function getJournalEntryRecordsWithFilter($accountGroupId,$monthFilter,$yearFilter){
        $yearFilter = $yearFilter==NULL?date('Y'):date($yearFilter);
        $query = null;
        if(!is_null($accountGroupId)){
            $query = JournalEntryModel::orWhere(function($query) use ($accountGroupId){
                                                    $query->whereHas('credit',function($q) use ($accountGroupId){
                                                        $q->where('account_group_id', '=', $accountGroupId);
                                                    })
                                                    ->orWhereHas('debit',function($q) use ($accountGroupId){
                                                        $q->where('account_group_id', '=', $accountGroupId);
                                                    });
                                                });
        }

        if(empty($monthFilter)){
            $query  = $query==NULL? JournalEntryModel::whereYear('created_at','=',$yearFilter) : 
                            $query->whereYear('created_at','=',$yearFilter);
        }else{
            $monthFilter = $monthFilter==NULL?date('m'):date($monthFilter); 
            $query  = $query==NULL? JournalEntryModel::whereYear('created_at','=',$yearFilter)
                                                        ->whereMonth('created_at','=',$monthFilter) : 
                                                            $query->whereYear('created_at','=',$yearFilter)
                                                                    ->whereMonth('created_at','=',$monthFilter);
        }
        return $query->get();
              
    }
}