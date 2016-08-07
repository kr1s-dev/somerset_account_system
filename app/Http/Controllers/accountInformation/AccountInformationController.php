<?php

namespace App\Http\Controllers\accountInformation;

use App\JournalEntryModel;
use Request;
use App\Http\Requests\accountInformation\AccountInformationRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;
use App\AccountDetailModel;

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
        $journalEntryCurrentYearList = JournalEntryModel::whereYear('created_at','=',date('Y'))->get();
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountInformationRequest $request)
    {
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountInformationRequest $request, $id)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
       
    }

}
