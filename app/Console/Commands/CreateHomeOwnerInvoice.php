<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use App\Http\Controllers\UtilityHelper;

class CreateHomeOwnerInvoice extends Command
{
    use UtilityHelper;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:homeownerinvoice';

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
        try{
            $setting = $this->getSettings();
            if($setting->cut_off_date == date('d')){
                $invoiceToInsert = array();
                $invoiceItemsToInsert = array();
                $tJournalEntry = array();
                $toInsertJournalEntry = array();
                $homeOwnerList = $this->getHomeOwnerInformation(null);
                $assocDuesAccountTitle = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Association Dues'));
                $userAdmin = $this->getObjectFirstRecord('users',array('user_type_id'=>1));
                $invoiceModelList = $this->getControlNo('home_owner_invoice');
                $invoiceNumber = $invoiceModelList->AUTO_INCREMENT;
                foreach ($homeOwnerList as $homeOwner) {
                    $data = $assocDuesAccountTitle->account_sub_group_name.',For the month of '. date('F') .','.$assocDuesAccountTitle->default_value;
                    $invoiceToInsert[] = array('home_owner_id'=>$homeOwner->id,
                                                'total_amount'=>$assocDuesAccountTitle->default_value,
                                                'payment_due_date'=>date('Y-m-t'),
                                                'created_at'=>date('Y-m-d'),
                                                'updated_at'=>date('Y-m-d'),
                                                'created_by'=>$userAdmin->id,
                                                'updated_by'=>$userAdmin->id);
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
            DB::table('system_logs')->insert($this->createSystemLogs('Error in Inserting Invoice with error log: ' . $ex.getMessage(),$userAdmin));
            //\Log::info('Error in executing command' . $ex->getMessage() . 'Line Number ' . $ex->getLine());
        }
    }

    //Override function
    public function populateListOfToInsertItems($data,$groupName,$foreignKeyId,$foreignValue,$tableName){
        $count = 0;
        $toInsertItems;
        $eIncomeAccountTitlesList = array();
        $eRecord = $this->getObjectFirstRecord($tableName,array('id'=> $foreignValue));
        $incomeAccountTitleGroupId = $this->getObjectFirstRecord('account_groups',array('account_group_name'=> $groupName));
        $tIncomeAccountTitlesList = $this->getObjectRecords('account_titles',array('account_group_id'=>$incomeAccountTitleGroupId->id));
        $tArrayStringList = explode(",",$data);
        $userAdmin = $this->getObjectFirstRecord('users',array('user_type_id'=>1));
        foreach ($tIncomeAccountTitlesList as $tIncomeAccountTitle) {
            $eIncomeAccountTitlesList[$tIncomeAccountTitle->account_sub_group_name] = $tIncomeAccountTitle->id;
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
                $toInsertItems = array('account_title_id' => $eIncomeAccountTitlesList[trim($title)],
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
        $accountReceivableTitle = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Accounts Receivable'));
        $journalEntryList[] = $this->populateJournalEntry($foreignKey,$foreignValue,$typeName,
                                                            $accountReceivableTitle->id,null,$amount,
                                                            0.00,$description,$data['created_at'],
                                                            date('Y-m-d')); 

        $journalEntryList[] = $this->populateJournalEntry($foreignKey,$foreignValue,$typeName,
                                                            null,$data['account_title_id'],0.00,
                                                            $data['amount'],$description,$data['created_at'],
                                                            date('Y-m-d'));
        return $journalEntryList;
    }

    public function createSystemLogs($action,$user){
        return array('created_by'=>$user->id,
                        'updated_by'=>$user->id,
                        'action'=>$action,
                        'created_at' => date('Y-m-d H:i:sa'),
                        'updated_at' => date('Y-m-d H:i:sa'));
    }
}
