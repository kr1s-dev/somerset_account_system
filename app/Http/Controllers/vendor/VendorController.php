<?php

namespace App\Http\Controllers\vendor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;
use App\Http\Requests\vendor\VendorRequest;

class VendorController extends Controller
{
    use UtilityHelper;

    /**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        $this->middleware('user.type:vendor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $vendorList = $this->getVendor(null);
            return view('vendor_list.show_vendor_list',
                            compact('vendorList'));    
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
            $vendor = $this->setVendor();
            return view('vendor_list.create_vendor',
                            compact('vendor'));    
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
    public function store(VendorRequest $request)
    {
        try{
            $input = $this->addAndremoveKey($request->all(),true);
            $vendorId = $this->insertRecord('vendors',$input);
            $this->createSystemLogs('Created a New Vendor');
            flash()->success('Record successfully created');
            return redirect('vendor/'.$vendorId);    
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
        try{
            $vendor = $this->getVendor($id);
            return view('vendor_list.show_vendor',
                            compact('vendor'));    
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
            $vendor = $this->getVendor($id);
            return view('vendor_list.edit_vendor',
                            compact('vendor'));    
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
    public function update(VendorRequest $request, $id)
    {
        try{
            $input = $this->addAndremoveKey($request->all(),false);
            $this->updateRecord('vendors',array($id),$input);
            $this->createSystemLogs('Updated an Existing Vendor');
            flash()->success('Record successfully Updated');
            return redirect('vendor/'.$id);    
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
            $this->deleteRecord('vendors',array($id));
            $this->createSystemLogs('Deleted an Existing Vendor');
            flash()->success('Record successfully deleted')->important();
            return redirect('vendor');    
        }catch(\Exception $ex){
            return view('errors.404'); 
            //echo $ex->getMessage();
        }
        
    }
}
