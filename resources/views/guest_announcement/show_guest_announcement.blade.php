@extends('master_layout.master_guest_page_layout')
@section('content')
  <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3><i class="fa fa-bullhorn"></i> Announcements</h3>
        </div>
      </div>
      <div class="clearfix"></div>

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
                <h2>{{$announcement->headline}}</h2>
                <ul class="nav navbar-right panel_toolbox">
                      <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                </ul>
                <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- start accordion -->
            <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel">
                  <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <h4 class="panel-title">Announcement Information</h4>
                  </a>
                  <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="actions">
                            
                        </div>
                        <table class="table table-bordered">
                          <tbody>
                              <tr>
                                <td class="data-title"><strong>Headling</strong></td>
                                  <td>{{$announcement->headline}}</td>
                              </tr>
                              <tr>
                                  <td class="data-title"><strong>Message</strong></td>
                                  <td>{{$announcement->message}}</td>
                              </tr>
                          </tbody>
                        </table>
                    </div>
                  </div>
              </div>
            </div>
        </div>
        <!-- end of accordion -->
      </div>
  </div>
@endsection