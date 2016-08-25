<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use Validator;
use App\User;
use App\VendorModel;
use App\AssetsModel;
use App\ExpenseModel;
use App\InvoiceModel;
use App\ReceiptModel;
use App\UserTypeModel;
use App\Http\Requests;
use App\SettingsModel;
use App\AnnouncementModel;
use App\AccountGroupModel;
use App\AccountTitleModel;
use App\JournalEntryModel;
use App\AccountDetailModel;
use Illuminate\Http\Request;
use App\InvoiceExpenseItems;
use App\HomeOwnerMemberModel;
use App\HomeOwnerInformationModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Serves as utility controller for 
 * the entire system
 * 
 */
trait UtilityHelper
{
    public function setUser(){
        return new User;
    }

    public function setUserType(){
        return new UserTypeModel;
    }

    public function setHomeOwnerInformation(){
        return new HomeOwnerInformationModel;
    }

    public function setHomeOwnerMemberInformation(){
        return new HomeOwnerMemberModel;
    }

    public function setAccountTitleModel(){
        return new AccountTitleModel;
    }

    public function setAssetModel(){
        return new AssetsModel;
    }

    public function setAnnouncementModel(){
        return new AnnouncementModel;
    }

    //Get List of Users/ A certain user
    public function getUser($id){
        return $id==null?User::all():User::findOrFail($id);
        
    }

    //Get List of User Types/ A certain user type
    public function getUserType($id){
        return $id==null?UserTypeModel::all():UserTypeModel::findOrFail($id);
        
    }

    //Get List of HomeOwners/ or certain HomeOwner
    public function getHomeOwnerInformation($id){
        return $id==null?HomeOwnerInformationModel::all():HomeOwnerInformationModel::findOrFail($id);   
    }

    //Get List of HomeOwnerInvoice/ or certain HomeOwnerInvoice
    public function getHomeOwnerInvoice($id){
        return $id==null?InvoiceModel::all():InvoiceModel::findOrFail($id);   
    }

    //Get List of HomeOwnerReceipt/ or certain HomeOwnerReceipt
    public function getHomeOwnerReceipt($id){
        return $id==null?ReceiptModel::all():ReceiptModel::findOrFail($id);   
    }

    //Get List of Expense/ or certain Expense
    public function getExpense($id){
        return $id==null?ExpenseModel::all():ExpenseModel::findOrFail($id);   
    }

    //Get List of Account Details/ or certain Account Details
    public function getAccountDetails($id){
        return $id==null?AccountDetailModel::all():AccountDetailModel::findOrFail($id);   
    }

    //Get List of Account Groups/ or certain Account Group
    public function getAccountGroups($id){
        return $id==null?AccountGroupModel::all():AccountGroupModel::findOrFail($id);   
    }

    public function getAccountTitles($id){
        return $id==null?AccountTitleModel::all():AccountTitleModel::findOrFail($id);   
    }

    //Get specific HomeOwnerMember
    public function getHomeOwnerMemberInformation($id){
        return HomeOwnerMemberModel::findOrFail($id);   
    }

    //Get List of Assets / or certain Asset
    public function getAssetModel($id){
        return $id==null?AssetsModel::all():AssetsModel::findOrFail($id);   
    }

    //Get List of Announcements / or certain Announcement
    public function getAnnouncementModel($id){
        return $id==null?AnnouncementModel::all():AnnouncementModel::findOrFail($id);
    }

    public function setVendor(){
        return new VendorModel;
    }

    public function getVendor($id){
        return $id==null?VendorModel::all():VendorModel::findOrFail($id);
    }

     public function setSettings(){
        return new SettingsModel;
    }

    public function getSettings(){
        return SettingsModel::first();
    }

    public function setItem(){
        return new InvoiceExpenseItems;
    }

    public function getItem($id){
        return $id==null?InvoiceExpenseItems::all():InvoiceExpenseItems::findOrFail($id);
    }

    public function getExpenseVendor($id){
        $eVendorList = array();
        if($id==null){
            $tVendorList = DB::table('vendors')
                            ->get();
            foreach($tVendorList as $tVendor){
                $eVendorList[$tVendor->id] = $tVendor->vendor_name;
            }
        }else{
            $tVendor = VendorModel::findOrFail($id);
            $eVendorList[$tVendor->id] = $tVendor->vendor_name;
            $tVendorList = DB::table('vendors')
                            ->where('id','!=',$id)
                            ->get();
            foreach($tVendorList as $tVendor){
                $eVendorList[$tVendor->id] = $tVendor->vendor_name;
            }
        }
        return $eVendorList;
    }



    //Get List of HomeOwnerMember
    public function getHomeOwnerMembers($id){
        $eHomeOwnerMembers = DB::table('home_owner_member_information')
                            ->where('home_owner_id','=',$id)
                            ->get();
        return $eHomeOwnerMembers;
    }

    //Get List of User Types/ or certain User Type for User
    public function getUsersUserType($id){
        $eUserTypesList = array();
        if($id==null){
            $tUserTypesList = DB::table('user_type')
                            ->get();
            foreach($tUserTypesList as $tUserType){
                $eUserTypesList[$tUserType->id] = $tUserType->type;
            }
        }else{
            $tUserType = UserTypeModel::findOrFail($id);
            $eUserTypesList[$tUserType->id] = $tUserType->type;
            $tUserTypesList = DB::table('user_type')
                            ->where('id','!=',$id)
                            ->get();
            foreach($tUserTypesList as $tUserType){
                $eUserTypesList[$tUserType->id] = $tUserType->type;
            }
        }
        return $eUserTypesList;
    }

    //Get List of User Types/ or certain User Type for User
    public function getAccountTitleGroup($id){
        $eAccountTitleGroupList = array();
        if($id==null){
            $tAccountTitleGroupList = DB::table('account_groups')->get();
            foreach($tAccountTitleGroupList as $tAccountTitleGroup){
                $eAccountTitleGroupList[$tAccountTitleGroup->id] = $tAccountTitleGroup->account_group_name;
            }
        }else{
            $tAccountTitle = AccountGroupModel::findOrFail($id);
            $eAccountTitleGroupList[$tAccountTitle->id] = $tAccountTitle->account_group_name;
            $tAccountTitlesList = DB::table('account_groups')
                                    ->where('id','!=',$id)
                                    ->get();
            foreach($tAccountTitlesList as $tAccountTitle){
                $eAccountTitleGroupList[$tAccountTitle->id] = $tAccountTitle->account_group_name;
            }
        }
        return $eAccountTitleGroupList;
    }

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Send Email to newly created user for email verification
    */
    public function sendEmailVerification($toAddress,$name,$confirmation_code){
        Mail::send('emails.user_verifier',$confirmation_code, function($message) use ($toAddress, $name){
            $message->from('SomersetAccountingSystem@noreply.com','User Verification');
            $message->to($toAddress, $name)
                        ->subject('Verify your Account');
        });

    }

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Get all records in the table
    */
    public function getObjectRecords($tableName,$whereClause){
        if(empty($whereClause)){
            return DB::table($tableName)
                    ->get();
        }else{
            return DB::table($tableName)
                    ->where($whereClause)
                    ->get();
        }
        
    }

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Get all records in the table using id
    */
    public function getObjectRecordsWithId($tableName,$field,$arrayValue){
        return DB::table($tableName)
                    ->whereIn($field,$arrayValue)
                    ->get();
    }

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Get first record in the table
    */
    public function getObjectFirstRecord($tableName,$whereClause){
        if(empty($whereClause)){
            return DB::table($tableName)
                        ->first();
        }else{
            return DB::table($tableName)
                        ->where($whereClause)
                        ->first();
        }
        
    }

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Get last record in the table
    */
    public function getObjectLastRecord($tableName,$whereClause){
        if(empty($whereClause)){
            return DB::table($tableName)
                        ->orderBy('id', 'desc')
                        ->first();
        }else{
            return DB::table($tableName)
                        ->where($whereClause)
                        ->orderBy('id', 'desc')
                        ->first();
        }
    }

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Use for Dynamic Insert in every table
    */
    public function insertRecord($tableName,$toInsertItems){
        $toInsertItems['created_at'] = date('Y-m-d');
        $toInsertItems['updated_at'] = date('Y-m-d');
        if($tableName != 'home_owner_information'){
            $toInsertItems['created_by'] = $this->getLogInUserId();
            $toInsertItems['updated_by'] = $this->getLogInUserId();
        }
        
        return DB::table($tableName)->insertGetId($toInsertItems);
    }

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Use for Bulk Insert in every table
    */
    public function insertBulkRecord($tableName,$toInsertItems){
        return DB::table($tableName)->insert($toInsertItems);
    }

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Use for Dynamic Update in every table
    */
    public function updateRecord($tableName,$idList,$toUpdateItems){
        $toUpdateItems['updated_at'] = date('Y-m-d');
        if($tableName != 'home_owner_information'){
            if(Auth::check()){
                $toUpdateItems['updated_by'] = $this->getLogInUserId();
            }
        }
        
        return DB::table($tableName)
                    ->where('id', $idList)
                    ->update($toUpdateItems);
    }

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Use for Dynamic Delete in every table
    */
    public function deleteRecord($tableName,$idList){
        return DB::table($tableName)
                    ->whereIn('id',$idList)
                    ->delete();
    }

    public function deleteRecordWithWhere($tableName,$whereClause){
        return DB::table($tableName)
                    ->where($whereClause)
                    ->delete();
    }

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Removing key,value pair in list
    */
    public function addAndremoveKey($arrayData,$isInsert){
        unset($arrayData['_method'],
                $arrayData['_token']);
        if($isInsert){
            $arrayData['created_at'] = date('Y-m-d H:i:sa');
        }
        $arrayData['updated_at'] = date('Y-m-d H:i:sa');
        return $arrayData;
    }

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: custom format string
    */
    public function formatString($stringToFormat){
        $appender = '';
        if(strlen($stringToFormat)<7){
            for ($i=0; $i < 7-(strlen($stringToFormat)); $i++) { 
                $appender .= '0';
            }
        }
        return $appender . $stringToFormat;
    }

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Get all items to insert
    */
    public function populateListOfToInsertItems($data,$groupName,$foreignKeyId,$foreignValue,$tableName){
        $count = 0;
        $toInsertItems = array();
        $eIncomeAccountTitlesList = array();
        $eRecord = $this->getObjectFirstRecord($tableName,array('id'=> $foreignValue));
        $incomeAccountTitleGroupId = AccountGroupModel::where('account_group_name','=',$groupName)->first();

        // $this->getObjectFirstRecord('account_groups',array('account_group_name'=> $groupName));
        // $tIncomeAccountTitlesList = $this->getObjectRecords('account_titles',array('account_group_id'=>$incomeAccountTitleGroupId->id));
        $tArrayStringList = explode(",",$data);
        $userAdmin = $this->getObjectFirstRecord('users',array('user_type_id'=>1));
        foreach ($incomeAccountTitleGroupId->accountTitles as $accountTitle) {
            foreach ($accountTitle->items as $item) {
                $eIncomeAccountTitlesList[$item->item_name] = $item->id;
            }
        }
        // foreach ($tIncomeAccountTitlesList as $tIncomeAccountTitle) {
        //     $eIncomeAccountTitlesList[$tIncomeAccountTitle->account_sub_group_name] = $tIncomeAccountTitle->id;
        // }

        foreach ($tArrayStringList as $tString) {
            ++$count;
            if($count==1){
                $title = $tString;
            }else if($count==2){
                $desc = $tString;
            }else if($count==3){
                $amount = $tString;
                $count = 0;
                $toInsertItems[] = array('item_id' => $eIncomeAccountTitlesList[trim($title)],
                                            'remarks' => $desc,
                                            'amount' => $amount,
                                            $foreignKeyId => $foreignValue,
                                            'created_at' => $eRecord!=NULL?$eRecord->created_at:date('Y-m-d'),
                                            'updated_at'=>  date('Y-m-d'),
                                            'created_by' => Auth::check()?$this->getLogInUserId():$userAdmin->id,
                                            'updated_by' => Auth::check()?$this->getLogInUserId():$userAdmin->id);
            }
        }
        return $toInsertItems;
    }

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Get id of login user
    */
    public function getLogInUserId(){
        return Auth::id();
    }


    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Create Journal Entry
    */
    public function createJournalEntry($dataList,$typeName,$foreignKey,$foreignValue,$description,$amount){
        $count = 0;
        $dataCreated;
        $journalEntryList = array();
        $itemList = array();
        $tDataHolder = array();
        $accountReceivableTitle = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Accounts Receivable'));
        $cashTitle = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Cash'));
        $eAccountGrp = $this->getAccountGroups($typeName=='Invoice'?'5':'6'); //get account titles
        foreach ($eAccountGrp->accountTitles as $accountTitle) {
            foreach ($accountTitle->items as $item) {
                $itemList[$item->id] = $accountTitle->id;
            }
        }
        if($typeName=='Invoice'){
            foreach ($dataList as $data) {
                if($count==0){
                    $journalEntryList[] = $this->populateJournalEntry($foreignKey,$foreignValue,$typeName,
                                                                        $accountReceivableTitle->id,null,$amount,
                                                                        0.00,$description,$data['created_at'],
                                                                        date('Y-m-d')); 
                    $dataCreated = $data['created_at'];

                }

                if(!(array_key_exists($itemList[$data['item_id']], $tDataHolder)))
                    $tDataHolder[$itemList[$data['item_id']]] = 0;
                $tDataHolder[$itemList[$data['item_id']]] += $data['amount'];
                $count++;
            }
            foreach ($tDataHolder as $key => $value) {
                $journalEntryList[] = $this->populateJournalEntry($foreignKey,$foreignValue,$typeName,
                                            null,$key,0.00,
                                            $value,$description,$dataCreated,
                                            date('Y-m-d'));
            }

        }else if($typeName=='Expense'){
            foreach ($dataList as $data) {
                $dataCreated = $data['created_at'];
                if(!(array_key_exists($itemList[$data['item_id']], $tDataHolder)))
                    $tDataHolder[$itemList[$data['item_id']]] = 0;
                $tDataHolder[$itemList[$data['item_id']]] += $data['amount'];
            }
            foreach ($tDataHolder as $key => $value) {
                $journalEntryList[] = $this->populateJournalEntry($foreignKey,$foreignValue,$typeName,
                                            $key,null,$value,
                                            0.00,$description,$dataCreated,
                                            date('Y-m-d'));
            }
            $journalEntryList[] = $this->populateJournalEntry($foreignKey,$foreignValue,$typeName,
                                            null,$cashTitle->id,0.00,
                                            $amount,$description,$dataCreated,
                                            date('Y-m-d'));
        }else{
            //for debit in journal
            $journalEntryList[] = $this->populateJournalEntry($foreignKey,$foreignValue,$typeName,
                                            $cashTitle->id,null,$amount,
                                            0.00,$description,date('Y-m-d'),
                                            date('Y-m-d'));
            //for credit in journal
            $journalEntryList[] = $this->populateJournalEntry($foreignKey,$foreignValue,$typeName,
                                            null,$accountReceivableTitle->id,0.00,
                                            $amount,$description,date('Y-m-d'),
                                            date('Y-m-d'));
        }
       
        return $journalEntryList;
    }

    public function populateJournalEntry($foreignKey,$foreignVal,$typeValue,
                                            $debitTitleIdValue,$creditTitleIdValue,$debitAmountValue,
                                            $creditAmountValue,$descriptionValue,$createdAtValue,
                                            $updatedAtValue){
        $userAdmin = $this->getObjectFirstRecord('users',array('user_type_id'=>1));
        if($foreignKey!=NULL){
            return array($foreignKey=>$foreignVal,
                        'type' => $typeValue,
                        'debit_title_id'=>$debitTitleIdValue,
                        'credit_title_id'=>$creditTitleIdValue,
                        'debit_amount' => $debitAmountValue,
                        'credit_amount'=> $creditAmountValue,
                        'description'=> $descriptionValue,
                        'created_at' => $createdAtValue,
                        'updated_at' => $updatedAtValue,
                        'created_by' => Auth::check()?$this->getLogInUserId():$userAdmin->id,
                        'updated_by' => Auth::check()?$this->getLogInUserId():$userAdmin->id);
        }else{
            return array('type' => $typeValue,
                        'debit_title_id'=>$debitTitleIdValue,
                        'credit_title_id'=>$creditTitleIdValue,
                        'debit_amount' => $debitAmountValue,
                        'credit_amount'=> $creditAmountValue,
                        'description'=> $descriptionValue,
                        'created_at' => $createdAtValue,
                        'updated_at' => $updatedAtValue,
                        'created_by' => Auth::check()?$this->getLogInUserId():$userAdmin->id,
                        'updated_by' => Auth::check()?$this->getLogInUserId():$userAdmin->id);
        }
        
    }


    public function monthsGenerator(){
        $monthArray = array('1'=>'January',
                            '2'=>'February',
                            '3'=>'March',
                            '4'=>'April',
                            '5'=>'May',
                            '6'=>'June',
                            '7'=>'July',
                            '8'=>'August',
                            '9'=>'September',
                            '10'=>'October',
                            '11'=>'November',
                            '12'=>'December');
        return $monthArray;
    }
    
    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Get all records in the journal table
    */
    public function getJournalEntryRecordsWithFilter($accountGroupId,$monthFilter,$yearFilter){
        $yearFilter = $yearFilter==NULL?date('Y'):date($yearFilter);
        $query = null;
        if(!is_null($accountGroupId)){
            $query = JournalEntryModel::orWhere(function($query) use ($accountGroupId){
                                                    $query->whereHas('credit',function($q) use ($accountGroupId){
                                                        $q->where('account_group_id', '=', $accountGroupId);
                                                    })
                                                    ->orWhereHas('debit',function($q) use ($accountGroupId){
                                                        $q->where('account_group_id', '=', $accountGroupId);
                                                    });
                                                });
        }

        if(empty($monthFilter)){
            $query  = $query==NULL? JournalEntryModel::whereYear('created_at','=',$yearFilter) : 
                            $query->whereYear('created_at','=',$yearFilter);
        }else{
            $monthFilter = $monthFilter==NULL?date('m'):date($monthFilter); 
            $query  = $query==NULL? JournalEntryModel::whereYear('created_at','=',$yearFilter)
                                                        ->whereMonth('created_at','=',$monthFilter) : 
                                                            $query->whereYear('created_at','=',$yearFilter)
                                                                    ->whereMonth('created_at','=',$monthFilter);
        }
        return $query->get();
              
    }



    public function getItemsAmountList($arrayToProcessList,$typeOfData){
        $data = array();
        if($typeOfData == 'Equity'){
            $accountGroup =  AccountGroupModel::where('account_group_name', 'like', '%'.$typeOfData.'%')
                                                ->get();
            foreach ($accountGroup as $accountGrp) {
                foreach ($accountGrp->accountTitles as $accountTitle) {
                    $data[$accountTitle->account_sub_group_name] = $accountTitle->opening_balance;
                }
            }
        }else if(is_null($typeOfData)){
            $accountGroup =  $this->getAccountGroups(null);
            foreach ($accountGroup as $accountGrp) {
                foreach ($accountGrp->accountTitles as $accountTitle) {
                    $data[$accountTitle->account_sub_group_name] = $accountTitle->opening_balance;
                }
            }
        }

        if(!empty($arrayToProcessList)){
            foreach ($arrayToProcessList as $arrayToProcess) {
                $typeOfData = $arrayToProcess->credit_title_id == NULL ? $arrayToProcess->debit->group->account_group_name : $arrayToProcess->credit->group->account_group_name;
                $amount = ($arrayToProcess->debit_amount - $arrayToProcess->credit_amount);
                $accountTitle = $arrayToProcess->credit_title_id == NULL ? $arrayToProcess->debit->account_sub_group_name : $arrayToProcess->credit->account_sub_group_name;

                if(array_key_exists($accountTitle,$data)){
                    $data[$accountTitle] += (strpos($typeOfData, 'Revenues') !== false || strpos($typeOfData, 'Equity') | strpos($typeOfData, 'Liabilities') ? 
                                                ($amount * -1)  : $amount);
                }else{
                    $data[$accountTitle] = $typeOfData == 'Revenues' ? ($amount * -1)  : $amount;
                }
            }
        }
        return $data;
    }

    public function getTotalSum($arrayData){
        return count($arrayData)>0?array_sum($arrayData):0;
    }



    public function assetJournalEntry($debitTitleId,$creditTitleId,$description,$asset,$data,$isInsert){
        //Create Journal Entry
        //Debit Entry
        $journalEntryList[] = array('debit_title_id'=>$debitTitleId,
                                    'asset_id' => $isInsert?$asset:$asset->id,
                                    'credit_title_id'=>null,
                                    'debit_amount' => $data['total_cost'],
                                    'type' => 'asset',
                                    'credit_amount'=>0.00,
                                    'description'=> $description,
                                    'created_at' => $isInsert?date('Y-m-d H:i:sa'):$asset->created_at,
                                    'updated_at' => date('Y-m-d H:i:sa'),
                                    'created_by' => $this->getLogInUserId(),
                                    'updated_by' => $this->getLogInUserId());
        //Credit Entry
        for ($i=0; $i < count($creditTitleId) ; $i++) { 
            $amount = $data['total_cost'];
            if($data['mode_of_acquisition'] == 'Both'){
                if($creditTitleId[$i]->account_sub_group_name == 'Cash')
                    $amount = $data['down_payment'];
                else if($creditTitleId[$i]->account_sub_group_name == 'Accounts Payable'){
                        $amount = ($data['total_cost'] - $data['down_payment']);
                }
            }
            
            $journalEntryList[] = array('debit_title_id'=>null,
                                        'asset_id' => $isInsert?$asset:$asset->id,
                                        'credit_title_id'=>$creditTitleId[$i]->id,
                                        'debit_amount' => 0.00,
                                        'credit_amount'=>$amount,
                                        'type' => 'asset',
                                        'description'=> $description,
                                        'created_at' => $isInsert?date('Y-m-d H:i:sa'):$asset->created_at,
                                        'updated_at' => date('Y-m-d H:i:sa'),
                                        'created_by' => $this->getLogInUserId(),
                                        'updated_by' => $this->getLogInUserId());
        }

        $this->insertBulkRecord('journal_entry',$journalEntryList);
    }

    public function getControlNo($tableName){
        return DB::table('INFORMATION_SCHEMA.TABLES')  
                        ->where('TABLE_SCHEMA','=','somersetplaceaccountingsystem')
                        ->where('TABLE_NAME','=',$tableName)
                        ->first();
    }

    public function createSystemLogs($action){
        $this->insertRecord('system_logs',array('created_by'=>$this->getLogInUserId(),
                                            'updated_by'=>$this->getLogInUserId(),
                                            'action'=>$action,
                                            'created_at' => date('Y-m-d H:i:sa'),
                                            'updated_at' => date('Y-m-d H:i:sa')));
    }

}           