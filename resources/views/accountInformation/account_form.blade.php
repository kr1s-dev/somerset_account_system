<div class="form-group" align="center">
  @include('errors.validator')
</div>
<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Account Name<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-6 col-xs-12">
		<input type="text" name="account_name" id="first-name" value="{{ count($errors) > 0? old('account_name'):($nAccountDetail->account_name) }}" required="required" class="form-control col-md-7 col-xs-12">
	</div>
</div>
<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Accounting Year Start Date<span class="required">*</span>
	</label>
	<div class="col-md-4 col-sm-4 col-xs-12">
		<input id="start-date" name="accounting_year_start_date" value="{{ count($errors) > 0? old('accounting_year_start_date'): date('m-d-Y',strtotime($nAccountDetail->accounting_year_start_date)) }}" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
	</div>
</div>
<!--div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Accounting Year End Date<span class="required">*</span>
	</label>
	<div class="col-md-4 col-sm-4 col-xs-12">
		<input id="end-date" name="accounting_year_end_date" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
	</div>
  </div-->
<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">
		O/P Balance<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-6 col-xs-12">
		<input type="number" step="0.01" name="o_p_balance" value="{{ count($errors) > 0? old('o_p_balance'):($nAccountDetail->o_p_balance) }}" id="op-balance" required="required" class="form-control col-md-7 col-xs-12">
	</div>
</div>
<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">
		C/L Balance<span class="required">*</span>
	</label>
	<div class="col-md-3 col-sm-3 col-xs-12">
		<input type="number" name="c_l_balance" value="{{ count($errors) > 0? old('c_l_balance'):($nAccountDetail->c_l_balance) }}" id="op-balance" required="required" class="form-control col-md-7 col-xs-12" readonly>
	</div>
	<label class="control-label col-md-3 col-sm-3 col-xs-12">
		Get C/L Balance From<span class="required">*</span>
	</label>
	<div class="col-md-3 col-sm-3 col-xs-12">
		@if($isCreate)
			<select id="c_l_balance_from_account_id" class="select2_single form-control" tabindex="-1">
	 			<option></option>
	 			@foreach($eAccountDetailsList as $eAccountDetail)
		            <option value="{{$eAccountDetail->id}}">{{$eAccountDetail->account_name}}</option>
		         @endforeach
				</select>
		@else
			<input type="text" name="c_l_balance_from_account_id" value="{{ count($errors) > 0? old('c_l_balance_from_account_id'):($nAccountDetail->c_l_balance_from_account_id) }}" id="op-balance" required="required" class="form-control col-md-7 col-xs-12" readonly>
		@endif
	</div>
</div>
<div class="form-group">
   <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
      <a href="{{ route('account.show',$nAccountDetail->id) }}" type="submit" class="btn btn-primary">Cancel</a>
      <button type="submit" class="btn btn-success" id="testsubmit">{{ $submitButton }}</button>
   </div>
</div>