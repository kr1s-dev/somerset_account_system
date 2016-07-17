<?php

namespace App\Http\Controllers\accountGroup;

use App\AccountGroupModel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class AccountGroupController extends Controller
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
        $accountGroupList = $this->getAccountGroups(null);
        return view('accountGroup.account_group_list',
                        compact('accountGroupList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $accountGroup = new AccountGroupModel;
        return view('accountGroup.create_account_group',
                        compact('accountGroup'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate Information
        $this->validate($request, [
            'account_group_name' => 'unique:account_groups',
        ]);

        AccountGroupModel::create([
            'account_group_name' => $request->input('account_group_name'),
            'description' => $request->input('description'),
        ]);

        return redirect('accountgroup');

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
        $accountGroup = $this->getAccountGroups($id);
        return view('accountGroup.show_account_group',
                        compact('accountGroup'));
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
        $accountGroup = $this->getAccountGroups($id);
        return view('accountGroup.edit_account_group',
                        compact('accountGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $accountGroup =  $this->getAccountGroups($id);
        $this->validate($request, [
            'account_group_name' => 'unique:account_groups,account_group_name,'.$id,
        ]);
        
        $accountGroup->update($request->all());
        return redirect('accountgroup');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AccountGroupModel::destroy($id);
        return redirect('accountgroup');
    }
}
