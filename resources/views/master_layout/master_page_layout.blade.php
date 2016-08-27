<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Somerset Homeowners Management System | </title>
    <!-- Bootstrap -->
    <link href="{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ URL::asset('vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ URL::asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
    <!-- Fontawesome -->
    <link href="{{ URL::asset('vendors/fontawesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{ URL::asset('vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <!-- Bootstrap Daterangepicker -->
    <link rel="stylesheet" href="{{URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.css')}}">
    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('css/custom.css')}}" rel="stylesheet">
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="#" class="site_title"><i class="fa fa-home"></i> <span>Somerset Accounting System</span></a>
            </div>

            <div class="clearfix"></div>
            <br />

            <!-- sidebar menu -->
            @include('sidebar.admin_sidebar')
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            @include('footer.admin_menu_footer')
            <!-- /menu footer buttons -->
          </div>
        </div>
        <!-- top navigation -->
        @include('header.admin_top_navigator')
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main" style="height: 100vh;">
          @include('flash::message')
          @yield('content')
        </div>
        
        <!-- /page content -->

        <!-- footer content -->
        @include('footer.admin_footer')
        <!-- /footer content -->
      </div>
    </div>
    @include('scripts.admin_scripts')
  </body>
</html>