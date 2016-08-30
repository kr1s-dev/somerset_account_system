<?php


namespace App\Http\Controllers\homeownerinformation;

use Auth;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;
use App\Http\Requests\homeownerInformation\HomeOwnerRequest;

class HomeOwnerInformationController extends Controller
{
    use UtilityHelper;

    /**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        $this->middleware('user.type:homeownerinfo');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get list of homeowners
        try{
            $eHomeOwnersList = $this->getHomeOwnerInformation(null);
            return view('homeowners.homeowners_list',
                            compact('eHomeOwnersList'));    
        }catch(\Exception $ex){
            return view('errors.503');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //try{
            if(Auth::user()->userType->type==='Cashier'){
                return view('errors.503');
            } else {
                $homeOwner = $this->setHomeOwnerInformation();
                $homeOwner->member_date_of_birth = date('m/d/Y',strtotime('-2 day'));
                return view('homeowners.create_homeowner_information',
                                compact('homeOwner'));    
            }
        /*} catch(\Exception $ex) {
            return view('errors.503');
        }*/
         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeOwnerRequest $request)
    {
        try{
            $confirmation_code = array('confirmation_code'=>str_random(30));
            $input = $this->addAndremoveKey(Request::all(),true);
            $homeOwnerId = $this->insertRecord('home_owner_information',$input);

            //Create User for HomeOwner
            $inputwithHomeOwner = array('home_owner_id'=>$homeOwnerId,
                                            'user_type_id'=>4,
                                            'confirmation_code'=> $confirmation_code['confirmation_code'],
                                            'email'=> $input['member_email_address'],);
            $userId = $this->insertRecord('users',$inputwithHomeOwner);

            //Send email verification
            $this->sendEmailVerification($input['member_email_address'],
                                            $input['first_name'] . ' ' . $input['middle_name'] . ' ' . $input['last_name'],
                                            $confirmation_code);
            $this->createSystemLogs('Added a New HomeOwner');
            flash()->success('Homeowner has been successfully created. An email is sent to verify the account.');
            return redirect('homeowners/' . $homeOwnerId);    
        }catch(\Exception $ex){
            return view('errors.503');
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
        try{
            //Show details of homeowner
            $homeOwner = $this->getHomeOwnerInformation($id);
            $homeOwnerMembersList = $this->getHomeOwnerMembers($id);
            $ehomeOwnerInvoicesList = $this->getObjectRecords('home_owner_invoice',array('is_paid' => 0));
            // $ehomeOwnerInvoicesList = array();
            // foreach ($thomeOwnerInvoicesList as $thomeOwnerInvoice) {
            //     $ehomeOwnerInvoicesList[$this->formatString($thomeOwnerInvoice->id)] = $thomeOwnerInvoice;
            // }
            return view('homeowners.show_homeowners_information',
                            compact('homeOwner',
                                    'homeOwnerMembersList',
                                    'ehomeOwnerInvoicesList'));    
        }catch(\Exception $ex){
            return view('errors.503');
        }
        
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
            if(Auth::user()->userType->type==='Cashier'){
                return view('errors.503');
            }else{
                $homeOwner = $this->getHomeOwnerInformation($id);
                return view('homeowners.edit_homeowner_information',
                            compact('homeOwner'));  
            }
               
        }catch(\Exception $ex){
            return view('errors.503');
        }
        
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
        try{
            $data = $this->addAndremoveKey(Request::all(),false);
            $homeOwnerId = $this->updateRecord('home_owner_information',array($id),$data);
            $user = $this->getObjectFirstRecord('users',array('home_owner_id'=>$id));
            if(count($user)>0){
                $this->updateRecord('users',array($user->id),array('email'=>$data['member_email_address']));
            }
            $this->createSystemLogs('Updated an Existing HomeOwner');
            flash()->success('Homeowner has been successfully updated');
            return redirect('homeowners/' . $id);    
        }catch(\Exception $ex){
            return view('errors.503');
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
        // $todeleteId = array($id);
        // $user = $this->getObjectFirstRecord('users',array('home_owner_id'=>$id));
        // $this->deleteRecord('users',array($user->id));
        // $this->deleteRecord('home_owner_information',$todeleteId);
        // $this->deleteRecordWithWhere('users',array('home_owner_id'=>$id));
        // $this->deleteRecordWithWhere('home_owner_information',array('id'=>$id));

        // flash()->success('Record has been successfully deleted')->important();
        // return redirect('homeowners');
    }
}
