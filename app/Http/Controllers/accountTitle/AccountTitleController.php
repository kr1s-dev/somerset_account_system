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
     * Show the form for creating a new resource.
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountTitleRequest $request)
    {
        $input = $this->addAndremoveKey(Request::all(),true);
        if(array_key_exists('account_title_name', $input)){
            unset($input['account_title_name']);
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
        //
        $accountTitle = $this->getAccountTitles($id);
        $accountTitle->update($request->all());
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
