<?php

namespace App\Http\Controllers\registerverifier;

use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RegisterVerifierController extends Controller
{
    use UtilityHelper;
    public function getVerifier($confirmationCode){
        if(is_null($confirmationCode)){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }

        try{
            $secretQuestions = $this->getObjectRecords('secret_question',null);
            $user = $this->getObjectFirstRecord('users',array('confirmation_code'=>$confirmationCode));
            
            if(empty($user)){
                return redirect('auth/login');
            }else{
                return view('auth.verify',
                                compact('user',
                                        'secretQuestions'));
            }    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }

        
    }

    public function postVerifier(Request $request){
        try{
            $rules = array('password'=>'required|min:8|same:confirmation_password');

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return redirect()->back()
                            ->withErrors($validator);
            }else{
               $toUpdateItems = array('confirmation_code'=>null,
                                    'password'=>bcrypt($request->input('password')),
                                    'is_active'=>1,
                                    'secret_question_id'=>$request->input('secret_question_id'),
                                    'secret_answer' => $request->input('secret_answer'));
                $this->updateRecord('users',array($request->input('userid')),$toUpdateItems);
                flash()->success('User successfully verified. Log in to continue.');
                return redirect('auth/login');   
            }
              
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
        
    }
}
