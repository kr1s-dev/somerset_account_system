<div class="form-group" align="center">
  @include('errors.validator')
</div>
<div class="household-members">
   <div class="household-member">
      <div class="form-group">
         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Home Owner
         </label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <input type="hidden" name="home_owner_id" value="{{$ehomeOwnerInformation->id}}">
            <input type="text" value="{{$ehomeOwnerInformation->first_name}} {{$ehomeOwnerInformation->middle_name}} {{$ehomeOwnerInformation->last_name}}" id="first-name" required="required" class="form-control col-md-7 col-xs-12" readonly>
         </div>
      </div>
      <div class="form-group">
         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
         </label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <input type="text" name="first_name" value="{{ count($errors) > 0? old('first_name'):($nHomeOwnerMember->first_name) }}" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
         </div>
      </div>
      <div class="form-group">
         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Middle Name 
         </label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <input type="text" name="middle_name" value="{{ count($errors) > 0? old('middle_name'):($nHomeOwnerMember->middle_name) }}" id="first-name" class="form-control col-md-7 col-xs-12">
         </div>
      </div>
      <div class="form-group">
         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
         </label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <input type="text" id="last-name" name="last_name" value="{{ count($errors) > 0? old('last_name'):($nHomeOwnerMember->last_name) }}" required="required" class="form-control col-md-7 col-xs-12">
         </div>
      </div>
      <div class="form-group">
         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Occupation
         </label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <input type="text" id="last-name" name="companion_occupation" value="{{ count($errors) > 0? old('companion_occupation'):($nHomeOwnerMember->companion_occupation) }}" class="form-control col-md-7 col-xs-12">
         </div>
      </div>
      <div class="form-group">
         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Office Tel No.
         </label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <input type="text" id="last-name" name="companion_office_tel_no" value="{{ count($errors) > 0? old('companion_office_tel_no'):($nHomeOwnerMember->companion_office_tel_no) }}" class="form-control col-md-7 col-xs-12">
         </div>
      </div>
      <div class="form-group">
         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Mobile No.
         </label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <input type="text" id="last-name" name="companion_mobile_no" value="{{ count($errors) > 0? old('companion_mobile_no'):($nHomeOwnerMember->companion_mobile_no) }}" class="form-control col-md-7 col-xs-12">
         </div>
      </div>
      <div class="form-group">
         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email Address
         </label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <input type="text" id="last-name" name="companion_email_address" value="{{ count($errors) > 0? old('companion_email_address'):($nHomeOwnerMember->companion_email_address) }}" class="form-control col-md-7 col-xs-12">
         </div>
      </div>
      <div class="form-group">
         <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
         <div class="col-md-6 col-sm-6 col-xs-12">
            <div id="gender" class="btn-group" data-toggle="buttons">
               @if($nHomeOwnerMember->companion_gender!=NULL )
                  @if($nHomeOwnerMember->companion_gender=='Male')
                     <label class="btn btn-default active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                     <input type="radio" name="companion_gender" value="Male" data-parsley-multiple="gender" checked> &nbsp; Male &nbsp;
                     </label>
                     <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                     <input type="radio" name="companion_gender" value="Female" data-parsley-multiple="gender"> Female
                     </label>
                  @else
                     <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                     <input type="radio" name="companion_gender" value="Male" data-parsley-multiple="gender"> &nbsp; Male &nbsp;
                     </label>
                     <label class="btn btn-default active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                     <input type="radio" name="companion_gender" value="Female" data-parsley-multiple="gender" checked> Female
                     </label>
                  @endif
               @else
                  <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="companion_gender" value="Male" data-parsley-multiple="gender"> &nbsp; Male &nbsp;
                  </label>
                  <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                  <input type="radio" name="companion_gender" value="Female" data-parsley-multiple="gender"> Female
                  </label>
               @endif
            </div>
         </div>
      </div>
      <div class="form-group">   
         <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth <span class="required">*</span>
         </label>
         <div class="col-md-4 col-sm-4 col-xs-12">
            <input type="text"  id="birthday" name="companion_date_of_birth" class="date-picker form-control col-md-7 col-xs-12" required="required" value="{{ count($errors) > 0? old('companion_date_of_birth'):($nHomeOwnerMember->companion_date_of_birth) }}"> 
         </div>
      </div>
      <div class="form-group">
         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Relationship<span class="required">*</span>
         </label>
         <div class="col-md-9 col-sm-6 col-xs-12">
            <input type="text" id="last-name" value="{{ count($errors) > 0? old('relationship'):($nHomeOwnerMember->relationship) }}"  name="relationship" required="required" class="form-control col-md-7 col-xs-12">
         </div>
      </div>
   </div>
</div>
<div class="form-group">
   <div class="col-md-9 col-md-offset-3">
      <a href="{{route('homeowners.show',$ehomeOwnerInformation->id)}}" class="btn btn-primary">Cancel</a>
      <button type="submit" class="btn btn-success" id="testsubmit">{{ $submitButton }}</button>
   </div>
</div>
