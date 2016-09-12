<?php

namespace App\Http\Controllers\receipt;

use App\InvoiceModel;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;
use App\Http\Requests\receipt\ReceiptRequest;

class ReceiptController extends Controller
{
    use UtilityHelper;

    /**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        $this->middleware('user.type:receipts');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $eHomeOwnerReceiptList = $this->getHomeOwnerReceipt(null);
            return view('receipt.receipt_list',
                            compact('eHomeOwnerReceiptList'));    
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
    public function create($id)
    {
        try{
            $homeOwnerInvoice = $this->getHomeOwnerInvoice($id);
            $invoiceNumber = $id;
            $receiptList = $this->getObjectLastRecord('home_owner_payment_transaction',null);
            $receiptNumber = $receiptList==NULL?1:$receiptList->id+1;
            return view('receipt.create_receipt',
                            compact('homeOwnerInvoice',
                                    'invoiceNumber',
                                    'receiptNumber'));    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
    }

    public function createPenaltyReceipt($id){
        try{
            $homeOwnerInvoice = InvoiceModel::where('home_owner_id','=',$id)
                                                ->where('is_penalty','=',1)
                                                ->first();
            $invoiceNumber = $id;
            $receiptList = $this->getObjectLastRecord('home_owner_payment_transaction',null);
            $receiptNumber = $receiptList==NULL?1:$receiptList->id+1;
            return view('receipt.create_receipt',
                            compact('homeOwnerInvoice',
                                    'invoiceNumber',
                                    'receiptNumber'));    
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
    public function store(ReceiptRequest $request)
    {
        try{
            $invoiceid = $request->input('payment_id');
            //Updates Invoice Record

            $this->updateRecord('home_owner_invoice',array('id'=>$invoiceid),array('is_paid' => 1));
            $eInvoice = $this->getObjectFirstRecord('home_owner_invoice',array('id'=>$invoiceid));
            $receiptId = $this->insertRecord('home_owner_payment_transaction',array('payment_id'=>$invoiceid,
                                                                                    'receipt_no'=>$request->input('receipt_no'),
                                                                                    'amount_paid'=>$request->input('amount_paid')));
            
            
            $toInsertData = array();
            //create journal entry
            $this->insertBulkRecord('journal_entry',$this->createJournalEntry($toInsertData,
                                                                                'Receipt',
                                                                                'receipt_id',
                                                                                $receiptId,
                                                                                'Created Receipt for invoice #'. $this->formatString($invoiceid),
                                                                                $eInvoice->total_amount));

            $this->createSystemLogs('Create a Receipt');
            flash()->success('Record successfully created');
            return redirect('receipt/'. $receiptId);    
        }catch(\Exception $ex){
            //echo $ex->getMessage();
            return view('errors.404'); 
            //echo $ex->getMessage();
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
            $receipt = $this->getHomeOwnerReceipt($id);
            $receiptNumber = $id;
            $invoiceNumber = $receipt->payment_id;
            return view('receipt.show_receipt',
                            compact('receipt',
                                    'receiptNumber',
                                    'invoiceNumber'));    
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
        
        //
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
        //
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
