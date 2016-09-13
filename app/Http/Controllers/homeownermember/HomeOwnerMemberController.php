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
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        $this->middleware('user.type:homeownermember');
    }
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
        try{
            $nHomeOwnerMember = $this->setHomeOwnerMemberInformation();
            $ehomeOwnerInformation = $this->getHomeOwnerInformation($id);   
            return view('homeowner_members.create_homeowner_member',
                            compact('ehomeOwnerInformation',
                                    'nHomeOwnerMember'));    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeOwnerMemberRequest $request)
    {
        try{
            $input = $this->addAndremoveKey(Request::all(),true);

            $homeOwnerId = $this->insertRecord('home_owner_member_information',$input);
            $this->createSystemLogs('Added a New HomeOwnerMember');
            flash()->success('Record successfully created');
            return redirect('homeowners/'.$input['home_owner_id']);    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
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
        try{
            $nHomeOwnerMember = $this->getHomeOwnerMemberInformation($id);
            $ehomeOwnerInformation = $this->getHomeOwnerInformation($nHomeOwnerMember->home_owner_id);
            return view('homeowner_members.edit_homeowner_member',
                            compact('nHomeOwnerMember',
                                    'ehomeOwnerInformation'));    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
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
        try{
            $homeOwnerMember = $this->getHomeOwnerMemberInformation($id);
            $homeOwnerMember->update($request->all());
            flash()->success('Record successfully updated');
            $this->createSystemLogs('Updated an Existing HomeOwnerMember');
            return redirect('homeowners/'.$homeOwnerMember->home_owner_id);    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $homeOwnerMember = $this->getHomeOwnerMemberInformation($id);
        // $todeleteId = array($id);
        // $this->deleteRecord('home_owner_member_information',$todeleteId);
        try{
            $this->deleteRecordWithWhere('home_owner_member_information',array('id'=>$id));
            flash()->success('Record successfully deleted')->important();
            $this->createSystemLogs('Deleted an Existing HomeOwnerMember');
            return redirect('homeowners/'.$homeOwnerMember->home_owner_id);    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }
}
