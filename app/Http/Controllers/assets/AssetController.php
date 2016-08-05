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
        $assetModelsList = $this->getAssetModel(null);
        return view('assets.show_asset_list',
                        compact('assetModelsList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assetModel = $this->setAssetModel();
        $fixedAssetAccountTitle = $this->getObjectRecords('account_titles',array('account_group_id'=>2));
        $assetModelList = $this->getObjectLastRecord('asset_items','');
        $assetNumber = 1;
        if(count($assetModelList)>0){
            $assetNumber =  ($assetModelList->id + 1);
        }
        $assetNumber = $this->formatString($assetNumber);
        return view('assets.create_asset',
                        compact('assetModel',
                                'assetNumber',
                                'fixedAssetAccountTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetRequest $request)
    {
        $creditTitleId = array();
        $journalEntryList = array();
        $input = $this->addAndremoveKey($request->all(),true);  
        $input['net_value'] =  $input['total_cost'];
        $description = 'Bought item: ' . ($input['item_name']);
        if($input['mode_of_acquisition'] == 'Both' || $input['mode_of_acquisition'] == 'Payable'){
            $input['total_cost'] += ($input['total_cost'] * ($input['interest']/100));
            $input['net_value'] = $input['total_cost'];
            $creditTitleId[] = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Accounts Payable'));
            if($input['mode_of_acquisition'] == 'Both')
                $creditTitleId[] = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Cash'));
        }else{
            $creditTitleId[] = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Cash'));
        }
        $input['monthly_depreciation'] = ($input['net_value']-$input['salvage_value']) / $input['useful_life'];  
        
        $assetId = $this->insertRecord('asset_items',$input);

        //Create Journal Entry
        $this->assetJournalEntry($input['account_title_id'],
                                            $creditTitleId,
                                            $description,
                                            $assetId,
                                            $input,
                                            true);
        flash()->success('Record successfully created')->important();
        return redirect('assets/'.$assetId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assetModel = $this->getAssetModel($id);
        return view('assets.show_asset',
                        compact('assetModel'));

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $assetModel = $this->getAssetModel($id);
        $fixedAssetAccountTitle = $this->getObjectRecords('account_titles',array('id'=>$assetModel->account_title_id));
        return view('assets.edit_asset',
                        compact('assetModel',
                                'fixedAssetAccountTitle'));
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
        $creditTitleId = array();
        $journalEntryList = array();
        $toDeleteJournalEntry = array();
        $asset = $this->getAssetModel($id);
        $input = $this->addAndremoveKey($request->all(),false);  
        $input['net_value'] =  $input['total_cost'];
        $description = 'Both item: ' . ($input['item_name']);
        if($input['mode_of_acquisition'] == 'Both' || $input['mode_of_acquisition'] == 'Payable'){
            $input['total_cost'] += ($input['total_cost'] * ($input['interest']/100));
            $input['net_value'] = $input['total_cost'];
            $creditTitleId[] = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Accounts Payable'));
            if($input['mode_of_acquisition'] == 'Both')
                $creditTitleId[] = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Cash'));
        }else{
            $creditTitleId[] = $this->getObjectFirstRecord('account_titles',array('account_sub_group_name'=>'Cash'));
        }
        $input['monthly_depreciation'] = ($input['net_value']-$input['salvage_value']) / $input['useful_life'];  

        $eJournalEntries = $this->getObjectRecords('journal_entry',array('asset_id'=>$id));
        foreach ($eJournalEntries as $eJournalEntry) {
            $toDeleteJournalEntry[] = $eJournalEntry->id;
        }
        $this->deleteRecord('journal_entry',$toDeleteJournalEntry);

        //Create Journal Entry
        $this->assetJournalEntry($input['account_title_id'],
                                            $creditTitleId,
                                            $description,
                                            $asset,
                                            $input,
                                            false);
        
        $this->updateRecord('asset_items',$id,$input);
        flash()->success('Record successfully Updated')->important();
        return redirect('assets/'.$id);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assetModel = $this->getAssetModel($id);
        $this->deleteRecord('asset_items',array($id));
        $this->getAllItems($assetModel->account_title_id);
        flash()->success('Record successfully deleted')->important();
        return redirect('assets');
    }
}
