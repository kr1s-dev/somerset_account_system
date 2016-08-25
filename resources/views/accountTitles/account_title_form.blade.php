<br/><br/>
<div class="form-group" align="center">
  @include('errors.validator')
</div>
@if(!is_null($eAccountTitle->id))
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Parent Account Title <span class="required">*</span>
    </label>
    <div class="col-md-9 col-sm-6 col-xs-12">
      <input type="hidden" name = "account_title_id" value="{{$eAccountTitle->id}}">
      <input type="hidden" name="account_group_id" value="{{$eAccountTitle->group->id}}">
      <input name="account_title_name" value="{{ count($errors) > 0? old('account_title_name'):($eAccountTitle->account_sub_group_name) }}" type="text" class="form-control col-md-7 col-xs-12" readonly>
    </div>
  </div>
@else 
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Parent Group <span class="required">*</span>
    </label>
    <div class="col-md-9 col-sm-6 col-xs-12">
      @if(count($accountGroupList) == 1)
        <input type="hidden" name="account_group_id" value="{{$accountGroupList->id}}">
        <select id="accountgroup" class="select2_single form-control" tabindex="-1" disabled>
          <option value="{{$accountGroupList->id}}">{{$accountGroupList->account_group_name}}</option>
        </select>
      @else
        <select id="accountgroup" name="account_group_id" class="select2_single form-control" tabindex="-1">
          @foreach($accountGroupList as $key => $value)
            <option value="{{$key}}">{{$value}}</option>
          @endforeach
        </select>
      @endif
    </div>
  </div>
@endif

<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Account Title <span class="required">*</span>
  </label>
  <div class="col-md-9 col-sm-6 col-xs-12">
    <input name="account_sub_group_name" value="{{ count($errors) > 0? old('account_sub_group_name'):($accountTitle->account_sub_group_name) }}" type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" required="required" placeholder="Account Title (e.g Accounts Receivable)">
  </div>
</div>
<div class="form-group" id="opening_balance_form" style="display:none;">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Opening Balance
  </label>
  <div class="col-md-9 col-sm-6 col-xs-12">
     <input name="opening_balance" min="0" value="{{ count($errors) > 0? old('opening_balance'):($accountTitle->opening_balance) }}" type="number" step="0.01" id="first-name" class="form-control col-md-7 col-xs-12" placeholder="Opening Balance">
  </div>
</div>
<!--div class="form-group" id="default_value_form" style="display:none;">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Default Value
  </label>
  <div class="col-md-9 col-sm-6 col-xs-12">
    <input type="number" step="0.01" min="0" name="default_value" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('default_value'):($accountTitle->default_value) }}">
  </div>
</div>
<div class="form-group" id ="subject_to_vat_chckbox" style="display:none;">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Subject to VAT
  </label>
  <div class="col-md-9 col-sm-6 col-xs-12" >
    @if($accountTitle->subject_to_vat)
      <input type="checkbox" name="subject_to_vat" checked>
    @else
      <input type="checkbox" name="subject_to_vat">
    @endif
  </div>
</div>
<div class="form-group" id ="vat_percent_form" style="display:none;">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">VAT Percent
  </label>
  <div class="col-md-9 col-sm-6 col-xs-12" >
   <input type="number" step="0.01" min="0" name="vat_percent" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('vat_percent'):($accountTitle->vat_percent) }}">
  </div>
</div-->

<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
  </label>
  <div class="col-md-9 col-sm-6 col-xs-12">
    <textarea name="description" class="form-control col-md-7 col-xs-12" cols="30" rows="5">{{ count($errors) > 0? old('description'):($accountTitle->description) }}</textarea>
  </div>
</div>
<div class="ln_solid"></div>

<div class="form-group">
  <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
    <a href="{{route('accounttitle.index')}}" class="btn btn-primary">Cancel</a>
    <button type="submit" class="btn btn-success">{{ $submitButton }}</button>
  </div>
</div>