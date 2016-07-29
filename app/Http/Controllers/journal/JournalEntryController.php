<?php

namespace App\Http\Controllers\journal;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;
class JournalEntryController extends Controller
{
    use UtilityHelper;
    //Return a view page for journal Entry
    public function getJournalEntry(){
        $accountTitlesList = $this->getAccountTitles(null);
        return view('journal.journal_create',
                        compact('accountTitlesList'));
    }

    public function postJournalEntry(Request $request){
    	//Getting ajax values
    	$data = $request->input('data');
    	$explanation = $request->input('explanation');
    	//Getting ajax values
    	
    	$this->insertBulkRecord('journal_entry',$this->createJouralEntry($data,$explanation));
    	// DB::table('journal_entry')->insert($toInsertItems);

    }

    public function createJouralEntry($data,$explanation){
    	$count = 0;
    	$dataToInsertList = explode(',',$data);
    	$toInsertItems = array();
    	foreach($dataToInsertList as $dataToInsert){
    		++$count;
    		if($count==1){
    			$type = $dataToInsert;
    		}else if($count==2){
    			$accountTitleId = $dataToInsert;
            }else if($count==3){
                $description = $dataToInsert;
    		}else if($count==4){
    			$amount = $dataToInsert;
    			$count = 0;
    			if($type=='DR'){
    				$toInsertItems[] = array('created_by' => $this->getLogInUserId(),
                                            	'updated_by' => $this->getLogInUserId(),
                                            	'created_at' => date('Y-m-d'),
                                            	'updated_at'=>  date('Y-m-d'),
                                            	'credit_title_id'=>NULL, 
    											'credit_amount'=>0.00,
    											'debit_title_id'=>$accountTitleId,
    											'debit_amount'=>$amount,
    											'description'=>$description);
    			}else if($type=='CR'){
    				$toInsertItems[] = array('created_by' => $this->getLogInUserId(),
                                            	'updated_by' => $this->getLogInUserId(),
                                            	'created_at' => date('Y-m-d'),
                                            	'updated_at'=>  date('Y-m-d'),
                                            	'debit_title_id'=>NULL,
    											'debit_amount'=>0.00,
    											'credit_title_id'=>$accountTitleId,
    											'credit_amount'=>$amount,
    											'description'=>$description);
    			}
    		}
    	}
    	return $toInsertItems;
    }
}
