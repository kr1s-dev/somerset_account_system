<br/><br/>
<div class="form-group" align="center">
  @include('errors.validator')
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Group Name <span class="required">*</span>
  </label>
  <div class="col-md-9 col-sm-6 col-xs-12">
    <input name="account_group_name" value="{{ count($errors) > 0? old('account_group_name'):($accountGroup->account_group_name) }}" type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" required="required" placeholder="Account Group Name (e.g Assets)">
  </div>
</div>
<div class="form-group">
  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
  </label>
  <div class="col-md-9 col-sm-6 col-xs-12">
    <textarea name="description" class="form-control col-md-7 col-xs-12" cols="30" rows="5">{{ count($errors) > 0? old('description'):($accountGroup->description) }}</textarea>
  </div>
</div>

<div class="ln_solid"></div>

<div class="form-group">
  <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
    <a href="" class="btn btn-primary">Cancel</a>
    <button type="submit" class="btn btn-success">{{ $submitButton }}</button>
  </div>
</div>