<div class="form-group">
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input type="hidden" name="category" value="{{$category}}">
   </div>
</div>
<div class="form-group">
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input type="hidden" name="recordId" value="{{$recordId}}">
   </div>
</div>
@if(strpos($category,'report'))
<div class="form-group">
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input type="hidden" name="month_filter" value="{{$month_filter}}">
   </div>
   <div class="col-md-9 col-sm-6 col-xs-12">
      <input type="hidden" name="year_filter" value="{{$year_filter}}">
   </div>

   @if(isset($type))
      <div class="col-md-9 col-sm-6 col-xs-12">
         <input type="hidden" name="type" value="{{$type}}">
      </div>
   @endif
</div>
@endif
<!--button class="btn btn-default pull-right" onclick="window.print();"><i class="fa fa-print"></i> Print</button-->
<button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
