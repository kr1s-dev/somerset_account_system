<?php

namespace App\Http\Controllers\accountTitle;


use Request;
use App\Http\Requests;
use App\Http\Requests\accountTitle\AccountTitleRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class AccountTitleController extends Controller
{
    use UtilityHelper;

    /**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        $this->middleware('user.type:accounttitle');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $taccountGroupList = $this->getAccountGroups(null);
        return view('accountTitles.account_title_list',
                        compact('taccountGroupList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $accountGroupList = $this->getAccountTitleGroup(null);
        $eAccountTitle = $this->setAccountTitleModel();
        $accountTitle = $this->setAccountTitleModel();
        return view('accountTitles.create_account_title',
                        compact('accountGroupList',
                                'eAccountTitle',
                                'accountTitle'));
    }


    /**
     * Show the form for creating a new resource with parent Account Title Id.
     *
     * @return \Illuminate\Http\Response
     */
    public function createWithParent($id)
    {
        //
        $accountGroupList = $this->getAccountTitleGroup(null);
        $eAccountTitle = $this->getAccountTitles($id);
        $accountTitle = $this->setAccountTitleModel();
        return view('accountTitles.create_account_title',
                        compact('accountGroupList',
                                'eAccountTitle',
                                'accountTitle'));

    }

    /**
     * Show the form for creating a new resource with Account Group Id.
     *
     * @return \Illuminate\Http\Response
     */
    public function createWithGroupParent($id){
        //echo 'hi';
        $accountGroupList = $this->getAccountGroups($id);
        $eAccountTitle = $this->setAccountTitleModel();
        $accountTitle = $this->setAccountTitleModel();
        return view('accountTitles.create_account_title',
                        compact('accountGroupList',
                                'eAccountTitle',
                                'accountTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountTitleRequest $request)
    {
        $input = $this->addAndremoveKey(Request::all(),true);
        if(array_key_exists('subject_to_vat', $input))
            $input['subject_to_vat'] = ($input['subject_to_vat']==='on'?1:0);
        else
            $input['subject_to_vat'] = 0;

        if(!($input['subject_to_vat']))
            $input['vat_percent'] = 0;

        
        if(array_key_exists('account_title_name', $input)){
            unset($input['account_title_name']);
        }

        if(array_key_exists('account_group_name', $input)){
            unset($input['account_group_name']);
        }

        
        if(empty($input['description']))
            $input['description'] = 'No Description';
        $accounttileId = $this->insertRecord('account_titles',$input);

        flash()->success('Record successfully created');
        return redirect('accounttitle/'.$accounttileId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $accountTitle = $this->getAccountTitles($id);
        $eAccountTitle = $this->getAccountTitles($id);
        $accountGroupList = $this->getAccountGroups($accountTitle->account_group_id);
        return view('accountTitles.show_account_title',
                        compact('accountGroupList',
                                'eAccountTitle',
                                'accountTitle'));

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
        $accountTitle = $this->getAccountTitles($id);
        $eAccountTitle = ($accountTitle->account_title_id != NULL ) ? 
                            $this->getAccountTitles($accountTitle->account_title_id) : 
                                $this->setAccountTitleModel();
        $accountGroupList = $this->getAccountTitleGroup($accountTitle->account_group_id);
        return view('accountTitles.edit_account_title',
                        compact('accountGroupList',
                                'eAccountTitle',
                                'accountTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountTitleRequest $request, $id)
    {
        $input = $this->addAndremoveKey(Request::all(),false);
    
        if(array_key_exists('subject_to_vat', $input))
            $input['subject_to_vat'] = ($input['subject_to_vat']==='on'?1:0);
        else
            $input['subject_to_vat'] = 0;

        if(!($input['subject_to_vat']))
            $input['vat_percent'] = 0;
        
        if(array_key_exists('account_title_name', $input)){
            unset($input['account_title_name']);
        }

        if(array_key_exists('account_group_name', $input)){
            unset($input['account_group_name']);
        }

        
        if(empty($input['description']))
            $input['description'] = 'No Description';

        $accountTitle = $this->getAccountTitles($id);
        $accountTitle->update($input);
        flash()->success('Record successfully updated');
        return redirect('accounttitle/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->deleteRecord('account_titles',array($id));
        flash()->success('Record successfully deleted')->important();
        return redirect('accounttitle');
        //
        // AccountTitleModel::destroy($id);
        // 
    }
}
