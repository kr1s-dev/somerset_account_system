<?php

namespace App\Http\Controllers\journal;


use App\Http\Requests;
use App\JournalEntryModel;
use App\AccountTitleModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;
class JournalEntryController extends Controller
{
    use UtilityHelper;

    /**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        $this->middleware('user.type:journal');
    }

    //Return a view page for journal Entry
    public function getJournalEntry(){
        try{
            $type = 'Journal Entry';
            $accountTitlesList = $this->getAccountTitles(null);
            return view('journal.journal_create',
                            compact('accountTitlesList',
                                    'type'));     
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
          
    }

    public function postJournalEntry(Request $request){
        //Getting ajax values
        $data = $request->input('data');
        $explanation = $request->input('explanation');
        $type= $request->input('type');
        //Getting ajax values
        
        try{
            $this->insertBulkRecord('journal_entry',$this->createJouralEntry($data,$explanation,$type));
            $this->createSystemLogs('Added a New Journal Entry');
        }catch(\Exception $ex){
            echo $ex->getMessage();
        }
        
        //print_r($this->createJouralEntry($data,$explanation,$type));
    }

    public function getAdjustmenstEntry(){
        try{
            $type = 'Adjustment Entry';
            $accountTitleId = array();
            $journalEntryList = JournalEntryModel::whereYear('created_at','=',date('Y'))->get();
            foreach ($journalEntryList as $journalEntry) {
                $id = $journalEntry->credit_title_id!=NULL?$journalEntry->credit_title_id:$journalEntry->debit_title_id;
                if(!(in_array($id, $accountTitleId)))
                    $accountTitleId[] = $id;
            }
            $accountTitlesList = AccountTitleModel::whereIn('id',$accountTitleId)->get();
            return view('journal.journal_create',
                            compact('accountTitlesList',
                                    'type'));    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        

    }

    public function createJouralEntry($data,$explanation,$type){
        $count = 0;
        $dataToInsertList = explode(',',$data);
        $toInsertItems = array();
        foreach($dataToInsertList as $dataToInsert){
            ++$count;
            if($count==1){
                $aType = $dataToInsert;
            }else if($count==2){
                $accountTitleId = $dataToInsert;
            }else if($count==3){
                $description = $dataToInsert;
            }else if($count==4){
                $amount = $dataToInsert;
                $count = 0;
                if($aType=='DR'){
                    $toInsertItems[] = $this->populateJournalEntry(null,null,$type,
                                                                    $accountTitleId,null,$amount,
                                                                    0.00,$description,date('Y-m-d'),
                                                                    date('Y-m-d'));
                }else if($aType=='CR'){
                    $toInsertItems[] = $this->populateJournalEntry(null,null,$type,
                                                                    null,$accountTitleId,0.00,
                                                                    $amount,$description,date('Y-m-d'),
                                                                    date('Y-m-d'));
                }
            }
        }
        return $toInsertItems;
    }
}