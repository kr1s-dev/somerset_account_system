<?php


namespace App\Http\Controllers\homeownerinformation;

use App\InvoiceModel;
use Request;
use App\Http\Requests;
use App\Http\Requests\homeownerInformation\HomeOwnerRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class HomeOwnerInformationController extends Controller
{
    use UtilityHelper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get list of homeowners
        $eHomeOwnersList = $this->getHomeOwnerInformation(null);
        return view('homeowners.homeowners_list',
                        compact('eHomeOwnersList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $homeOwner = $this->setHomeOwnerInformation();
        return view('homeowners.create_homeowner_information',
                        compact('homeOwner'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeOwnerRequest $request)
    {
        $input = $this->addAndremoveKey(Request::all(),true);
        $homeOwnerId = $this->insertRecord('home_owner_information',$input);
        flash()->success('Homeowner has been successfully created');
        return redirect('homeowners/' . $homeOwnerId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Show details of homeowner
        $homeOwner = $this->getHomeOwnerInformation($id);
        $homeOwnerMembersList = $this->getHomeOwnerMembers($id);
        $thomeOwnerInvoicesList = $this->getObjectRecords('home_owner_invoice',array('is_paid' => 0));
        $ehomeOwnerInvoicesList = array();
        foreach ($thomeOwnerInvoicesList as $thomeOwnerInvoice) {
            $ehomeOwnerInvoicesList[$this->formatString($thomeOwnerInvoice->id)] = $thomeOwnerInvoice;
        }
        return view('homeowners.show_homeowners_information',
                        compact('homeOwner',
                                'homeOwnerMembersList',
                                'ehomeOwnerInvoicesList'));
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
        $homeOwner = $this->getHomeOwnerInformation($id);
        return view('homeowners.edit_homeowner_information',
                        compact('homeOwner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HomeOwnerRequest $request, $id)
    {

        $data = $this->addAndremoveKey(Request::all(),false);
        $homeOwnerId = $this->updateRecord('home_owner_information',array($id),$data);
        $user = $this->getObjectFirstRecord('users',array('home_owner_id'=>$id));
        if(count($user)>0){
            $this->updateRecord('users',array($user->id),array('email'=>$data['member_email_address']));
        }
        flash()->success('Homeowner has been successfully updated');
        return redirect('homeowners/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todeleteId = array($id);
        $this->deleteRecord('home_owner_information',$todeleteId);
        flash()->success('Record has been successfully deleted')->important();
        return redirect('homeowners');
    }
}
