<?php

namespace App\Http\Controllers\user;

use Auth;
use Hash;
use Bcrypt;
use Request;
use Validator;
use App\Http\Requests;
use Illuminate\Mail\Message;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;
use App\Http\Requests\user\UserRequest;
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
        try{
            $users_list = $this->getUser(null);
            // $temp_user_type_list = $this->getUserType(null);
            // $user_type_list = array();
            // foreach ($temp_user_type_list as $userType) {
            //     $user_type_list[$userType->id] =  $userType->type;
            // }
            // $thomeOwnersList = $this->getHomeOwnerInformation(null);
            // $eHomeOwnersList = array();
            // foreach ($thomeOwnersList as $thomeOwner) {
            //     $eHomeOwnersList[$thomeOwner->id] = $thomeOwner;
            // }
            //Return user list view
            if(Auth::user()->userType->type==='Guest'){
                return view('errors.404'); 
            }else{
                return view('users.users_list',
                            compact('users_list'));  
            }   
            
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

            $isCreate = TRUE;
            $nUser = $this->setUser();
            $eUserTypesList = $this->getUsersUserType(null);
            //Show create users page
            if(Auth::user()->userType->type==='Guest'){
                return view('errors.404'); 
            }else{
                return view('users.create_user',
                            compact('nUser',
                                    'eUserTypesList',
                                    'isCreate'));   
            } 
            
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
    public function store(UserRequest $request)
    {
        try{
            $confirmation_code = array('confirmation_code'=>str_random(30));
            $input = $this->addAndremoveKey(Request::all(),true);
            $input['confirmation_code'] = $confirmation_code['confirmation_code'];

            //if(empty($input['home_owner_id'])){
            $input['home_owner_id'] = NULL;
            $input['is_active'] = false;
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
            $this->createSystemLogs('Created a New User');
            flash()->success('Record succesfully created. An email is sent to verify the account.')->important();
            //return redirect('users');
            return $this->show($userId);    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
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
            $eUser = $this->getUser($id);
            if(Auth::user()->userType->type==='Guest'){
                return view('guest_profile.guest_profile',   
                            compact('eUser'));  
            }else{
                return view('users.show_user',   
                            compact('eUser'));  
            } 
               
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
            $isCreate = False;
            $nUser = $this->getUser($id);
            $eUserTypesList = $this->getUsersUserType($nUser->user_type_id);
            if($nUser->home_owner_id != NULL){
                $thomeOwner = $this->getHomeOwnerInformation($nUser->home_owner_id);
                $eHomeOwners = array($thomeOwner->id => $thomeOwner);
            }else{
                $eHomeOwners = $this->getHomeOwnerInformation(null);
            }

            if(Auth::user()->userType->type==='Guest'){
                return view('errors.404'); 
            }else{
                return view('users.edit_user',
                            compact('nUser',
                                    'eUserTypesList',
                                    'eHomeOwners',
                                    'isCreate'));      
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
    public function update(UserRequest $request, $id)
    {
        try{
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
            $this->createSystemLogs('Updated an Existing User');
            flash()->success('Record succesfully updated')->important();
            //return redirect('users');
            return $this->show($id);    
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
        try{
            return $this->deactivateUser($id);    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
        // $todeleteId = array($id);
        // $this->deleteRecord('users',$todeleteId);
        // flash()->success('Record succesfully deleted')->important();
        // return redirect('users');
    }


    /**
    * Deactivate User
    * @param  int  $id
    * @return \Illuminate\Http\Response
    **/
    public function deactivateUser($id){
        try{
            $user = $this->getUser($id);
            $user->is_active = 0;
            $user->save();
            $this->createSystemLogs('Deactivated an Active User');
            flash()->success('User succesfully deactivated')->important();
            return redirect('users');    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }

    /**
    * Reset User Password
    * @param  int  $id
    * @return \Illuminate\Http\Response
    **/
    public function resetPassword($id){
        try{

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
                    $this->createSystemLogs('Send Reset Password Link to an Existing User');
                    flash()->success('A reset link is sent into you email.')->important();
                    return redirect('users');
                    //return redirect()->back()->with('status', trans($response));
                case Password::INVALID_USER:
                    return redirect()->back()->withErrors(['email' => trans($response)]);
            }    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
    }


    public function getChangePassword($id){
        try{
            $user = $this->getUser($id);
            if(Auth::user()->userType->type==='Guest'){
                return view('guest_profile.guest_reset_password',
                            compact('user'));
            }else{
                return view('users.change_password',
                            compact('user'));
            }
            
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }       
    }

    public function postChangePassword(Request $request){
        try{

            $validator =  Validator::make(Request::all(),[
                'old_password' => 'required|min:6|max:255',
                'new_password' => 'required|confirmed|min:6|max:255',]);
            if ($validator->fails()) {
                return back()->withErrors($validator);
            }

            $user = $this->getUser(Auth::user()->id);
            $input = Request::all();
            if(Hash::check($input['old_password'], $user->password)){
                if($input['old_password'] === $input['new_password']){
                    return back()
                        ->withErrors(['new_password'=>'Can\'t used old password again']);
                }else{
                    $user->password = bcrypt($input['new_password']);
                    $user->save();
                    $this->createSystemLogs('User: ' . $user->first_name . ' ' , $user->last_name . ', Changed Password.');
                    flash()->success('Successfully Changed Password')->important(); 
                    return redirect('users/'.$user->id);
                }
            }else{
                return back()
                        ->withErrors(['old_password'=>'Old Password doesn\'t Match']);
            }

        }catch(\Exception $ex){  
            return view('errors.404'); 
        }       
    }

}
