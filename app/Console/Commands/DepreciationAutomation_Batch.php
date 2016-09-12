<?php

namespace App\Console\Commands;

use DB;
use Auth;
use App\AssetsModel;
use Illuminate\Console\Command;
use App\Http\Controllers\UtilityHelper;

class DepreciationAutomation_Batch extends Command
{
    use UtilityHelper;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compute:depreciate {--run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Computes Fixed Assets Depreciation per Month';

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
    public function handle(){
        $tJournalEntry = array();
        $toInsertJournalEntry = array();
        $updateIds = array();
        $toUpdateAssets = array();
        $command = $this->option('run');
        try{
            if($command=='1'){
                $eAssetItemsList = AssetsModel::where('created_at','<=',date('Y-m-d'))
                                                ->where('useful_life','>',0)
                                                ->get();
            }else{
                $eAssetItemsList = AssetsModel::where('next_depreciation_date','=',date('Y-m-d'))
                                                ->where('useful_life','>',0)
                                                ->get();
            }
            $userAdmin = $this->getObjectFirstRecord('users',array('user_type_id'=>1));
            if(!empty($eAssetItemsList)){
                foreach ($eAssetItemsList as $eAssetItem) {
                    $description = 'Depreciation of ' . $eAssetItem->item_name . ' for the month of ' . date('F');
                    $eAssetItem->next_depreciation_date = date('Y-m-d',strtotime($eAssetItem->next_depreciation_date . '+1 month'));
                    $eAssetItem->useful_life = ($eAssetItem->useful_life-1);
                    $eAssetItem->net_value = str_replace(",","", number_format($eAssetItem->net_value-$eAssetItem->monthly_depreciation,2));
                    $eAssetItem->accumulated_depreciation = str_replace(",","", number_format($eAssetItem->accumulated_depreciation+$eAssetItem->monthly_depreciation,2)) ;
                    $eAssetItem->updated_at = date('Y-m-d');
                    $eAssetItem->save(); //Think of a better way
                    $tJournalEntry[] = $this->createJournalEntry($eAssetItem->accountTitle,'Asset','asset_id',$eAssetItem->id,$description,$eAssetItem->monthly_depreciation);
                }
                //debit depreciation expense
                //credit accumulated depreciation
                if(!empty($tJournalEntry)){
                    foreach ($tJournalEntry as $key => $value) {
                        foreach ($value as $key => $val) {
                            $toInsertJournalEntry[] = $val;
                        }
                    }
                    $this->insertBulkRecord('journal_entry',$toInsertJournalEntry);
                }

                //DB::table('asset_items')->whereIn('id',$updateIds)->update($toUpdateAssets);
                //AssetModel::where('next_depreciation_date','=',date('Y-m-d',strtotime('+1 Month')));
                DB::table('system_logs')->insert($this->createSystemLogs('Done Depreciating of Assets',$userAdmin));
                //\Log::info('Success');
            }

            
            
        }catch(\Exception $ex){
            DB::table('system_logs')->insert($this->createSystemLogs('Error in Updating Assets with error log: ' . $ex->getMessage() . 'in line number ' . $ex->getLine(),$userAdmin));
        }    
    }

    public function createJournalEntry($accountTitleName,$typeName,$foreignKey,$foreignValue,$description,$amount){
        $journalEntryList = array();
        $accountDepExp = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Depreciation Expense'));
        if(is_null($accountDepExp)){
            $this->insertRecord('account_titles',
                                    $this->createAccountTitle('6','Depreciation Expense',null));
            $accountDepExp = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Depreciation Expense'));
        }
        $accountAccExp = DB::table('account_titles')
                                ->where('account_title_id','=',$accountTitleName->id)
                                ->where('account_sub_group_name','LIKE','%'.$accountTitleName->account_sub_group_name.'%')
                                ->first();

        if(is_null($accountAccExp)){
            $this->insertRecord('account_titles',
                                    $this->createAccountTitle('2','Accumulated Depreciation - '. $accountTitleName->account_sub_group_name,$accountTitleName->id));
            $accountAccExp = DB::table('account_titles')
                                ->where('account_title_id','=',$accountTitleName->id)
                                ->where('account_sub_group_name','LIKE','%'.$accountTitleName->account_sub_group_name.'%')
                                ->first();
        }

        if(!(is_null($accountDepExp )) && !(is_null($accountAccExp))){
            $journalEntryList[] = $this->populateJournalEntry($foreignKey,$foreignValue,$typeName,
                                                            $accountDepExp->id,null,$amount,
                                                            0.00,$description,date('Y-m-d'),
                                                            date('Y-m-d')); 

            $journalEntryList[] = $this->populateJournalEntry($foreignKey,$foreignValue,$typeName,
                                                                null,$accountAccExp->id,0.00,
                                                                $amount,$description,date('Y-m-d'),
                                                                date('Y-m-d'));
        }
        
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
