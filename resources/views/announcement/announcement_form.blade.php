<div class="form-group" align="center">
  @include('errors.validator')
</div>

<div class="form-group">
 	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Headline <span class="required">*</span>
 	</label>
 	<div class="col-md-9 col-sm-6 col-xs-12">
    	<input type="text" name="headline" id="first-name" value="{{ count($errors) > 0? old('headline'):($announcement->headline) }}" required="required" class="form-control col-md-7 col-xs-12">
 	</div>
</div>
<div class="form-group">
 	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Message <span class="required">*</span>
 	</label>
 	<div class="col-md-9 col-sm-6 col-xs-12">
    	<textarea name="message" class="form-control" id="" cols="30" rows="10">{{ count($errors) > 0? old('message'):($announcement->message) }}</textarea>
 	</div>
</div>

<div class="ln_solid"></div>

<div class="form-group">
	<div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
  		<a href="{{route('announcement.index')}}" class="btn btn-primary">Cancel</a>
  		<button type="submit" class="btn btn-success">{{$submitButton}}</button>
	</div>
</div>