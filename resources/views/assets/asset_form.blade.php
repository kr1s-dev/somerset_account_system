<div class="form-group" align="center">
  @include('errors.validator')
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fixed Asset Group <span class="required">*</span> </label>
   <div class="col-md-6 col-sm-6 col-xs-12">
      <select id="accountgroup" name="account_title_id" class="select2_single form-control" tabindex="-1">
         @foreach($fixedAssetAccountTitle as $key)
            <option value="{{$key->id}}">{{$key->account_sub_group_name}}</option>
         @endforeach
      </select>
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Item Name <span class="required">*</span>
   </label>
   <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" id="first-name" name="item_name" value="{{ count($errors) > 0? old('item_name'):($assetModel->item_name) }}" required="required" class="form-control col-md-7 col-xs-12">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description <span class="required">*</span>
   </label>
   <div class="col-md-6 col-sm-6 col-xs-12">
      <input type="text" id="first-name" name="description" value="{{ count($errors) > 0? old('description'):($assetModel->description) }}" required="required" class="form-control col-md-7 col-xs-12">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Quantity <span class="required">*</span>
   </label>
   <div class="col-md-3 col-sm-6 col-xs-12">
      <input type="number" min="1" id="first-name" name="quantity" value="{{ count($errors) > 0? old('quantity'):($assetModel->quantity) }}" required="required" class="form-control col-md-7 col-xs-12">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cost<span class="required">*</span>
   </label>
   <div class="col-md-3 col-sm-6 col-xs-12">
      <input type="number" min="1" id="first-name" name="total_cost" value="{{ count($errors) > 0? old('total_cost'):($assetModel->total_cost) }}" required="required" class="form-control col-md-7 col-xs-12">
   </div>
</div>
<!--div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Total Cost<span class="required">*</span>
   </label>
   <div class="col-md-3 col-sm-6 col-xs-12">
      <input type="number" min="0" id="first-name" name="net_value" value="{{ count($errors) > 0? old('net_value'):($assetModel->net_value) }}" required="required" class="form-control col-md-7 col-xs-12">
   </div>
</div-->
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Salvage Value<span class="required">*</span>
   </label>
   <div class="col-md-3 col-sm-6 col-xs-12">
      <input type="number" min="0" id="first-name" name="salvage_value" value="{{ count($errors) > 0? old('salvage_value'):($assetModel->salvage_value) }}" required="required" class="form-control col-md-7 col-xs-12">
   </div>
</div>
<!--div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12">Subject to Depreciation?</label>
   <div class="col-md-6 col-sm-6 col-xs-12">
      <div id="deprecChoice" class="btn-group" data-toggle="buttons">
         <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
         <input type="radio" name="subject_to_depreciation" value="No" data-parsley-multiple="gender">No
         </label>
         <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
         <input type="radio" name="subject_to_depreciation" value="Yes" data-parsley-multiple="gender"> Yes
         </label>
      </div>
   </div>
</div-->
<div class="form-group">
   <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Useful Life(mos)<span class="required">*</span></label>
   <div class="col-md-3 col-sm-6 col-xs-12">
      <input id="monthly_depreciation" name="useful_life" value="{{ count($errors) > 0? old('useful_life'):($assetModel->useful_life) }}" class="form-control col-md-7 col-xs-12" type="number" name="phone-number" min="1">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12">Mode of Acquisition</label>
   <div class="col-md-6 col-sm-6 col-xs-12">
      <div id="deprecChoice" class="btn-group" data-toggle="buttons">
         @if($assetModel->mode_of_acquisition!=NULL)
            @if($assetModel->mode_of_acquisition=='Cash')
               <label class="btn btn-default active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
               <input type="radio" name="mode_of_acquisition" value="Cash" data-parsley-multiple="gender" checked>Cash
               </label>
               <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
               <input type="radio" name="mode_of_acquisition" value="Payable" data-parsley-multiple="gender"> Payable
               </label>
               <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
               <input type="radio" name="mode_of_acquisition" value="Both" data-parsley-multiple="gender"> Both
               </label>
            @elseif($assetModel->mode_of_acquisition=='Payable')
               <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="mode_of_acquisition" value="Cash" data-parsley-multiple="gender">Cash
               </label>
               <label class="btn btn-default active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="mode_of_acquisition" value="Payable" data-parsley-multiple="gender" checked> Payable
               </label>
               <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
               <input type="radio" name="mode_of_acquisition" value="Both" data-parsley-multiple="gender"> Both
               </label>
            @elseif($assetModel->mode_of_acquisition=='Both')
               <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="mode_of_acquisition" value="Cash" data-parsley-multiple="gender">Cash
               </label>
               <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
               <input type="radio" name="mode_of_acquisition" value="Payable" data-parsley-multiple="gender"> Payable
               </label>
               <label class="btn btn-default active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
               <input type="radio" name="mode_of_acquisition" value="Both" data-parsley-multiple="gender" checked> Both
               </label>
            @endif
         @else
            <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
               <input type="radio" name="mode_of_acquisition" value="Cash" data-parsley-multiple="gender">Cash
            </label>
            <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
            <input type="radio" name="mode_of_acquisition" value="Payable" data-parsley-multiple="gender"> Payable
            </label>
            <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
            <input type="radio" name="mode_of_acquisition" value="Both" data-parsley-multiple="gender"> Both
            </label>
         @endif
      </div>
   </div>
</div>
<div id="downPayment" style="display:none;">
   <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Down Payment (PHP)
      </label>
      <div class="col-md-3 col-sm-6 col-xs-12">
         <input type="number" min="1" id="first-name" name="down_payment" value="{{ count($errors) > 0? old('down_payment'):($assetModel->down_payment) }}" class="form-control col-md-7 col-xs-12" >
      </div>
   </div>
</div>

<div class="ln_solid"></div>

<div class="form-group">
  <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
    <a href="{{route('assets.index')}}" class="btn btn-primary">Cancel</a>
    <button type="submit" class="btn btn-success">{{ $submitButton }}</button>
  </div>
</div>