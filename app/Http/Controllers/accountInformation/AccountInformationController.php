<?php

namespace App\Http\Controllers\accountInformation;

use Request;
use App\AccountTitleModel;
use App\JournalEntryModel;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class AccountInformationController extends Controller
{
    use UtilityHelper;

    /**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        $this->middleware('user.type:accountinformation');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $dateToday = date('F', mktime(0, 0, 0, 1, 10)) . ' ' . date('Y');
        $dateNextYear =  date('F', mktime(0, 0, 0, 12, 10)) . ' ' . date('Y',strtotime('+1 years'));
        $journalEntryCurrentYearList = JournalEntryModel::whereYear('created_at','=',date('Y'))->where('is_closed','=','0')->get();
        $accountTitleGroupList = $this->getAccountGroups(null);
        $accountTitlesList =  $this->getAccountTitles(null);
        $fBalanceSheetItemsList = array();
        $expenseTotal=0;
        $incomeTotal=0;
        $assetTotal=0;
        $liabilitiesTotal=0;

        foreach ($accountTitleGroupList as $accountTitleGroup) {
            if(!array_key_exists($accountTitleGroup->account_group_name,$fBalanceSheetItemsList)){
                $fBalanceSheetItemsList[$accountTitleGroup->account_group_name] = array();
            }
        }

        $aTitleItemsList = $this->getJournalEntryRecordsWithFilter(null,null,date('Y'));
        $eBalanceSheetItemsList = $this->getItemsAmountList($aTitleItemsList,null);
        
        foreach ($accountTitlesList as $accountTitle) {
            if (array_key_exists($accountTitle->account_sub_group_name,$eBalanceSheetItemsList)) {
                if(array_key_exists($accountTitle->group->account_group_name,$fBalanceSheetItemsList)){
                    $tArray = $fBalanceSheetItemsList[$accountTitle->group->account_group_name];
                    $tArray[$accountTitle->account_sub_group_name] =  $eBalanceSheetItemsList[$accountTitle->account_sub_group_name];
                    $fBalanceSheetItemsList[$accountTitle->group->account_group_name] = $tArray;
                }
            }
        }

        foreach(array_keys($fBalanceSheetItemsList) as $key) {
            if(strpos($key, 'Assets')){
                $assetTotal+= ($this->getTotalSum($fBalanceSheetItemsList[$key]));
            }elseif(strpos($key, 'Liabilities')){
                $liabilitiesTotal+= ($this->getTotalSum($fBalanceSheetItemsList[$key]));
            }elseif(strpos($key, 'Revenue') || $key=='Revenues'){
                $incomeTotal+=($this->getTotalSum($fBalanceSheetItemsList[$key]));
            }elseif(strpos($key, 'Expense') || $key=='Expenses'){
                $expenseTotal+=($this->getTotalSum($fBalanceSheetItemsList[$key]));
            }
        }

        //echo $expenseTotal;
        
        return view('accountInformation.show_account',
                        compact('dateNextYear',
                                'dateToday',
                                'journalEntryCurrentYearList',
                                'incomeTotal',
                                'expenseTotal',
                                'assetTotal',
                                'liabilitiesTotal'));
    }

    public function closeAccountingYear(){
        $accountTitles = array();
        $accountGroupsList = $this->getAccountGroups(null);
        $currYrJourEntryList = $this->getJournalEntryRecordsWithFilter(null,null,date('Y'));
        $fCurrJournEntList = $this->getItemsAmountList($currYrJourEntryList,null);
        
        foreach ($accountGroupsList as $acctGrp) {
            if($acctGrp->account_group_name != 'Revenues' && $acctGrp->account_group_name != 'Expenses'){
                foreach ($acctGrp->accountTitles as $acctTitle) {
                    if(array_key_exists($acctTitle->account_sub_group_name, $fCurrJournEntList)){
                        $acctTitle->opening_balance += $fCurrJournEntList[$acctTitle->account_sub_group_name];
                        $acctTitle->save();
                    }
                }
            }
        }

        foreach ($currYrJourEntryList as $journEntry) {
            $journEntry->is_closed = true;
            $journEntry->save();
        }

        $this->createSystemLogs('Closed Current Accounting Year');
        flash()->success('Accounting Year Successfully Closed')->important();
        return redirect('account');
    }

}
