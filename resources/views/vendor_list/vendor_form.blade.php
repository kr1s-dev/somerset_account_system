<br/><br/>
<div class="form-group" align="center">
  @include('errors.validator')
</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Vendor Name<span class="required">*</span>
    </label>
    <div class="col-md-3 col-sm-6 col-xs-12">
		<input type="text" id="first-name" name="vendor_name" required="required" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('vendor_name'):($vendor->vendor_name) }}">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description <span class="required">*</span>
    </label>
    <div class="col-md-9 col-sm-6 col-xs-12">
        <input type="text" id="first-name" name="vendor_description" required="required" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('vendor_description'):($vendor->vendor_description) }}">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mobile Number <span class="required">*</span>
     </label>
    <div class="col-md-9 col-sm-6 col-xs-12">
        <input type="number" id="first-name" name="vendor_mobile_no" required="required" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('vendor_mobile_no'):($vendor->vendor_mobile_no) }}">
    </div>
  </div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Telephone Number
     </label>
    <div class="col-md-9 col-sm-6 col-xs-12">
        <input type="number" id="first-name" name="vendor_telephone_no" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('vendor_telephone_no'):($vendor->vendor_telephone_no) }}">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email <span class="required">*</span>
    </label>
    <div class="col-md-9 col-sm-6 col-xs-12">
       <input type="email" id="first-name" name="vendor_email_address" required="required" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('vendor_email_address'):($vendor->vendor_email_address) }}">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Contact Person <span class="required">*</span>
    </label>
    <div class="col-md-9 col-sm-6 col-xs-12">
       <input type="text" id="first-name" required="required" name="vendor_contact_person" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('vendor_contact_person'):($vendor->vendor_contact_person) }}">
    </div>
</div>
<div class="ln_solid"></div>

<div class="form-group">
    <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
      <a role="button" href="{{route('vendor.index')}}" class="btn btn-primary">Cancel</a>
      <button type="submit" class="btn btn-success">{{$submitButton}}</button>
    </div>
</div>
