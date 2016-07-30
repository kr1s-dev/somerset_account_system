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
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Quantity <span class="required">*</span>
   </label>
   <div class="col-md-3 col-sm-6 col-xs-12">
      <input type="number" id="first-name" name="quantity" value="{{ count($errors) > 0? old('quantity'):($assetModel->quantity) }}" required="required" class="form-control col-md-7 col-xs-12">
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
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Date Acquired <span class="required">*</span>
   </label>
   <div class="col-md-3 col-sm-6 col-xs-12">
      <input id="" name="date_acquired" value="{{ count($errors) > 0? old('date_acquired'):($assetModel->date_acquired) }}" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Original Cost<span class="required">*</span>
   </label>
   <div class="col-md-3 col-sm-6 col-xs-12">
      <input type="number" id="first-name" name="original_cost" value="{{ count($errors) > 0? old('original_cost'):($assetModel->original_cost) }}" required="required" class="form-control col-md-7 col-xs-12">
   </div>
</div>
@if($submitButton == 'Update Asset')
   <input type="hidden" name="subject_to_depreciation" value="{{ count($errors) > 0? old('subject_to_depreciation'):($assetModel->subject_to_depreciation) }}" >
   @if($assetModel->subject_to_depreciation)
      <div id="depreDetails">
         <div class="form-group">
            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Monthly Depreciation<span class="required">*</span></label>
            <div class="col-md-3 col-sm-6 col-xs-12">
               <input id="monthly_depreciation" name="monthly_depreciation" value="{{ count($errors) > 0? old('monthly_depreciation'):($assetModel->monthly_depreciation) }}" class="form-control col-md-7 col-xs-12" type="number" name="phone-number">
            </div>
         </div>
      </div>
   @endif
@else
   <div class="form-group">
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
   </div>
   <div id="depreDetails" style="display:none;">
      <div class="form-group">
         <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Monthly Depreciation<span class="required">*</span></label>
         <div class="col-md-3 col-sm-6 col-xs-12">
            <input id="monthly_depreciation" name="monthly_depreciation" value="{{ count($errors) > 0? old('monthly_depreciation'):($assetModel->monthly_depreciation) }}" class="form-control col-md-7 col-xs-12" type="number" name="phone-number">
         </div>
      </div>
   </div>
@endif

<div class="ln_solid"></div>

<div class="form-group">
  <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
    <a role="button" href="./list.html" class="btn btn-primary">Cancel</a>
    <button type="submit" class="btn btn-success">{{ $submitButton }}</button>
  </div>
</div>