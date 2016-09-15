<br/><br/>
<div class="form-group" align="center">
  @include('errors.validator')
</div>

<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Account Title <span class="required">*</span>
  </label>
  <div class="col-md-9 col-sm-6 col-xs-12">
    <input type="hidden" name = "account_title_id" value="{{$eAccountTitle->id}}">
    <input name="account_title_name" value="{{ count($errors) > 0? old('account_title_name'):($eAccountTitle->account_sub_group_name) }}" type="text" class="form-control col-md-7 col-xs-12" readonly>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Item Name <span class="required">*</span>
  </label>
  <div class="col-md-9 col-sm-6 col-xs-12">
    <input name="item_name" value="{{ count($errors) > 0? old('item_name'):($item->item_name) }}" type="text" id="first-name" class="form-control col-md-7 col-xs-12" required="required">
  </div>
</div>
<div class="form-group" id="default_value_form">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Default Value
  </label>
  <div class="col-md-9 col-sm-6 col-xs-12">
    <input type="number" step="0.01" min="0" name="default_value" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('default_value'):($item->default_value) }}">
  </div>
</div>
<div class="form-group" id ="subject_to_vat_chckbox">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Subject to VAT
  </label>
  <div class="col-md-9 col-sm-6 col-xs-12" >
    @if($item->subject_to_vat)
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
   <input type="number" step="0.01" min="0" max="100" name="vat_percent" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('vat_percent'):(number_format($item->vat_percent,2)) }}">
  </div>
</div>

<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
  </label>
  <div class="col-md-9 col-sm-6 col-xs-12">
    <textarea name="remarks" class="form-control col-md-7 col-xs-12" cols="30" rows="5">{{ count($errors) > 0? old('remarks'):($item->remarks) }}</textarea>
  </div>
</div>
<div class="ln_solid"></div>

<div class="form-group">
  <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
    <a href="{{route('accounttitle.show',$eAccountTitle->id)}}" class="btn btn-primary">Cancel</a>
    <button type="submit" class="btn btn-success">{{ $submitButton }}</button>
  </div>
</div>