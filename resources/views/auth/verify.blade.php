@extends('master_layout.master_auth_layout')
@section('content')
<div>
	<div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            {!! Form::open(['url'=>'auth/verify','method'=>'POST']) !!}
              <h1>Verification Form</h1>
              @include('errors.validator')
              <div>
                <input type="hidden" class="form-control" name="userid" value="{{$user->id}}"/>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-12 col-sm-12 col-xs-12">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password"/>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-12 col-sm-12 col-xs-12">Confirm Password</label>
                <input type="password" class="form-control" name="confirmation_password" placeholder="Confirm Password"/>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-12 col-sm-12 col-xs-12">Secret Question</label>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <select name="secret_question_id" class="select2_single form-control" tabindex="-1" id="howeOwnersList">
                    @if(count($secretQuestions))
                      @foreach($secretQuestions as $secretQuestion)
                        <option value="{{$secretQuestion->id}}" name="secret_question_id">
                          {{$secretQuestion->secret_question}}
                        </option>
                      @endforeach
                    @endif
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;">Answer</label>
                <input type="text" class="form-control" name="secret_answer" placeholder="Answer"/>
              </div>
              <div class="form-group" >
                <input type="submit" class="btn btn-default submit pull-right" value="Confirm" style="margin-top:10px;">
              </div>

              <div class="clearfix"></div>
              <div class="separator">
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1><i class="fa fa-home"></i> Somerset Homeowners Management System</h1>
                  <p>©2016 All Rights Reserved. </p>
                </div>
              </div>
            {!! Form::close() !!}
          </section>
        </div>
      </div>
    </div>
</div>
@endsection