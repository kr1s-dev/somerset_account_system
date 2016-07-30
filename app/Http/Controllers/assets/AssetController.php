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
        $input = $this->addAndremoveKey(Request::all(),true);   
        $dateToday = new \DateTime(date('m/d/y'));
        $dateAcquired = new \DateTime($input['date_acquired']);
        $interval = ($dateToday->diff($dateAcquired)->m + $dateToday->diff($dateAcquired)->y*12);
        $input['subject_to_depreciation'] = $input['subject_to_depreciation'] == 'Yes' ? 1 : 0;
        if($input['subject_to_depreciation']){
            if( $interval != 0){
                $input['accumulated_depreciation'] = ($interval * $input['monthly_depreciation']);
                $input['net_value'] = $input['original_cost'] - $input['accumulated_depreciation'] < 0 ? 0 
                                        : $input['original_cost'] - $input['accumulated_depreciation'];
            }else{
                $input['net_value'] = $input['original_cost'];
            }
            $input['months_remaining'] = $input['net_value'] / $input['monthly_depreciation'];
        }
        
        $assetId = $this->insertRecord('asset_items',$input);
        $this->getAllItems($input['account_title_id']);
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
        $input = $this->addAndremoveKey(Request::all(),false);   
        $dateToday = new \DateTime(date('m/d/y'));
        $dateAcquired = new \DateTime($input['date_acquired']);
        $interval = ($dateToday->diff($dateAcquired)->m + $dateToday->diff($dateAcquired)->y*12);
        if($input['subject_to_depreciation']){
            if( $interval != 0){
                $input['accumulated_depreciation'] = ($interval * $input['monthly_depreciation']);
                $input['net_value'] = $input['original_cost'] - $input['accumulated_depreciation'] < 0 ? 0 
                                        : $input['original_cost'] - $input['accumulated_depreciation'];
            }else{
                $input['net_value'] = $input['original_cost'];
            }
            $input['months_remaining'] = $input['net_value'] / $input['monthly_depreciation'];
        }

        $this->updateRecord('asset_items',$id,$input);
        $this->getAllItems($input['account_title_id']);
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
