<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <ul class="nav side-menu">
      @if(Auth::user()->userType->type == 'Administrator')
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard </a></li>
        <li><a href="{{route('map.somerset')}}"><i class="fa fa-dashboard"></i> Somerset Map </a></li>
        <li><a><i class="fa fa-bullhorn"></i> Announcements <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="{{ route('announcement.index') }}">View All Announcements</a></li>
            <li><a href="{{ route('announcement.create') }}">Create New Announcement</a></li>
          </ul>
        </li>
        <li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="{{ route('users.index') }}">View All Users</a></li>
            <li><a href="{{ route('users.create') }}">Create New User</a></li>
          </ul>
        </li>
        <li><a><i class="fa fa-home"></i> Homeowners <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="{{ route('homeowners.index') }}">View All Homeowners</a></li>
            <li><a href="{{ route('homeowners.create') }}">Create New Homeowner</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-table"></i> Accounts <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             <li><a href="{{ route('accounttitle.index') }}">View All Account Title</a></li>
             <li><a href="{{ route('account.index') }}">View Current Account</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-archive"></i> Assets Registry<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             <li><a href="{{ route('assets.create') }}">Create Assets</a></li>
             <li><a href="{{ route('assets.index') }}">View All Assets</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-files-o"></i> Invoice <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             <li><a href="{{ route('invoice.create') }}">Create New Invoice</a></li>
             <li><a href="{{ route('invoice.index') }}">View All Invoices</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-money"></i> Receipts <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             <li><a href="{{ route('receipt.index') }}">View All Receipts</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-shopping-basket"></i> Vendors <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="{{ route('vendor.create') }}">Create New Vendor</a></li>
            <li><a href="{{ route('vendor.index') }}">View All Vendors</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-credit-card"></i> Cash Vouchers <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="{{ route('expense.create') }}">Create New Cash Voucher</a></li>
            <li><a href="{{ route('expense.index') }}">View All Vouchers</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-file-text"></i> Reports <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <!--li><a href="">General Journal</a></li>
            <li><a href="">General Ledger</a></li-->
            <li><a href="{{ route('incomestatement') }}">Income Statement</a></li>
            <li><a href="{{ route('ownersequity') }}">Statement of Owners Equity</a></li>
            <li><a href="{{ route('balancesheet') }}">Balance Sheet</a></li>
            <li><a href="{{ route('subledger','homeowner') }}">Subsidiary Ledger (Home Owner)</a></li>
            <li><a href="{{ route('subledger','vendor') }}">Subsidiary Ledger (Vendor Data)</a></li>
            <li><a href="{{ route('asset.registry') }}">Asset Registry</a></li>
            <li><a href="{{ route('cash.flow')}}">Statement of Cash Flow</a></li>
            <!--li><a href="">Balance Sheet</a></li>
            <li><a href="">Trial Balance</a></li-->
          </ul>
        </li>
      
      @elseif(Auth::user()->userType->type == 'Cashier' || Auth::user()->userType->type == 'Administrator')
        <li><a><i class="fa fa-home"></i> Homeowners <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="{{ route('homeowners.index') }}">View All Homeowners</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-files-o"></i> Invoice <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             <li><a href="{{ route('invoice.create') }}">Create New Invoice</a></li>
             <li><a href="{{ route('invoice.index') }}">View All Invoices</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-money"></i> Receipts <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             <!--li><a href="{{ route('receipt.create') }}">Create New Receipt</a></li-->
             <li><a href="{{ route('receipt.index') }}">View All Receipts</a></li>
          </ul>
        </li>
      @elseif(Auth::user()->userType->type == 'Accountant' || Auth::user()->userType->type == 'Administrator')
        <li>
          <a><i class="fa fa-table"></i> Accounts <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             <li><a href="{{ route('accounttitle.index') }}">View All Account Title</a></li>
             <li><a href="{{ route('account.index') }}">View Current Account</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-archive"></i> Assets Registry<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             <li><a href="{{ route('assets.create') }}">Create Assets</a></li>
             <li><a href="{{ route('assets.index') }}">View All Assets</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-files-o"></i> Invoice <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             <li><a href="{{ route('invoice.create') }}">Create New Invoice</a></li>
             <li><a href="{{ route('invoice.index') }}">View All Invoices</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-money"></i> Receipts <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
             <!--li><a href="{{ route('receipt.create') }}">Create New Receipt</a></li-->
             <li><a href="{{ route('receipt.index') }}">View All Receipts</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-shopping-basket"></i> Vendors <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="{{ route('vendor.create') }}">Create New Vendor</a></li>
            <li><a href="{{ route('vendor.index') }}">View All Vendors</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-credit-card"></i> Cash Vouchers <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="{{ route('expense.create') }}">Create New Cash Voucher</a></li>
            <li><a href="{{ route('expense.index') }}">View All Vouchers</a></li>
          </ul>
        </li>
        <li>
          <a><i class="fa fa-credit-card"></i> Reports <span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <!--li><a href="">General Journal</a></li>
            <li><a href="">General Ledger</a></li-->
            <li><a href="{{ route('incomestatement') }}">Income Statement</a></li>
            <li><a href="{{ route('ownersequity') }}">Statement of Owners Equity</a></li>
            <li><a href="{{ route('balancesheet') }}">Balance Sheet</a></li>
            <li><a href="{{ route('subledger','homeowner') }}">Subsidiary Ledger (Home Owner)</a></li>
            <li><a href="{{ route('subledger','vendor') }}">Subsidiary Ledger (Vendor Data)</a></li>
            <li><a href="{{ route('asset.registry') }}">Asset Registry</a></li>
            <li><a href="{{ route('cash.flow')}}">Statement of Cash Flow</a></li>
            <!--li><a href="">Balance Sheet</a></li>
            <li><a href="">Trial Balance</a></li-->
          </ul>
        </li>
      @endif
      </ul>
    </ul>
  </div>
</div>