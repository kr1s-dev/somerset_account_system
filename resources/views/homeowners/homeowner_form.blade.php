<div class="form-group" align="center">
  @include('errors.validator')
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
   </label>
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input type="text" id="first-name" name="first_name" required="required" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('first_name'):($homeOwner->first_name) }}">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Middle Name <span class="required">*</span>
   </label>
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input type="text" id="last-name" name="middle_name" required="required" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('middle_name'):($homeOwner->middle_name) }}">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
   </label>
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input type="text" id="last-name" name="last_name" required="required" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('last_name'):($homeOwner->last_name) }}">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Member Occupation <span class="required">*</span>
   </label>
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input type="text" id="last-name" name="member_occupation" required="required" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('member_occupation'):($homeOwner->member_occupation) }}">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Residence Tel. No. <span class="required">*</span>
   </label>
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input type="text" id="last-name" name="residence_tel_no" required="required" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('residence_tel_no'):($homeOwner->residence_tel_no) }}">
   </div>
</div>
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Office Tel. No. <span class="required">*</span>
   </label>
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input type="text" id="last-name" name="member_office_tel_no" required="required" class="form-control col-md-7 col-xs-12" value="{{ count($errors) > 0? old('member_office_tel_no'):($homeOwner->member_office_tel_no) }}">
   </div>
</div>
<div class="form-group">
   <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile Number <span class="required">*</span></label>
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input id="middle-name" name="member_mobile_no" class="form-control col-md-7 col-xs-12" type="text" value="{{ count($errors) > 0? old('member_mobile_no'):($homeOwner->member_mobile_no) }}">
   </div>
</div>
<div class="form-group">
   <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input id="middle-name" name="member_email_address" class="form-control col-md-7 col-xs-12" type="text" value="{{ count($errors) > 0? old('member_email_address'):($homeOwner->member_email_address) }}">
   </div>
</div>
<!--div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12">Civil Status</label>
   <div class="col-md-6 col-sm-6 col-xs-12">
      <div id="gender" class="btn-group" data-toggle="buttons">
         <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
         <input type="radio" name="civil_status" value="male" data-parsley-multiple="gender"> &nbsp; Single &nbsp;
         </label>
         <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
         <input type="radio" name="civil_status" value="female" data-parsley-multiple="gender"> Married
         </label>
      </div>
   </div>
</div -->
<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
   <div class="col-md-6 col-sm-6 col-xs-12">
      <div id="gender" class="btn-group" data-toggle="buttons">
         <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
         <input type="radio" name="member_gender" value="Male" data-parsley-multiple="gender"> &nbsp; Male &nbsp;
         </label>
         <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
         <input type="radio" name="member_gender" value="Female" data-parsley-multiple="gender"> Female
         </label>
      </div>
   </div>
</div>

<div class="form-group">
   <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth <span class="required">*</span>
   </label>
   <div class="col-md-4 col-sm-4 col-xs-12">
      <input type="text"  id="birthday" name="member_date_of_birth" class="date-picker form-control col-md-7 col-xs-12" required="required" value="{{$homeOwner->member_date_of_birth}}"> 
   </div>
</div>
<div class="form-group">
   <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12">Address<span class="required">*</span></label>
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input id="address" name="member_address" class="form-control col-md-7 col-xs-12" type="text" name="phone-number" value="{{ count($errors) > 0? old('member_address'):($homeOwner->member_address) }}">
   </div>
</div>

<!--div class="col-md-12 col-sm-12 col-xs-12">
   <div class="x_panel">
      <div class="x_title">
         <h2><strong>Create a New Homeowner Member</strong> | Personal Information</h2>
         <ul class="nav navbar-right panel_toolbox">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
         </ul>
         <div class="clearfix"></div>
      </div>
      <div class="x_content">
         <div class="household-members">
            <div class="household-member">
               <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                     <input type="text" name="mem_first_name" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                     <input type="text" id="last-name" name="mem_last_name" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <div id="gender" class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="mem_gender" value="male" data-parsley-multiple="gender"> &nbsp; Male &nbsp;
                        </label>
                        <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                        <input type="radio" name="mem_gender" value="female" data-parsley-multiple="gender"> Female
                        </label>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth <span class="required">*</span>
                  </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                     <input id="birthday" name="mem_date_of_birth" class="date-picker form-control col-md-7 col-xs-12" required="required">
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Relationship<span class="required">*</span>
                  </label>
                  <div class="col-md-9 col-sm-6 col-xs-12">
                     <input type="text" id="last-name" name="mem_rel" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
               <button id="addAnother" class="btn btn-primary"><i class="fa fa-plus"></i> Add Another Household Member</button>
            </div>
         </div>
      </div>
   </div>
</div-->
<div class="form-group">
   <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
      <a href="{{ route('homeowners.show',$homeOwner->id) }}" type="submit" class="btn btn-primary">Cancel</a>
      <button type="submit" class="btn btn-success" id="testsubmit">{{ $submitButton }}</button>
   </div>
</div>
