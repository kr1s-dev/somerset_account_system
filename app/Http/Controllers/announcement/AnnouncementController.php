<?php

namespace App\Http\Controllers\announcement;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;
use App\Http\Requests\announcement\AnnouncementRequest;

class AnnouncementController extends Controller
{
    use UtilityHelper;
    
    /**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        if(Auth::user()->userType->type==='Administrator')
            $this->middleware('user.type:announcement');
        elseif(Auth::user()->userType->type==='Guest')
            $this->middleware('user.type:announcement',['only' => ['show']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->userType->type==='Guest'){
            return view('errors.503');
        }else{
            $announcementsList = $this->getAnnouncementModel(null);
            return view('announcement.show_announcement_list',
                            compact('announcementsList'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->userType->type==='Guest'){
            return view('errors.503');
        }else{
            $announcement = $this->setAnnouncementModel();
            return view('announcement.create_announcement',
                            compact('announcement'));
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnouncementRequest $request)
    {
        $input = $this->addAndremoveKey($request->all(),true);
        $announcementId = $this->insertRecord('announcements',$input); 
        $this->createSystemLogs('Created a new Announcement');
        flash()->success('Record successfully created')->important();
        return redirect('announcement/'.$announcementId);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $announcement = $this->getAnnouncementModel($id);
        if(Auth::user()->userType->type==='Guest'){
             return view('guest_announcement.show_guest_announcement',
                        compact('announcement'));
        }else{
             return view('announcement.show_announcement',
                        compact('announcement'));
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
        if(Auth::user()->userType->type==='Guest'){
            return view('errors.503');
        }else{
            $announcement = $this->getAnnouncementModel($id);
            return view('announcement.edit_announcement',
                            compact('announcement'));
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnnouncementRequest $request, $id)
    {
        $announcement = $this->getAnnouncementModel($id);
        $announcement->update($request->all());
        $this->createSystemLogs('Updated an existing Announcement');
        flash()->success('Record successfully updated');
        return redirect('announcement/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->userType->type==='Guest'){
            return view('errors.503');
        }else{
            $this->deleteRecordWithWhere('announcements',array('id'=>$id));
            $this->createSystemLogs('Deleted an existing announcement');
            flash()->success('Record successfully deleted')->important();
            return redirect('announcement');
        }
        
    }
}
