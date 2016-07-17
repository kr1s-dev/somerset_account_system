<?php

namespace App\Http\Controllers\homeownermember;

use App\Http\Requests;
use Request;
use App\Http\Requests\homeownermember\HomeOwnerMemberRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class HomeOwnerMemberController extends Controller
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $nHomeOwnerMember = $this->setHomeOwnerMemberInformation();
        $ehomeOwnerInformation = $this->getHomeOwnerInformation($id);   
        return view('homeowner_members.create_homeowner_member',
                        compact('ehomeOwnerInformation',
                                'nHomeOwnerMember'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeOwnerMemberRequest $request)
    {
        $input = $this->addAndremoveKey(Request::all(),true);
        $homeOwnerId = $this->insertRecord('home_owner_member_information',$input);
        flash()->success('Record successfully created');
        return redirect('homeowners/'.$input['home_owner_id']);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nHomeOwnerMember = $this->getHomeOwnerMemberInformation($id);
        $ehomeOwnerInformation = $this->getHomeOwnerInformation($nHomeOwnerMember->home_owner_id);
        return view('homeowner_members.edit_homeowner_member',
                        compact('nHomeOwnerMember',
                                'ehomeOwnerInformation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HomeOwnerMemberRequest $request, $id)
    {
        $homeOwnerMember = $this->getHomeOwnerMemberInformation($id);
        $homeOwnerMember->update($request->all());
        flash()->success('Record successfully updated');
        return redirect('homeowners/'.$homeOwnerMember->home_owner_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $homeOwnerMember = $this->getHomeOwnerMemberInformation($id);
        $todeleteId = array($id);
        $this->deleteRecord('home_owner_member_information',$todeleteId);
        flash()->success('Record successfully deleted')->important();
        return redirect('homeowners/'.$homeOwnerMember->home_owner_id);
    }
}
