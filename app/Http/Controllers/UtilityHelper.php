<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use Validator;
use App\User;
use App\UserTypeModel;
use App\HomeOwnerInformationModel;
use App\HomeOwnerMemberModel;
use App\ExpenseModel;
use App\InvoiceModel;
use App\ReceiptModel;
use App\AccountDetailModel;
use App\AccountGroupModel;
use App\AccountTitleModel;
use Illuminate\Http\Request;
use App\Http\Requests;
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
    * @Description: Get all records in the table with raw query
    */
    public function getObjectRecordsWithRawWhere($tableName,$rawWhereClause,$arrayValue){
        return DB::table($tableName)
                    ->whereRaw($rawWhereClause,$arrayValue)
                    ->get();
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

    /*
    * @Author:      Kristopher N. Veraces
    * @Description: Removing key,value pair in list
    */
    public function addAndremoveKey($arrayData,$isInsert){
        unset($arrayData['_method'],
                $arrayData['_token']);
        if($isInsert){
            $arrayData['created_at'] = date('Y-m-d');
        }
        $arrayData['updated_at'] = date('Y-m-d');
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
        $incomeAccountTitleGroupId = $this->getObjectFirstRecord('account_groups',array('account_group_name'=> $groupName));
        $tIncomeAccountTitlesList = $this->getObjectRecords('account_titles',array('account_group_id'=>$incomeAccountTitleGroupId->id));
        $tArrayStringList = explode(",",$data);
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
                $toInsertItems[] = array('account_title_id' => $eIncomeAccountTitlesList[trim($title)],
                                            'remarks' => $desc,
                                            'amount' => $amount,
                                            $foreignKeyId => $foreignValue,
                                            'created_at' => $eRecord->created_at,
                                            'updated_at'=>  date('Y-m-d'),
                                            'created_by' => $this->getLogInUserId(),
                                            'updated_by' => $this->getLogInUserId());
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
    public function createJournalEntry($dataList,$typeName,$foreignKey,$foreignValue,$description){
        $journalEntryList = array();
        $accountReceivableTitle = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Account Receivables'));
        $cashTitle = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Cash'));
        if($typeName=='Invoice' || $typeName=='Expense'){
             foreach ($dataList as $data) {
                $journalEntryList[] = array($foreignKey=>$foreignValue,
                                        'type' => $typeName,
                                        'debit_title_id'=> $typeName=='Expense'?$data['account_title_id']:$accountReceivableTitle->id,
                                        'credit_title_id'=> $typeName=='Expense'?$cashTitle->id:$data['account_title_id'],
                                        'description'=> $description,
                                        'created_at' => $data['created_at'],
                                        'updated_at' => date('Y-m-d'),
                                        'created_by' => $this->getLogInUserId(),
                                        'updated_by' => $this->getLogInUserId());
            }
        }else{
            $journalEntryList[] = array($foreignKey=>$foreignValue,
                                    'type' => $typeName,
                                    'debit_title_id'=>$cashTitle->id,
                                    'credit_title_id'=>$accountReceivableTitle->id,
                                    'description'=> $description,
                                    'created_at' => date('Y-m-d'),
                                    'updated_at' => date('Y-m-d'),
                                    'created_by' => $this->getLogInUserId(),
                                    'updated_by' => $this->getLogInUserId());
        }
       
        return $journalEntryList;
    }








}
