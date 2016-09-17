<?php

namespace App\Console\Commands;

use DB;
use Auth;
use App\InvoiceModel;
use App\AccountGroupModel;
use App\InvoiceExpenseItems;
use Illuminate\Console\Command;
use App\Http\Controllers\UtilityHelper;

class CreatePenaltyInvoice_Batch extends Command
{
    use UtilityHelper;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:penalty {--run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This creates a penalty invoie for homeowners';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userAdmin = $this->getObjectFirstRecord('users',array('user_type_id'=>1));
        try{
            $command = $this->option('run');
            $toInsertPenaltyInvoice = array();
            $invoiceItemsToInsert = array();
            $toUpdatePenaltyInvoice = array();
            $tJournalEntry = array();
            $toInsertJournalEntry = array();
            if($command=='1'){
                $invoiceList = InvoiceModel::where('created_at','<=',date('Y-m-d'))
                                                ->where('is_paid','=',0)
                                                ->get();
            }else{
                $invoiceList = InvoiceModel::where('next_penalty_date','=', date('Y-m-d'))->where('is_paid','=',0)->get();
            }
            $penaltyItem = InvoiceExpenseItems::where('item_name','LIKE','%Penalty%')->first();
            
            $invoiceModelList = $this->getObjectLastRecord('home_owner_invoice',null);
            $invoiceNumber = $invoiceModelList==NULL?1:$invoiceModelList->id+1;
            if(!(is_null($penaltyItem)) && $penaltyItem->default_value > 0){
                foreach ($invoiceList as $inv) {
                    if($inv->is_penalty == 0){
                        $data = $penaltyItem->item_name.',For the month of '. date('F') .','.$penaltyItem->default_value;
                        if(is_null($inv->penaltyInfo)){
                            //\Log::Info('Has an Existing Penalty');
                            $toInsertPenaltyInvoice[] = $this->createPenaltyInvoice($inv,$userAdmin->id,$penaltyItem);
                            $invoiceItemsToInsert[] = $this->populateListOfToInsertItems($data,'Revenues','invoice_id',$invoiceNumber,'home_owner_invoice');
                            $tJournalEntry[] = $this->createJournalEntry($this->populateListOfToInsertItems($data,'Revenues','invoice_id',$invoiceNumber,'home_owner_invoice'),
                                                                        'Invoice',
                                                                        'invoice_id',
                                                                        $invoiceNumber,
                                                                        'Created Penalty for Invoice ' . $inv->id,
                                                                        $penaltyItem->default_value);
                            $invoiceNumber+=1;
                        }else{
                            //\Log::Info('Has an Existing Penalty');
                            $max = $penaltyItem->default_value*5;
                            $addedAmount = $inv->penaltyInfo->total_amount<$max ? 
                                                                $penaltyItem->default_value : number_format($inv->total_amount * .2,2);
                            $inv->penaltyInfo->total_amount += $addedAmount;
                            $inv->penaltyInfo->payment_due_date = date('Y-m-d',strtotime($inv->penaltyInfo->payment_due_date . ' +1 month'));
                            foreach ($inv->penaltyInfo->invoiceItems as $invItems) {
                                $invItems->amount += $addedAmount;
                                $invItems->save();
                            }
                            $data = $penaltyItem->item_name.',For the month of '. date('F') .','.$addedAmount;
                            $tJournalEntry[] = $this->createJournalEntry($this->populateListOfToInsertItems($data,'Revenues','invoice_id',$invoiceNumber,'home_owner_invoice'),
                                                                        'Invoice',
                                                                        'invoice_id',
                                                                        $inv->id,
                                                                        'Created Added Penalty for Invoice ' . $inv->id,
                                                                        $addedAmount);
                            $inv->penaltyInfo->save();
                        }
                        $inv->next_penalty_date = date('Y-m-d',strtotime($inv->next_penalty_date . ' +1 month'));
                        $inv->save();
                        $inv->homeOwner->has_penalty = 1;
                        $inv->homeOwner->save();
                    }
                    
                }
            }

            foreach ($tJournalEntry as $key => $value) {
                foreach ($value as $key => $val) {
                    $toInsertJournalEntry[] = $val;
                }
            }

            //\Log::Info($toInsertPenaltyInvoice);
            if(count($toInsertPenaltyInvoice)>0){
                $this->insertBulkRecord('home_owner_invoice',$toInsertPenaltyInvoice);
            }
            //\Log::Info($invoiceItemsToInsert);
            if(count($invoiceItemsToInsert)>0){
                $this->insertBulkRecord('home_owner_invoice_items',$invoiceItemsToInsert);
            }

            $this->insertBulkRecord('journal_entry',$toInsertJournalEntry);
            DB::table('system_logs')->insert($this->createSystemLogs('Done Inserting Penalty Invoice for HomeOwners',$userAdmin));

            //\Log::Info('Success');
            
        }catch(\Exception $ex){
            DB::table('system_logs')->insert($this->createSystemLogs('Error in creating Penalty ' . $ex->getMessage(),$userAdmin));
            //\Log::Info($ex->getMessage());
        }
    }

    public function createPenaltyInvoice($invoice,$adminId,$item){
        return array('home_owner_id'=>$invoice->home_owner_id,
                        'created_by'=>$adminId,
                        'updated_by'=>$adminId,
                        'invoice_id'=>$invoice->id,
                        'total_amount'=>$item->default_value,
                        'payment_due_date'=>date('Y-m-d',strtotime('+30 days')),
                        'next_penalty_date'=>date('Y-m-d',strtotime('+30 days')),
                        'created_at'=>date('Y-m-d'),
                        'updated_at'=>date('Y-m-d'),
                        'is_penalty'=>1);
    }

    //Override function
    public function populateListOfToInsertItems($data,$groupName,$foreignKeyId,$foreignValue,$tableName){
        $count = 0;
        $toInsertItems;
        $eIncomeAccountTitlesList = array();
        $eRecord = $this->getObjectFirstRecord($tableName,array('id'=> $foreignValue));
        $incomeAccountTitleGroupId = AccountGroupModel::where('account_group_name','=',$groupName)->first();
        // $tIncomeAccountTitlesList = $this->getObjectRecords('account_titles',array('account_group_id'=>$incomeAccountTitleGroupId->id));
        $tArrayStringList = explode(",",$data);
        $userAdmin = $this->getObjectFirstRecord('users',array('user_type_id'=>1));
        foreach ($incomeAccountTitleGroupId->accountTitles as $accountTitle) {
            foreach ($accountTitle->items as $item) {
                $eIncomeAccountTitlesList[$item->item_name] = $item->id;
            }
        }

        foreach ($tArrayStringList as $tString) {
            ++$count;
            if($count==1){
                $title = $tString;
            }else if($count==2){
                $desc = $tString;
            }else if($count==3){
                $amount = $tString;
                $count = 0;
                $toInsertItems = array('item_id' => $eIncomeAccountTitlesList[trim($title)],
                                        'remarks' => $desc,
                                        'amount' => $amount,
                                        $foreignKeyId => $foreignValue,
                                        'created_at' => $eRecord!=NULL?$eRecord->created_at:date('Y-m-d'),
                                        'updated_at'=>  date('Y-m-d'),
                                        'created_by' => $userAdmin->id,
                                        'updated_by' => $userAdmin->id);
            }
        }
        return $toInsertItems;
    }

    public function createJournalEntry($data,$typeName,$foreignKey,$foreignValue,$description,$amount){
        $journalEntryList = array();
        $itemList = array();
        $eAccountGrp = $this->getAccountGroups('5'); //get account titles
        foreach ($eAccountGrp->accountTitles as $accountTitle) {
            foreach ($accountTitle->items as $item) {
                $itemList[$item->id] = $accountTitle->id;
            }
        }
        $accountReceivableTitle = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Accounts Receivable'));
        $journalEntryList[] = $this->populateJournalEntry($foreignKey,$foreignValue,$typeName,
                                                            $accountReceivableTitle->id,null,$amount,
                                                            0.00,$description,$data['created_at'],
                                                            date('Y-m-d')); 

        $journalEntryList[] = $this->populateJournalEntry($foreignKey,$foreignValue,$typeName,
                                                            null,$itemList[$data['item_id']],0.00,
                                                            $data['amount'],$description,$data['created_at'],
                                                            date('Y-m-d'));
        return $journalEntryList;
    }

    public function createSystemLogs($action,$user){
        return array('created_by'=>$user->id,
                        'updated_by'=>$user->id,
                        'action'=>$action,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'));
    }
}
