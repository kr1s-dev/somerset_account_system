<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Asset No. <span class="required">*</span>
   </label>
   <div class="col-md-3 col-sm-6 col-xs-12">
      <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description <span class="required">*</span>
   </label>
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Date Acquired <span class="required">*</span>
   </label>
   <div class="col-md-3 col-sm-6 col-xs-12">
      <input id="" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Original Cost<span class="required">*</span>
   </label>
   <div class="col-md-3 col-sm-6 col-xs-12">
      <input type="number" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12">Subject to Depreciation?</label>
   <div class="col-md-6 col-sm-6 col-xs-12">
      <div id="gender" class="btn-group" data-toggle="buttons">
         <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
         <input type="radio" name="gender" value="male" data-parsley-multiple="gender"> &nbsp; No  &nbsp;
         </label>
         <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
         <input type="radio" name="gender" value="female" data-parsley-multiple="gender"> Yes
         </label>
      </div>
   </div>
</div>
<div class="form-group">
   <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Depreciation Percentage (%) <span class="required">*</span></label>
   <div class="col-md-3 col-sm-6 col-xs-12">
      <input id="middle-name" class="form-control col-md-7 col-xs-12" type="number" name="phone-number">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Carrying Amount<span class="required">*</span>
   </label>
   <div class="col-md-3 col-sm-6 col-xs-12">
      <input type="number" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
   </div>
</div>
<div class="ln_solid"></div>

<div class="form-group">
  <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
    <a role="button" href="./list.html" class="btn btn-primary">Cancel</a>
    <button type="submit" class="btn btn-success">{{ $submitButton }}</button>
  </div>
</div>