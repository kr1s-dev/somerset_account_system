<?php

namespace App\Console\Commands;

use DB;
use Auth;
use App\AccountGroupModel;
use Illuminate\Console\Command;
use App\Http\Controllers\UtilityHelper;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateHomeOwnerInvoice extends Command
{
    use UtilityHelper;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:homeownerinvoice {--run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a HomeOwner Invoice - Association Dues';

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
        $command = $this->option('run');
        $userAdmin = $this->getObjectFirstRecord('users',array('user_type_id'=>1));
        //\Log::info($command);
        try{
            //\Log::info(date('d'));
            $setting = $this->getSettings();
            if((!(is_null($setting)) &&$setting->cut_off_date == date('d'))|| ($command=='1')){
                //\Log::info('By Passed');
                $invoiceToInsert = array();
                $invoiceItemsToInsert = array();
                $tJournalEntry = array();
                $toInsertJournalEntry = array();
                $homeOwnerList = $this->getHomeOwnerInformation(null);
                $assocDuesAccountTitle = $this->getObjectFirstRecord('invoice_expense_items',array('item_name'=>'Association Dues'));
                
                $invoiceModelList = $this->getObjectLastRecord('home_owner_invoice',null);
                $invoiceNumber = $invoiceModelList==NULL?1:$invoiceModelList->id+1;
                foreach ($homeOwnerList as $homeOwner) {
                    $data = $assocDuesAccountTitle->item_name.',For the month of '. date('F') .','.$assocDuesAccountTitle->default_value;
                    $invoiceToInsert[] = array('home_owner_id'=>$homeOwner->id,
                                                'total_amount'=>$assocDuesAccountTitle->default_value,
                                                'payment_due_date'=>date('Y-m-t'),
                                                'created_at'=>date('Y-m-d'),
                                                'updated_at'=>date('Y-m-d'),
                                                'created_by'=>$userAdmin->id,
                                                'updated_by'=>$userAdmin->id,
                                                'next_penalty_date'=>date('Y-m-t',strtotime('+1 month')));
                    $invoiceItemsToInsert[] = $this->populateListOfToInsertItems($data,'Revenues','invoice_id',$invoiceNumber,'home_owner_invoice');
                    $tJournalEntry[] = $this->createJournalEntry($this->populateListOfToInsertItems($data,'Revenues','invoice_id',$invoiceNumber,'home_owner_invoice'),
                                                                    'Invoice',
                                                                    'invoice_id',
                                                                    $invoiceNumber,
                                                                    'Created invoice for homeowner ' .
                                                                    $homeOwner->first_name . ' ' . $homeOwner->middle_name . ' ' . $homeOwner->last_name,
                                                                    $assocDuesAccountTitle->default_value);
                    $invoiceNumber+=1;
                    
                }
                $this->insertBulkRecord('home_owner_invoice',$invoiceToInsert);
                $this->insertBulkRecord('home_owner_invoice_items',$invoiceItemsToInsert);
                foreach ($tJournalEntry as $key => $value) {
                    foreach ($value as $key => $val) {
                        $toInsertJournalEntry[] = $val;
                    }
                }
                $this->insertBulkRecord('journal_entry',$toInsertJournalEntry);
                DB::table('system_logs')->insert($this->createSystemLogs('Done Inserting Bulk Invoice for HomeOwners',$userAdmin));
                // \Log::info('Success');
            }
        }catch(\Exception $ex){
            DB::table('system_logs')->insert($this->createSystemLogs('Error in Inserting Invoice with error log: ' . $ex->getMessage() . ' in line number ' . $ex->getLine() ,$userAdmin));
            //\Log::info('Error in executing command' . $ex->getMessage() . 'Line Number ' . $ex->getLine());
        }
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
