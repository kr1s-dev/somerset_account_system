<?php

namespace App\Http\Controllers\settings;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;
use App\Http\Requests\settings\SettingsRequest;

class SettingsController extends Controller
{
    use UtilityHelper;

    /**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        $this->middleware('user.type:settings');
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
    public function create()
    {
        $setting = $this->getSettings();
        if(empty($setting)){
            $setting = $this->setSettings();
            $setting->id = null;
            $setting->tax = 1;
            $setting->days_till_due_date = 1;
            $setting->cut_off_date = 1;
            
        }
        // else{
        //     return $this->show($setting->id);
        // }
        return view('settings.create_update_system_setting',
                        compact('setting'));

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingsRequest $request)
    {
        $input = $this->addAndremoveKey(Request::all(),true);
        $settingId = $this->insertRecord('system_settings',$input);
        $this->createSystemLogs('Updated System Settings');
        flash()->success('System Settings successfully Update');
        return redirect('/admin-dashboard');

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
            $setting = $this->getSettings();
            if(empty($setting)){
                $setting = $this->setSettings();
                $setting->id = null;
                $setting->tax = 1;
                $setting->days_till_due_date = 1;
                $setting->cut_off_date = 1;
                return view('settings.create_update_system_setting',
                            compact('setting'));
            }else{
                return view('settings.show_settings_info',
                            compact('setting'));
            }
            // $setting = $this->getSettings();
            // return view('settings.show_settings_info',
            //                 compact('setting'));
        }catch(\Exception $ex){
            $ex->getMessage();
            //return view('errors.404'); 
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SettingsRequest $request, $id)
    {
        $input = $this->addAndremoveKey(Request::all(),false);
        $this->updateRecord('system_settings',array($id),$input);
        $this->createSystemLogs('Updated System Settings');
        flash()->success('System Settings successfully Update');
        return redirect('settings/'.$id);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
