<?php

namespace App\Http\Controllers\expense;

use Hash;
use App\User;
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
        try{
            $eExpenseList = $this->getExpense(null);
            return view('expense.expense_list',
                            compact('eExpenseList'));    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            $type = 'Expense';
            $expenseAccountItems = array();
            $eReceiptLastRecord = $this->getObjectLastRecord('expense_cash_voucher',null);
            $receiptNumber = $eReceiptLastRecord==NULL?1:$eReceiptLastRecord->id+1;
            $expenseAccount = $this->getAccountGroups('6'); //get expense account titles
            foreach ($expenseAccount->accountTitles as $accountTitle) {
                foreach ($accountTitle->items as $item) {
                    $expenseAccountItems[] = $item;
                }
            }
            $vendorList = $this->getExpenseVendor(null);
            return view('expense.create_expense',
                            compact('receiptNumber',
                                    'expenseAccountItems',
                                    'vendorList',
                                    'type'));    
        }catch(\Exception $ex){
            //echo $ex->getMessage();
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
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
            $this->createSystemLogs('Added a New Cash Voucher');
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
        try{
            $eExpense = $this->getExpense($id);
            $eExpenseId = $id;
            return view('expense.show_expense',
                            compact('eExpense',
                                    'eExpenseId'));    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            //$receiptNumber = 1;
            $type = 'Expense';
            $expenseAccountItems = array();

            $eExpense = $this->getExpense($id);
            $vendorList = $this->getExpenseVendor($eExpense->vendor_id!=NULL?$eExpense->vendor_id:NULL);
            $eExpenseId = $id;
            $expenseAccount = $this->getAccountGroups('6'); //get expense account titles
            foreach ($expenseAccount->accountTitles as $accountTitle) {
                foreach ($accountTitle->items as $item) {
                    $expenseAccountItems[] = $item;
                }
            }
            return view('expense.edit_expense',
                            compact('eExpense',
                                    'eExpenseId',
                                    'expenseAccountItems',
                                    'vendorList',
                                    'type'));    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
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
        $userPasswordList = array();
        $match = false;
        $data = $request->input('data');
        $paidTo = $request->input('paidTo');
        $totalAmount = $request->input('totalAmount');
        $adminPassword = $request->input('adminPassword');
        $type = $request->input('type');
        $vendorId = $request->input('vendorId');
        $vendor = $this->getVendor($vendorId);
        $expenseAccountItems = array();
        

        try{
            $userAdminList = User::whereHas('userType',function($q) use ($adminPassword){
                                            $q->where('type','=','Administrator');
                                        })
                                        ->get();
            foreach ($userAdminList as $userAdmin) {
                if(Hash::check($adminPassword, $userAdmin->password) && $match===false){
                    $match = true;
                    break;
                }
            }
            if($match === true){
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
                $this->createSystemLogs('Updated an Existing Cash Voucher');
                flash()->success('Record successfully updated');
                return \Response::json(['status'=>'success']);
            }else{
                flash()->error('Invalid Admin Password.');
                return \Response::json(['status'=>'error']);
            }
        }catch(\Exception $ex){
            return \Response::json(['status'=>'error']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $adminPassword = $request->input('adminPassword');
        $match = false;
        $userAdminList = User::whereHas('userType',function($q) use ($adminPassword){
                                            $q->where('type','=','Administrator');
                                        })
                                        ->get();
        foreach ($userAdminList as $userAdmin) {
            if(Hash::check($adminPassword, $userAdmin->password)){
                $match = true;
                break;
            }
        }
        if($match){
            try{
                $this->deleteRecordWithWhere('expense_cash_voucher_items',array('expense_cash_voucher_id'=>$id));
                $this->deleteRecordWithWhere('journal_entry',array('expense_id'=>$id));
                $this->deleteRecordWithWhere('expense_cash_voucher',array('id'=>$id));
                $this->createSystemLogs('Deleted an Existing Cash Voucher');
                flash()->success('Record successfully deleted')->important();
            }catch(\Exception $ex){
                return view('errors.404');
            }
        }else{
            flash()->error('Invalid Admin Password')->important();
        }
    }
}
