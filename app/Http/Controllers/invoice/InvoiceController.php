<?php

namespace App\Http\Controllers\invoice;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;
use App\AccountGroupModel;

class InvoiceController extends Controller
{
    use UtilityHelper;

    /**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        if(Auth::user()->userType->type==='Guest')
            $this->middleware('user.type:invoice',['except'=>['index']]);
        else
            $this->middleware('user.type:invoice');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $eInvoiceModelList = $this->getHomeOwnerInvoice(null);
            if(Auth::user()->userType->type==='Guest'){
                //return view('errors.404'); 
            echo $ex->getMessage();
            }else{
                return view('invoices.invoices_list',
                            compact('eInvoiceModelList'));
            }    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
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
            if(Auth::user()->userType->type==='Guest'){
                //return view('errors.404'); 
            echo $ex->getMessage();
            }else{
                $type = 'Invoice';
                $incomeAccountItems = array();
                $homeOwnerMembersList = $this->getHomeOwnerInformation(null);
                $incomeAccount = $this->getAccountGroups('5'); //get income account titles
                foreach ($incomeAccount->accountTitles as $accountTitle) {
                    foreach ($accountTitle->items as $item) {
                        $incomeAccountItems[] = $item;
                    }
                }
                $invoiceModelList = $this->getControlNo('home_owner_invoice');
                $invoiceNumber = $invoiceModelList->AUTO_INCREMENT;
                return view('invoices.create_invoices',
                                compact('homeOwnerMembersList',
                                        'invoiceNumber',
                                        'incomeAccountItems',
                                        'type'));
            }    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
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
        //Start of getting data from ajax request
        $data = $request->input('data');
        $totalAmount = $request->input('totalAmount');
        $paymentDueDate = $request->input('paymentDueDate');
        $homeownerid = $request->input('homeownerid');
        $homeowner = $this->getObjectFirstRecord('home_owner_information',array('id'=>$homeownerid));
        $settings = $this->getSettings();
        //$accountDetailId = $request->input('accountDetailId');
        //End of getting data from ajax request
        //echo $data; 
        try{
            //Insert Invoice in Database
            $nInvoiceId = $this->insertRecord('home_owner_invoice',array('home_owner_id' => $homeownerid,
                                                                            'total_amount' => $totalAmount,
                                                                            'payment_due_date' => date('Y-m-d',strtotime($paymentDueDate)),
                                                                            'next_penalty_date'=>date('Y-m-d',strtotime($paymentDueDate . '+'. $settings->days_till_due_date .' days'))));

            $dataToInsert = $this->populateListOfToInsertItems($data,'Revenues','invoice_id',$nInvoiceId,'home_owner_invoice');
            //Insert items in the table
            $this->insertBulkRecord('home_owner_invoice_items',$dataToInsert);
            //Create journal entry
            
            $this->insertBulkRecord('journal_entry',$this->createJournalEntry($dataToInsert,
                                                                                'Invoice',
                                                                                'invoice_id',
                                                                                $nInvoiceId,
                                                                                'Created invoice for homeowner ' .
                                                                                $homeowner->first_name . ' ' . $homeowner->middle_name . ' ' . $homeowner->last_name,
                                                                                $totalAmount));
            $this->createSystemLogs('Created a New Invoice');
            flash()->success('Record successfully created');

            echo $nInvoiceId;    
        }catch(\Exception $ex){
            echo $ex->getMessage();
            ////return view('errors.404'); 
            echo $ex->getMessage();
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
            $hasPenalty = false;
            $invoice = $this->getHomeOwnerInvoice($id);
            $invoiceNumber = $id;
            foreach ($invoice->invoiceItems as $invItem) {
                if($invItem->item->item_name === 'Penalty' || strrpos($invItem->item->item_name, 'Penalty')){
                    $hasPenalty = true;
                    break;
                }
            }

            if(Auth::user()->userType->type==='Guest'){
                return view('guest_show_invoice.show_guest_invoice',
                            compact('invoice',
                                    'invoiceNumber'));
            }else{
                return view('invoices.show_invoice',
                            compact('invoice',
                                    'invoiceNumber',
                                    'hasPenalty'));
            }    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
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
            if(Auth::user()->userType->type==='Guest'){
                //return view('errors.404'); 
            echo $ex->getMessage();
            }else{
                $type = 'Invoice';
                $eInvoice = $this->getHomeOwnerInvoice($id);
                $invoiceNumber = $id;
                $incomeAccount = $this->getAccountGroups('5'); //get income account titles
                foreach ($incomeAccount->accountTitles as $accountTitle) {
                    foreach ($accountTitle->items as $item) {
                        $incomeAccountItems[] = $item;
                    }
                }
                if($eInvoice->is_paid){
                    //return view('errors.404'); 
            echo $ex->getMessage();
                }else{
                    return view('invoices.edit_invoice',
                                compact('eInvoice',
                                        'invoiceNumber',
                                        'incomeAccountItems',
                                        'type'));
                }
            }    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
        
        
        
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
        //Start of getting data from ajax request
        $data = $request->input('data');
        $totalAmount = $request->input('totalAmount');
        $paymentDueDate = $request->input('paymentDueDate');
        //End of getting data from ajax request
        $settings = $this->getSettings();
        //Replace all items in the database
        try{
            $eInvoice = $this->getHomeOwnerInvoice($id);
            $homeowner = $this->getObjectFirstRecord('home_owner_information',array('id'=>$eInvoice->home_owner_id));
            $this->updateRecord('home_owner_invoice',$id,array('total_amount' => $totalAmount,
                                                                'payment_due_date' => date('Y-m-d',strtotime($paymentDueDate)),
                                                                'next_penalty_date'=>date('Y-m-d',strtotime($paymentDueDate . '+'. $settings->days_till_due_date .' days'))));
            $this->deleteRecordWithWhere('home_owner_invoice_items',array('invoice_id'=>$id));
            $this->deleteRecordWithWhere('journal_entry',array('invoice_id'=>$id));

            $dataToInsert = $this->populateListOfToInsertItems($data,'Revenues','invoice_id',$id,'home_owner_invoice');
            $this->insertBulkRecord('home_owner_invoice_items',$dataToInsert);
            
            //Create journal entry
            $this->insertBulkRecord('journal_entry',$this->createJournalEntry($dataToInsert,
                                                                                'Invoice',
                                                                                'invoice_id',
                                                                                $id,
                                                                                'Created invoice for homeowner ' .
                                                                                $homeowner->first_name . ' ' . $homeowner->middle_name . ' ' . $homeowner->last_name,
                                                                                $totalAmount));
            $this->createSystemLogs('Updated an Existing Invoice');
            flash()->success('Record successfully updated');
            echo $id;    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
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
        // $toDeleteInvItems = array();
        // $toDeleteJournalEntry = array();
        // $eInvoice = $this->getHomeOwnerInvoice($id);
        // $eInvoiceItemsList = $this->getObjectRecords('home_owner_invoice_items',array('invoice_id'=>$id));
        // $eInvoiceJournalEntries = $this->getObjectRecords('journal_entry',array('invoice_id'=>$id));
        // foreach ($eInvoiceItemsList as $eInvoiceItem) {
        //     $toDeleteInvItems[] = $eInvoiceItem->id;
        // }

        // foreach ($eInvoiceJournalEntries as $eInvoiceJournalEntry) {
        //     $toDeleteJournalEntry[] = $eInvoiceJournalEntry->id;
        // }
        
        // $this->deleteRecord('home_owner_invoice_items',$toDeleteInvItems);
        // $this->deleteRecord('journal_entry',$toDeleteJournalEntry);
        // $this->deleteRecord('home_owner_invoice',array($id));
        try{
            if(Auth::user()->userType->type==='Guest'){
                //return view('errors.404'); 
            echo $ex->getMessage();
            }else{
                $this->deleteRecordWithWhere('home_owner_invoice_items',array('invoice_id'=>$id));
                $this->deleteRecordWithWhere('journal_entry',array('invoice_id'=>$id));
                $this->deleteRecordWithWhere('home_owner_invoice_items',array('id'=>$id));
                $this->createSystemLogs('Deleted an Existing Invoice');
                flash()->success('Record successfully deleted')->important();
                return redirect('invoice');
            }    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
        
        
    }
}
