<?php

namespace App\Http\Controllers\assets;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;
use App\Http\Requests\assets\AssetRequest;

class AssetController extends Controller
{
    use UtilityHelper;

    /**
     * Check if user is logged in
     * Check the usertype of logged in user
     *
    */
    public function __construct(){
        $this->middleware('user.type:asset');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $assetModelsList = $this->getAssetModel(null);
            return view('assets.show_asset_list',
                            compact('assetModelsList'));    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
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
            $assetModel = $this->setAssetModel();
            $fixedAssetAccountTitle = $this->getObjectRecords('account_titles',array('account_group_id'=>2));
            $assetModelList = $this->getControlNo('asset_items');
            $assetNumber = $assetModelList->AUTO_INCREMENT;
            return view('assets.create_asset',
                            compact('assetModel',
                                    'assetNumber',
                                    'fixedAssetAccountTitle'));    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetRequest $request)
    {
        try{
            $creditTitleId = array();
            $journalEntryList = array();
            $input = $this->addAndremoveKey($request->all(),true);  
            $input['net_value'] =  $input['total_cost'];
            $description = 'Bought item: ' . ($input['item_name']);
            if($input['mode_of_acquisition'] == 'Both' || $input['mode_of_acquisition'] == 'Payable'){
                $creditTitleId[] = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Notes Payable'));
                if($input['mode_of_acquisition'] == 'Both')
                    $creditTitleId[] = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Cash'));
            }else{
                $creditTitleId[] = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Cash'));
            }
            $input['monthly_depreciation'] = ($input['net_value']-$input['salvage_value']) / $input['useful_life'];  
            $input['next_depreciation_date'] = date('Y-m-d',strtotime('+1 Month'));
            $assetId = $this->insertRecord('asset_items',$input);

            //Create Journal Entry
            $this->assetJournalEntry($input['account_title_id'],
                                                $creditTitleId,
                                                $description,
                                                $assetId,
                                                $input,
                                                true);
            $this->createSystemLogs('Added a New Asset');
            flash()->success('Record successfully created')->important();
            return redirect('assets/'.$assetId);    
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
            $assetModel = $this->getAssetModel($id);
            return view('assets.show_asset',
                            compact('assetModel'));    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
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
            $assetModel = $this->getAssetModel($id);
            $fixedAssetAccountTitle = $this->getObjectRecords('account_titles',array('id'=>$assetModel->account_title_id));
            return view('assets.edit_asset',
                            compact('assetModel',
                                    'fixedAssetAccountTitle'));    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetRequest $request, $id)
    {
        try{
            $creditTitleId = array();
            $journalEntryList = array();
            $toDeleteJournalEntry = array();
            $asset = $this->getAssetModel($id);
            $input = $this->addAndremoveKey($request->all(),false);  
            $input['net_value'] =  $input['total_cost'];
            $description = 'Both item: ' . ($input['item_name']);
            if($input['mode_of_acquisition'] == 'Both' || $input['mode_of_acquisition'] == 'Payable'){
                // $input['total_cost'] += ($input['total_cost'] * ($input['interest']/100));
                // $input['net_value'] = $input['total_cost'];
                $creditTitleId[] = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Notes Payable'));
                if($input['mode_of_acquisition'] == 'Both')
                    $creditTitleId[] = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Cash'));
            }else{
                $creditTitleId[] = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Cash'));
            }
            $input['monthly_depreciation'] = ($input['net_value']-$input['salvage_value']) / $input['useful_life'];  

            // $eJournalEntries = $this->getObjectRecords('journal_entry',array('asset_id'=>$id));
            // foreach ($eJournalEntries as $eJournalEntry) {
            //     $toDeleteJournalEntry[] = $eJournalEntry->id;
            // }
            // $this->deleteRecord('journal_entry',$toDeleteJournalEntry);
            $this->deleteRecordWithWhere('journal_entry',array('asset_id'=>$id));
            //Create Journal Entry
            $this->assetJournalEntry($input['account_title_id'],
                                                $creditTitleId,
                                                $description,
                                                $asset,
                                                $input,
                                                false);
            
            $this->updateRecord('asset_items',$id,$input);
            $this->createSystemLogs('Updated an existing Asset');
            flash()->success('Record successfully Updated')->important();
            return redirect('assets/'.$id);    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
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
            //$assetModel = $this->getAssetModel($id);
            $this->deleteRecordWithWhere('journal_entry',array('asset_id'=>$id));
            $this->deleteRecordWithWhere('asset_items',array('id'=>$id));
            //$this->deleteRecord('asset_items',array($id));
            $this->createSystemLogs('Deleted an Existing Asset');
            flash()->success('Record successfully deleted')->important();
            return redirect('assets');    
        }catch(\Exception $ex){
            //return view('errors.404'); 
            echo $ex->getMessage();
        }
        
    }
}
