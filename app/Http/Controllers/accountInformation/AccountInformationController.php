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
        $expenseTotal=0;
        $incomeTotal=0;
        $assetTotal=0;
        $liabilitiesTotal=0;

        foreach ($journalEntryCurrentYearList as $journalEntry) {
            if($journalEntry->invoice_id != NULL){
                $journalEntry->invoice_id = $this->formatString($journalEntry->invoice_id);
                $incomeTotal += ($journalEntry->invoice->total_amount);
            }
            if($journalEntry->receipt_id != NULL){
                $journalEntry->receipt_id = $this->formatString($journalEntry->receipt_id);

            }
            if($journalEntry->expense_id != NULL){
                $journalEntry->expense_id = $this->formatString($journalEntry->expense_id);
                $expenseTotal +=($journalEntry->expense->total_amount);
            }

        }
        return view('accountInformation.show_account',
                        compact('dateNextYear',
                                'dateToday',
                                'journalEntryCurrentYearList',
                                'incomeTotal',
                                'expenseTotal'));
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
