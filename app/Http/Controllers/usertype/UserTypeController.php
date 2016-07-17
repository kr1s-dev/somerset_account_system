<?php

namespace App\Http\Controllers\usertype;

use Illuminate\Http\Request;

use Validator;
use App\UserTypeModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;


class UserTypeController extends Controller
{
    use UtilityHelper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get all User Type
        $usersTypesList = $this->getUserType(null);
        return view('usertype.user_type_list',
                        compact('usersTypesList'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userType = $this->setUserType();
        //show create users page
        return view('usertype.create_user_type',
                        compact('userType'));
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
            'type' => 'required|unique:user_type',
        ]);

        UserTypeModel::create([
            'type' => $request->input('type'),
            'description' => $request->input('description'),
        ]);

        return $this->index();
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
        $userType = UserTypeModel::findOrFail($id);
        return view('usertype.edit_user_type')->with('userType',$userType);  
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
        //
        $userType = UserTypeModel::findOrFail($id);
        $this->validate($request, [
            'type' => 'required|unique:user_type,type,'.$userType->id,
        ]);
        
        $userType->update($request->all());
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserTypeModel::destroy($id);
        return redirect('usertypes');
    }
}
