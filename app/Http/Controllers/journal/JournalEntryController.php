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

    public function postJournalEntry(){
    	
    }
}
