<?php

namespace App\Http\Controllers\expense;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class ExpenseController extends Controller
{
    use UtilityHelper;

    /**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        $this->middleware('user.type:expense');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tExpenseList = $this->getExpense(null);
        $eExpenseList = array();

        foreach ($tExpenseList as $tExpense) {
            $eExpenseList[$this->formatString($tExpense->id)] = $tExpense;
        }
        
        return view('expense.expense_list',
                        compact('eExpenseList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$receiptNumber = 1;
        $eReceiptLastRecord = $this->getControlNo('expense_cash_voucher');
        // if(count($eReceiptLastRecord)>0){
        //     $receiptNumber =  ($eReceiptLastRecord->id + 1);
        // }
        $receiptNumber = $eReceiptLastRecord->AUTO_INCREMENT;
        $expenseAccount = $this->getAccountGroups('6'); //get expense account titles
        $vendorList = $this->getExpenseVendor(null);
        return view('expense.create_expense',
                        compact('receiptNumber',
                                'expenseAccount',
                                'vendorList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input('data');
        $paidTo = $request->input('paidTo');
        $totalAmount = $request->input('totalAmount');
        $vendorId = $request->input('vendorId');
        $type = $request->input('type');
        $vendor = $this->getVendor($vendorId);
        try{    
            $description = ('Created Cash Voucher for ') . (($type==='Vendor')?$vendor->vendor_name:$paidTo);
            $nReceiptId = $this->insertRecord('expense_cash_voucher',array('paid_to' => ($type=='Vendor')?'':$paidTo,
                                                                            'total_amount' => $totalAmount,
                                                                            'vendor_id'=>($type=='Vendor')?$vendorId:null));

            $dataToInsert = $this->populateListOfToInsertItems($data,'Expenses','expense_cash_voucher_id',$nReceiptId,'expense_cash_voucher');
            $this->insertBulkRecord('expense_cash_voucher_items',$dataToInsert);
            //Create journal entry
            $this->insertBulkRecord('journal_entry',$this->createJournalEntry($dataToInsert,
                                                                                'Expense',
                                                                                'expense_id',
                                                                                $nReceiptId,
                                                                                $description,
                                                                                $totalAmount));
            flash()->success('Record successfully created');
            echo $nReceiptId;
        }catch(\Exception $ex){
            echo $ex->getMessage() . ' ' . $ex->getLine();
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $eExpense = $this->getExpense($id);
        $eExpenseId = $id;
        return view('expense.show_expense',
                        compact('eExpense',
                                'eExpenseId'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $eExpense = $this->getExpense($id);
        $vendorList = $this->getExpenseVendor($eExpense->vendor_id!=NULL?$eExpense->vendor_id:NULL);
        $eExpenseId = $id;
        $expenseAccount = $this->getAccountGroups('6'); //get expense account titles
        return view('expense.edit_expense',
                        compact('eExpense',
                                'eExpenseId',
                                'expenseAccount',
                                'vendorList'));
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $toDeleteExpItems = array();
        $toDeleteJournalEntry = array();
        $data = $request->input('data');
        $paidTo = $request->input('paidTo');
        $totalAmount = $request->input('totalAmount');
        $type = $request->input('type');
        $vendorId = $request->input('vendorId');
        $vendor = $this->getVendor($vendorId);
        try{
            $description = ('Created Cash Voucher for ') . (($type==='Vendor')?$vendor->vendor_name:$paidTo);
            $this->updateRecord('expense_cash_voucher',
                                    $id,
                                    array('total_amount' => $totalAmount,
                                            'paid_to' => ($type=='Vendor')?'':$paidTo,
                                            'vendor_id'=>($type=='Vendor')?$vendorId:null));

            $this->deleteRecordWithWhere('expense_cash_voucher_items',array('expense_cash_voucher_id'=>$id));
            $this->deleteRecordWithWhere('journal_entry',array('expense_id'=>$id));


            $dataToInsert = $this->populateListOfToInsertItems($data,'Expenses','expense_cash_voucher_id',$id,'expense_cash_voucher');

           

            $this->insertBulkRecord('expense_cash_voucher_items',$dataToInsert);
            //Create journal entry
            $this->insertBulkRecord('journal_entry',$this->createJournalEntry($dataToInsert,
                                                                                'Expense',
                                                                                'expense_id',
                                                                                $id,
                                                                                $description,
                                                                                $totalAmount));
            flash()->success('Record successfully updated');
            echo $id;
        }catch(\Exception $ex){
            echo $ex->getMessage() . ' ' . $ex->getLine();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $toDeleteItems = array();
        // $eExpense = $this->getExpense($id);
        // $toDeleteJournalEntry = array();
        // $eExpenseItemsList = $this->getObjectRecords('expense_cash_voucher_items', array('expense_cash_voucher_id' => $id));
        // $eJournalEntriesList = $this->getObjectRecords('journal_entry',array('expense_id'=>$id));
        // foreach ($eExpenseItemsList as $eExpenseItem) {
        //     $toDeleteItems[] = $eExpenseItem->id;
        // }
        // foreach ($eJournalEntriesList as $eJournalEntry) {
        //     $toDeleteJournalEntry[] = $eJournalEntry->id;
        // }
        // $this->deleteRecord('journal_entry',$toDeleteJournalEntry);
        // $this->deleteRecord('expense_cash_voucher_items',$toDeleteItems);
        // $this->deleteRecord('expense_cash_voucher',array($id));
        $this->deleteRecordWithWhere('expense_cash_voucher_items',array('expense_cash_voucher_id'=>$id));
        $this->deleteRecordWithWhere('journal_entry',array('expense_id'=>$id));
        $this->deleteRecordWithWhere('expense_cash_voucher',array('id'=>$id));
        flash()->success('Record successfully deleted')->important();
        return redirect('expense');
    }
}
