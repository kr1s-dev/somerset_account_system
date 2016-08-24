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
        $vendorList = $this->getVendor(null);
        return view('vendor_list.show_vendor_list',
                        compact('vendorList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendor = $this->setVendor();
        return view('vendor_list.create_vendor',
                        compact('vendor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request)
    {
        $input = $this->addAndremoveKey($request->all(),true);
        $vendorId = $this->insertRecord('vendors',$input);
        $this->createSystemLogs('Created a New Vendor');
        flash()->success('Record successfully created');
        return redirect('vendor/'.$vendorId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = $this->getVendor($id);
        return view('vendor_list.show_vendor',
                        compact('vendor'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = $this->getVendor($id);
        return view('vendor_list.edit_vendor',
                        compact('vendor'));

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
        $input = $this->addAndremoveKey($request->all(),false);
        $this->updateRecord('vendors',array($id),$input);
        $this->createSystemLogs('Updated an Existing Vendor');
        flash()->success('Record successfully Updated');
        return redirect('vendor/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->deleteRecord('vendors',array($id));
        $this->createSystemLogs('Deleted an Existing Vendor');
        flash()->success('Record successfully deleted')->important();
        return redirect('vendor');
    }
}
