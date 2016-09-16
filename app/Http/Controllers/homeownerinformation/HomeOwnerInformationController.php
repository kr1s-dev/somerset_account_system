<?php


namespace App\Http\Controllers\homeownerinformation;

use Auth;
use Request;
use App\User;
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
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            if(Auth::user()->userType->type==='Cashier'){
                return view('errors.404'); 
            //echo $ex->getMessage();
            } else {
                $blockLotList = $this->getBlockLotAddress(null);
                $homeOwner = $this->setHomeOwnerInformation();
                $homeOwner->member_date_of_birth = date('m/d/Y',strtotime('-2 day'));
                return view('homeowners.create_homeowner_information',
                                compact('homeOwner',
                                        'blockLotList'));    
            }
        } catch(\Exception $ex) {
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
    public function store(HomeOwnerRequest $request)
    {
        try{
            $confirmation_code = array('confirmation_code'=>str_random(30));
            $input = $this->addAndremoveKey(Request::all(),true);
            $userList = $this->getObjectRecords('users',array('email'=>$input['member_email_address']));
            if(count($userList)>0){
                return redirect()->back()
                        ->withErrors(['member_email_address'=>'Duplicate Email Found'])
                        ->withInput();
            }else{
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
            }

            
        }catch(\Exception $ex){
            //echo $ex->getMessage();
            return view('errors.404'); 
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
            $ehomeOwnerInvoicesList = $this->getObjectRecords('home_owner_invoice',array('is_paid' => 0,'home_owner_id'=>$id));
            // $ehomeOwnerInvoicesList = array();
            // foreach ($thomeOwnerInvoicesList as $thomeOwnerInvoice) {
            //     $ehomeOwnerInvoicesList[$this->formatString($thomeOwnerInvoice->id)] = $thomeOwnerInvoice;
            // }
            return view('homeowners.show_homeowners_information',
                            compact('homeOwner',
                                    'homeOwnerMembersList',
                                    'ehomeOwnerInvoicesList'));    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
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
                return view('errors.404'); 
            //echo $ex->getMessage();
            }else{
                $homeOwner = $this->getHomeOwnerInformation($id);
                $blockLotList = $this->getBlockLotAddress($homeOwner->block_lot_id);
                return view('homeowners.edit_homeowner_information',
                            compact('homeOwner',
                                    'blockLotList'));  
            }
               
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
    public function update(HomeOwnerRequest $request, $id)
    {
        try{
            $hasDuplicate = false;
            $data = $this->addAndremoveKey(Request::all(),false);
            $userList = $this->getObjectRecords('users',array('email'=>$data['member_email_address']));
            foreach ($userList as $user) {
                if($hasDuplicate==false && $user->home_owner_id != $id){
                    $hasDuplicate = true;
                    break;
                }
            }
            //var_dump($hasDuplicate);
            if($hasDuplicate){
                return redirect()->back()
                        ->withErrors(['member_email_address'=>'Duplicate Email Found'])
                        ->withInput();
            }else{
                //echo 'success';
                $homeOwnerId = $this->updateRecord('home_owner_information',array($id),$data);
                $user = $this->getObjectFirstRecord('users',array('home_owner_id'=>$id));
                if(count($user)>0){
                    $this->updateRecord('users',array($user->id),array('email'=>$data['member_email_address']));
                }
                $this->createSystemLogs('Updated an Existing HomeOwner');
                flash()->success('Homeowner has been successfully updated');
                return redirect('homeowners/' . $id);     
            }
            
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