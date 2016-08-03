<?php

namespace App\Http\Controllers\user;

use Validator;
use Request;
use Illuminate\Mail\Message;
use App\Http\Requests\user\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    use UtilityHelper,ResetsPasswords;


    
    /**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        $this->middleware('user.type:users');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get all Users
        $users_list = $this->getUser(null);
        $temp_user_type_list = $this->getUserType(null);
        $user_type_list = array();
        foreach ($temp_user_type_list as $userType) {
            $user_type_list[$userType->id] =  $userType->type;
        }
        $thomeOwnersList = $this->getHomeOwnerInformation(null);
        $eHomeOwnersList = array();
        foreach ($thomeOwnersList as $thomeOwner) {
            $eHomeOwnersList[$thomeOwner->id] = $thomeOwner;
        }
        //Return user list view
        return view('users.users_list',
                        compact('users_list',
                                'user_type_list',
                                'eHomeOwnersList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isCreate = TRUE;
        $nUser = $this->setUser();
        $eUserTypesList = $this->getUsersUserType(null);
        $tHomeOwnersList = $this->getHomeOwnerInformation(null);

        $eHomeOwners = array();
        if(count($tHomeOwnersList)){
            foreach ($tHomeOwnersList as $thomeOwner) {
                if($thomeOwner->user == NULL){
                    $eHomeOwners[$thomeOwner->id] = $thomeOwner;
                }
                
            }
        }
        //Show create users page
        return view('users.create_user',
                        compact('nUser',
                                'eUserTypesList',
                                'eHomeOwners',
                                'isCreate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {


        $confirmation_code = array('confirmation_code'=>str_random(30));
        $input = $this->addAndremoveKey(Request::all(),true);
        $input['confirmation_code'] = $confirmation_code['confirmation_code'];

        //if(empty($input['home_owner_id'])){
        $input['home_owner_id'] = NULL;
        $userId = $this->insertRecord('users',$input);
        // }else{
        //     $inputwithHomeOwner = array('home_owner_id'=>$input['home_owner_id'],
        //                                 'user_type_id'=>$input['user_type_id'],
        //                                 'confirmation_code'=> $confirmation_code['confirmation_code'],
        //                                 'email'=> $input['email'],);
        //     $userId = $this->insertRecord('users',$inputwithHomeOwner);
        // }
        
        //Send email verification
        $this->sendEmailVerification($input['email'],
                                        $input['first_name'] . ' ' . $input['middle_name'] . ' ' . $input['last_name'],
                                        $confirmation_code);

        flash()->success('Record succesfully created. An email is sent to verify the account.')->important();
        //return redirect('users');
        return $this->show($userId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $eUser = $this->getUser($id);
        return view('users.show_user',   
                        compact('eUser'));   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $isCreate = False;
        $nUser = $this->getUser($id);
        $eUserTypesList = $this->getUsersUserType($nUser->user_type_id);
        if($nUser->home_owner_id != NULL){
            $thomeOwner = $this->getHomeOwnerInformation($nUser->home_owner_id);
            $eHomeOwners = array($thomeOwner->id => $thomeOwner);
        }else{
            $eHomeOwners = $this->getHomeOwnerInformation(null);
        }

        return view('users.edit_user',
                        compact('nUser',
                                'eUserTypesList',
                                'eHomeOwners',
                                'isCreate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = $this->getUser($id);
        $data = $this->addAndremoveKey(Request::all(),false);
        if($user->home_owner_id == NULL){
            $user->update($request->all());
        }else{
            $this->updateRecord('users',$id,array('email'=>$data['email'],
                                                    'user_type_id'=>$data['user_type_id']));
            $data['member_mobile_no'] = $data['mobile_number'];
            $data['member_email_address'] = $data['email'];
            unset($data['mobile_number'],
                    $data['user_type_id'],
                    $data['email']);
            $toUpdateId = array($user->home_owner_id);
            $this->updateRecord('home_owner_information',$toUpdateId,$data);
        }
        flash()->success('Record succesfully updated')->important();
        //return redirect('users');
        return $this->show($id);
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
        $this->deleteRecord('users',$todeleteId);
        flash()->success('Record succesfully deleted')->important();
        return redirect('users');
    }


    /**
    * Deactivate User
    * @param  int  $id
    * @return \Illuminate\Http\Response
    **/
    public function deactivateUser($id){
        $user = $this->getUser($id);
        $user->is_active = 0;
        $user->save();
        flash()->success('User succesfully deactivated')->important();
        return redirect('users');
    }

    /**
    * Reset User Password
    * @param  int  $id
    * @return \Illuminate\Http\Response
    **/
    public function resetPassword($id){
        $user = $this->getUser($id);
        $emails = array('email'=>$user->email);
        $response = Password::sendResetLink($emails, function (Message $message) {
            $message->subject($this->getEmailSubject());
            $message->from('SomersetAccountingSystem@noreply.com','Reset Password');
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                $user->is_active = 1;
                $user->save();
                flash()->success('A reset link is sent into you email.')->important();
                return redirect('users');
                //return redirect()->back()->with('status', trans($response));
            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

}
