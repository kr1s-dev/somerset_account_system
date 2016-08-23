<!-- jQuery -->
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{ URL::asset('vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ URL::asset('vendors/fastclick/lib/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{ URL::asset('vendors/nprogress/nprogress.js')}}"></script>
<!-- Data Tables -->
<script src="{{ URL::asset('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
 <!-- Select2 -->
<script src="{{ URL::asset('vendors/select2/dist/js/select2.full.min.js')}}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ URL::asset('vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- Custom Theme Scripts -->
<script src="{{ URL::asset('js/custom.js')}}"></script>
<script>
  $(document).ready(function(){
      var exTableRowIndex;
      var arrayTd;

      if($('#accountgroup option:selected').text() == 'Revenues' || $('input[name="account_group_name"]').val() == 'Revenues'){
        $('#subject_to_vat_chckbox').show();
        $('#default_value_form').show();
        $('#opening_balance_form').hide();
      }

      if($("input[name='subject_to_vat']").is(':checked'))
        $('#vat_percent_form').show();
        

      $("input[name='subject_to_vat']").change(function() {
        if(this.checked)
          $('#vat_percent_form').show();
        else
          $('#vat_percent_form').hide();
      }); 

      
      if($('#accountgroup option:selected').text().toLowerCase().indexOf('assets') >= 0 || 
          $('#accountgroup option:selected').text().toLowerCase().indexOf('liabilities') >= 0 || 
          $('#accountgroup option:selected').text().toLowerCase().indexOf('equity') >= 0){
        $('#opening_balance_form').show();
        $('#default_value_form').hide();
      }
      

      $('#datatable').dataTable();
      $(".select2_single").select2({
          placeholder: "Select a homeowner",
          allowClear: true
      });

      /*
      * @Author:      Kristopher N. Veraces
      * @Description: Auto Populate User Fields if user have homewoner related with.
      * @Date:        6/27/2016
      */
      $('#howeOwnersList').on('change',function(){
        var selectOptionVal = $( "#howeOwnersList option:selected" ).attr('name');
        console.log(selectOptionVal);
        var jsonParse;
        $('#first_name').val('') ;
        $('#last_name').val('') ;
        $('#middle_name').val('') ;
        $('#mobile_number').val('') ;
        $('#email').val('');
        if(!$.isEmptyObject(selectOptionVal)){
          jsonParse = JSON.parse(selectOptionVal);
          $('#first_name').prop('readonly', true);
          $('#last_name').prop('readonly', true);
          $('#middle_name').prop('readonly', true);
          $('#mobile_number').prop('readonly', true);
          $('#email').prop('readonly', true);
          $('#first_name').val(jsonParse.first_name) ;
          $('#last_name').val(jsonParse.last_name) ;
          $('#middle_name').val(jsonParse.middle_name) ;
          $('#mobile_number').val(jsonParse.member_mobile_no) ;
          $('#email').val(jsonParse.member_email_address);
        }else{
          $('#first_name').prop('readonly', false);
          $('#last_name').prop('readonly', false);
          $('#middle_name').prop('readonly', false);
          $('#mobile_number').prop('readonly', false);
          $('#email').prop('readonly', false);
        }
      });

      $('#birthday').daterangepicker({
        singleDatePicker: true,
        calender_style: "picker_1"
      });

      $('.datepicker').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
      });
      
      $('.date-picker').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
        });

      /*
      * @Author:      Kristopher N. Veraces
      * @Description: Resetting value in modal
      * @Date:        6/29/2016
      */
      $("#addItemRow").click(function(e){
        e.preventDefault();
        $('#nPaymentItem').select2("val", "");
        $('#nPaymentDesc').val('');
        $('#nPaymentCost').val('')
      });

      /*
      * @Author:      Kristopher N. Veraces
      * @Description: Adding table data in invoice 
      * @Date:        6/29/2016
      */
      $("#nPaymentBtn").click(function(e){
        e.preventDefault();
        var paymentType = $('#nPaymentItem option:selected').text();
        var paymentDesc = $('#nPaymentDesc').val();
        var nPaymentCost = $('#nPaymentCost').val()?$('#nPaymentCost').val():0;
        var errorMessage = '';
        var hasDuplicate = false;
        var tdTableData;

        //Checks if inputted correct data / or is not null
        if(paymentType && nPaymentCost && nPaymentCost > 0){
          var table = $('#itemsTable tbody');
          table.find('tr').each(function(rowIndex, r){
            $(this).find('td').each(function (colIndex, c) {
              console.log('Enter 2nd loop' + c.textContent);
              if(c.textContent==paymentType.trim()){
                hasDuplicate = true;
                tdTableData = $(this).closest('tr');
                return false;
              }

            });
              //data+= (tData.substring(0,tData.length - 1) + '|');
          });
          
          //tdTableData[2].textContent = Integer.parseInt(tdTableDate[2].textContent) + nPaymentCost;
          if(!hasDuplicate){
            $('#itemsTable tbody').append( '<tr>' +
              '<td>'+paymentType.trim()+'</td>' +
              '<td>'+ paymentDesc.trim() +'</td>' +
              '<td>'+ nPaymentCost.trim() +'</td>' +
              '<td><button class="btn btn-default edit-item" id="editTrans" data-toggle="modal" data-target="#myModalEdit"><i class="fa fa-pencil"></i></button> <button class="btn btn-default delete-item"><i class="fa fa-times"></i></button></td>' +
              '</tr>');
          }else{
            tdTableData = tdTableData.find('td');
            tdTableData[2].textContent = (parseFloat(tdTableData[2].textContent.trim()) + parseFloat(nPaymentCost));
          }
          calculateAmount();
          return true;
        }else{
          if(!paymentType)
            errorMessage+='\nNo Payment Type';
          if(!nPaymentCost){
            errorMessage+='\nNo Payment Cost';
            if(nPaymentCost < 0);
              errorMessage+='\nPayment cost must be a positive number';
          }
          
          alert('Invalid Data:' + errorMessage);
          return false;
        }
        
      });

      $('.items-wrapper').on('click', '.delete-item', function(){
          $(this).parent().parent().remove();
          calculateAmount();
        });

      /*
      * @Author:      Kristopher N. Veraces
      * @Description: Creating AJAX call to laravel for insertion 
      *               of record in invoice and related items
      * @Date:        6/29/2016
      * @Note:        Add validation if duplicate item is inputted
      */
      $("#createInvBtn").click(function(e){
          var data='';
          var tData = '';
          var totalAmount = 0;
          var paymentDueDate = $('#paymentDueDate').val();
          
          //Retrieving token for request
          var _token = $('meta[name="csrf-token"]').attr('content');
          console.log(_token);

          // //Retrieving account detail
          // var accountDetailId = $( "#cashier" ).val();

          //Retrieving homeownerid for insertion of record
          var homeOwnerId = $("#homeowners option:selected" ).val();
          
          if(homeOwnerId){
            if(paymentDueDate >=  getTodaysDate()){
              var table = $('#itemsTable tbody');
              //Get all data in the table
              table.find('tr').each(function(rowIndex, r){
                //var cols = [];
                console.log('Enter 1st loop');
                $(this).find('td').each(function (colIndex, c) {
                  console.log('Enter 2nd loop' + c.textContent);
                  if(c.textContent!=' ')
                    data+=(c.textContent+',');
                  });
                  //data+= (tData.substring(0,tData.length - 1) + '|');
              });
              data = data.substring(0,data.length - 1);
              console.log(data);
              //Retrieving total amount of invoice
              $("#amountCalc tbody td").each(function(){
                totalAmount = parseFloat(($(this).text().replace('PHP ','').trim()));
              });
              console.log(totalAmount + ' ' + homeOwnerId + ' ' + paymentDueDate);
              if(data){
                //Creating an ajax request to the server
                $.ajax({
                  headers: {
                      'X-CSRF-TOKEN': _token
                  },
                  url: '/invoice',
                  type: 'POST',
                  data: { 'data':data,
                          'homeownerid': homeOwnerId,
                          'totalAmount': totalAmount,
                          'paymentDueDate': paymentDueDate},
                  success: function(response)
                  {
                    //alert(response);
                    location.href="/invoice/"+response;
                  }, error: function(xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                  }
                });
              }else{
                alert('Please Input data into table.');
              }
            }else{
              alert('Payment Due Date must be greater than or equal today');
            }
          }else{
            alert('Must choose an Associated Homeowner');
          }
          
      });
      
      /*
      * @Author:      Kristopher N. Veraces
      * @Description: Get table row data in table after clicking edit button.
      *               Transfer data to modal to update
      * @Date:        6/29/2016
      * @Note:        Add validation if duplicate item is inputted
      */
       $('#itemsTable').on( 'click', '#editTrans', function(event){
        var tr = $(this).closest('tr'); //get the parent tr
        arrayTd = $(tr).find('td'); //get data in a row
        $("#ePaymentItem").val((arrayTd[0].textContent).trim());
        $("#ePaymentDesc").val((arrayTd[1].textContent).trim());
        $("#ePaymentCost").val((arrayTd[2].textContent).trim());
      });

      /*
      * @Author:      Kristopher N. Veraces
      * @Description: Update data in table after clicking update in modal.
      * @Date:        6/29/2016
      * @Note:        If value is empty or invalid, it will revert back to its original value
      */
      $("#ePaymentBtn").click(function(e){
        e.preventDefault();
        if($('#ePaymentItem option:selected').text()){
          arrayTd[0].textContent = $('#ePaymentItem option:selected').text();
        }

        if($('#ePaymentDesc').val()){
          arrayTd[1].textContent = $('#ePaymentDesc').val();
        }

        if($('#ePaymentCost').val()){
          arrayTd[2].textContent = $('#ePaymentCost').val();
        }
        calculateAmount();
      });

      /*
      * @Author:      Kristopher N. Veraces
      * @Description: Calculates total amount of all the items listed in the table
      * @Date:        6/29/2016
      * @Note:        If value is empty or invalid, it will revert back to its original value
      */
      function calculateAmount(){
        var total = 0;
        //Get all amount in the table
        $("#itemsTable tbody td:nth-child(3)").each(function() {
            total += parseFloat($(this).text());
        });
        
        //Putting the total amount in another table for viewing
        $("#amountCalc tbody td").each(function(){
          $(this).text('PHP ' + total);
        });
      }


      /*
      * @Author:      Kristopher N. Veraces
      * @Description: Creating AJAX call to laravel for insertion 
      *               of record in expense and related items
      * @Date:        6/29/2016
      * @Note:        Add validation if duplicate item is inputted
      */
      $("#createExpBtn").click(function(e){
          var data='';
          var totalAmount = 0;
          var paidTo = $('#paid_to').val();
          //Retrieving token for request
          var _token = $('meta[name="csrf-token"]').attr('content');
          var vendorId = $('#vendor_id').val();
          var type = $("input[name=type]:checked").val();
          console.log(type);
          console.log(paidTo.trim());
          console.log(vendorId);
          if((type=='Non-Vendor' && paidTo.trim()) || (type=='Vendor' && vendorId)){
            var table = $('#itemsTable tbody');
            //Get all data in the table
            table.find('tr').each(function(rowIndex, r){
              $(this).find('td').each(function (colIndex, c) {
                if(c.textContent!=' ')
                  data+=(c.textContent+',');
                });
                //data+= (tData.substring(0,tData.length - 1) + '|');
            });
            data = data.substring(0,data.length - 1);
            console.log(data);
            //Retrieving total amount of Expense
            $("#amountCalc tbody td").each(function(){
              totalAmount = parseFloat(($(this).text().replace('PHP ','').trim()));
            });
            console.log(totalAmount);
            if(data){
              //Creating an ajax request to the server
              $.ajax({
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                url: '/expense',
                type: 'POST',
                data: { 'data':data,
                        'vendorId':vendorId,
                        'paidTo': paidTo,
                        'totalAmount': totalAmount,
                        'type':type},
                success: function(response)
                {
                    //alert(response);
                    location.href="/expense/"+response;
                }, error: function(xhr, ajaxOptions, thrownError){
                  alert(xhr.status);
                  alert(thrownError);
                }
              });
            }else{
              alert('Please Input data into table.');
            }
          }else{
            alert('Must input which Company/HomeOwner will receive the cash voucher');
          }
      });
      
      /*
      * @Author:      Kristopher N. Veraces
      * @Description: Creating AJAX call to laravel for update 
      *               of record in invoice and its related items
      * @Date:        6/29/2016
      * @Note:        Add validation if duplicate item is inputted
      */
      $("#updateInvBtn").click(function(e){
        var data='';
        var tData = '';
        var totalAmount = 0;
        var count=0;
        //Retrieving token for request
        var _token = $('meta[name="csrf-token"]').attr('content');

        //Retrieveing id of record for updating
        var _id = $('meta[name="invoice-id"]').attr('content');

        var paymentDueDate = $('#paymentDueDate').val();

        var table = $('#itemsTable tbody');
        //Get all data in the table
        table.find('tr').each(function(rowIndex, r){
          count=0;
          tData = '';
          //var cols = [];
          console.log('Enter 1st loop');
          $(this).find('td').each(function (colIndex, c) {
            count++;
            if(count<4){
              data+=(c.textContent+',');
            }
            });
          //data+= (tData.substring(0,tData.length - 1) + '|');
        });
        data = data.substring(0,data.length - 1);
        console.log(data);
        //Retrieving total amount of invoice
        $("#amountCalc tbody td").each(function(){
          totalAmount = parseFloat(($(this).text().replace('PHP ','').trim()));
        });
        console.log(totalAmount);
        if(paymentDueDate >=  getTodaysDate()){
          if(data){
            //Creating an ajax request to the server
            $.ajax({
              headers: {
                  'X-CSRF-TOKEN': _token
              },  
              url: '/invoice/'+_id,
              type: 'PUT',
              data: { 'data':data,
                      'paymentDueDate':paymentDueDate,
                      'totalAmount': totalAmount},
              success: function(response)
              {
                  //alert(response);
                  location.href="/invoice/"+_id;
              }, error: function(xhr, ajaxOptions, thrownError){
                alert(xhr.status);
                alert(thrownError);
              }
            });
          }else{
            alert('Please Input data into table.');
          }
        }else{
          alert('Payment Due Date must be greater than or equal today');
        }
        
      });

      /*
      * @Author:      Kristopher N. Veraces
      * @Description: Creating AJAX call to laravel for update 
      *               of record in expense and its related items
      * @Date:        6/29/2016
      * @Note:        Add validation if duplicate item is inputted
      */
      $("#updateExpBtn").click(function(e){
        var data='';
        var tData = '';
        var totalAmount = 0;
        var count=0;
        //Retrieving token for request
        var _token = $('meta[name="csrf-token"]').attr('content');

        //Retrieveing id of record for updating
        var _id = $('meta[name="expense-id"]').attr('content');

        //Get company that receives the voucher
        var paidTo = $('#paid_to').val();

        var vendorId = $('#vendor_id').val();
        var type = $("input[name=type]:checked").val();

        if((type=='Non-Vendor' && paidTo.trim()) || (type=='Vendor' && vendorId)){
          var table = $('#itemsTable tbody');
            //Get all data in the table
            table.find('tr').each(function(rowIndex, r){
              count=0;
              tData = '';
              //var cols = [];
              console.log('Enter 1st loop');
              $(this).find('td').each(function (colIndex, c) {
                count++;
                if(count<4){
                  tData+=(c.textContent+',');
                }
                });
              data+= (tData.substring(0,tData.length - 1) + '|');
            });
            data = data.substring(0,data.length - 1);
            console.log(data);
            //Retrieving total amount of invoice
            $("#amountCalc tbody td").each(function(){
              totalAmount = parseFloat(($(this).text().replace('PHP ','').trim()));
            });
            console.log(totalAmount);
            if(data){
              //Creating an ajax request to the server
              $.ajax({
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                url: '/expense/'+_id,
                type: 'PUT',
                data: { 'data':data,
                        'vendorId':vendorId,
                        'paidTo': paidTo,
                        'totalAmount': totalAmount,
                        'type':type},
                success: function(response)
                {
                    //alert(response);
                    location.href="/expense/"+_id;
                }, error: function(xhr, ajaxOptions, thrownError){
                  alert(xhr.status);
                  alert(thrownError);
                }
              });
            }else{
              alert('Please Input data into table.');
            }
        }else{
          alert('Must input which Company/HomeOwner will receive the cash voucher');
        }
      });

      /*
      * @Author:      Kristopher N. Veraces
      * @Description: Hide default value if account title is not income
      * @Date:        7/6/2016
      */
      $('#accountgroup').change(function(){
        var groupName = $('#accountgroup option:selected').text();

        if(groupName == 'Revenues'){
          $('#default_value_form').show();
          $('#subject_to_vat_chckbox').show();
          $('#opening_balance_form').hide();
        }else if(groupName == 'Expenses'){
          $('#subject_to_vat_chckbox').hide();
          $('#opening_balance_form').hide();
          $('#default_value_form').hide();
        }else{
          $('#subject_to_vat_chckbox').hide();
          $('#opening_balance_form').show();
          $('#default_value_form').hide();
        }
      });



      $('div.alert').not('.alert-important').delay(3000).slideUp(300);
      $('#flash-overlay-modal').modal();

      /*
      * @Author:      Kristopher N. Veraces
      * @Description: Generating a pdf
      * @Date:        7/12/2016
      */
      $('#nPaymentItem').on('change',function(){
        var selectOptionVal = $( "#nPaymentItem option:selected" ).attr('name');
        if(selectOptionVal ){
          if(parseFloat(selectOptionVal) > 0){
            $('#nPaymentCost').prop('readonly', true);
            $('#nPaymentCost').val(parseFloat(selectOptionVal) + '.00');
          }else{
            $('#nPaymentCost').prop('readonly', false);
            $('#nPaymentCost').val(parseFloat('0') + '.00');
          }
          
        }
      });

      
      /*
      * @author:        Kristopher Veraces
      * @description:   Disable fields dr or cr field depending on picklist value
      */
      $(document).on('change', "select[name='cr_dr']", function(e){
        var ch = "";
        $(this).closest('tr').find("td").each(function(colIndex, c) {
           var select = $(this).find("select");
           if(select.attr('name') == 'cr_dr'){
              ch = select.val();
           }
           var input = $(this).find("input");
           var isCRFieldDisabled = true;
           var isDRFieldDisabled = true;
           if(input.attr('name')){
              if(ch=='CR'){
                 isCRFieldDisabled = false;
              }else if(ch=='DR'){
                 isDRFieldDisabled = false;
              }

              if(input.attr('name').trim() == 'dr_amount'){
                 input.attr('disabled',isDRFieldDisabled);
                 input.val("0.00");
              }else if(input.attr('name').trim() == 'cr_amount'){
                 input.attr('disabled',isCRFieldDisabled);
                 input.val("0.00");  
              }
           }
        });
      });

      $(".select1_single").select2({
        placeholder: "CR/DR",
        allowClear: true
      });

      $(document).on('click', '.add-row', function(e){
        e.preventDefault();
        var isDuplicate = checkIfDuplicate();
        var selectOptionVal = $('meta[name="account-list"]').attr('content');
        var jsonParse = JSON.parse(selectOptionVal);
        
        // console.log(jsonParse);
        if(isDuplicate){
           alert(isDuplicate);
        }else{
           $('.ledger-body').append(
              '<tr>' +
                 '<td>' +
                    '<select style="width: 95px;" name="cr_dr" class="form-control select1_single">' +
                       '<option value=""></option>' + 
                       '<option value="DR">DR</option>' +
                       '<option value="CR">CR</option>' +
                    '</select>' +
                 '</td>' +
                 '<td style="width: 20%;">' +
                    '<select name="account_title" id="" class="form-control select2_single">' +
                    '</select>' +
                 '</td>' +
                  '<td>' +
                    '<textarea class="form-control" id="explanation" cols="50" rows="2" style="resize: none;"></textarea>'+
                  '</td>'+
                  '<td>' +
                    '<input name="dr_amount" step="0.01" type="number" class="form-control" value = "0.00" disabled>' +
                  '</td>'+
                  '<td>' +
                    '<input name="cr_amount" step="0.01" type="number" class="form-control" value = "0.00" disabled>' +
                  '</td>' +
                  '<td>' +
                    '<button class="btn btn-default add-row">' +
                       '<i class="fa fa-plus"></i> Add' +
                  '</button> ' +
                    '<button class="btn btn-default delete-row">' +
                       '<i class="fa fa-trash"></i> Delete' +
                    '</button>' +
                 '</td>' +
              '</tr>'
           );
          
        }

        $('#journal_entry_table tr:last td').each(function(){
          console.log('last table');
          var selectTitle = $(this).find('select');
          if(selectTitle.attr('name')){
            if(selectTitle.attr('name') == 'account_title'){
              for(var i = 0; i < jsonParse.length; i++) {
                selectTitle.append($('<option>',{
                  value: jsonParse[i]['id'],
                  text: jsonParse[i]['account_sub_group_name']
                }));
              }
            }
          }
          
        });
        
        

        

        $(".select2_single").select2({
          placeholder: "Select a value",
          allowClear: true
        });

        $(".select1_single").select2({
           placeholder: "CR/DR",
           allowClear: true
        });
      });
        
      $(".select2_single").select2({
          placeholder: "Select a value",
          allowClear: true
      });

      $(document).on('click', '.delete-row', function(e){
        e.preventDefault();
        $(this).parent().parent().remove();
      });

      /*
      * @author:        Kristopher Veraces
      * @description:   Collect all data in tables then store to database
      */
      $("#sbmt_jour_entry").click(function(e){
        e.preventDefault;
        var data= '';
        var isDup = checkIfDuplicate();
        //Retrieving token for request
        var _token = $('meta[name="csrf-token"]').attr('content');
        var explanation = $('#explanation').val();
        console.log(explanation);
        if(isDup){
           alert(isDup);
        }else{
          $("#journal_entry_table tbody tr td").each(function() {
            var input = $(this).find('input');
            var select = $(this).find('select');
            var textArea = $(this).find('textarea');

            if(textArea.attr('id')){
              data += (textArea.val() + ',');
            }

            if(select.attr('name')){
              data += (select.val() + ',');
            }
            if(input.attr('name')){
              if(input.val() != '0.00'){
                 data += (input.val() + ',');
              }
            }
          });
          data = data.slice(0,-1);
          console.log('data');
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': _token
            },
            url: '/journal/create',
            type: 'POST',
            data: { 'data':data,
                        'explanation':explanation},
            success: function(response)
            {
                //alert(response);
                location.href="/account";
            }, error: function(xhr, ajaxOptions, thrownError){
              alert(xhr.status);
              alert(thrownError);
            }
          });
          console.log(data);
        }
        return false;
      });

      $("#computeTotal").click(function(e){
        e.preventDefault;
        var isDup = checkIfDuplicate();
        if(isDup){
           alert(isDup);
        }else{
           calculateAmountJournal();
        }
        return false;
      });


      /*
      * @author:        Kristopher Veraces
      * @description:   Compute Total Amount
      */
      function calculateAmountJournal(){
        var drTotalAmount = 0;
        var crTotalAmount = 0;
        var count = 0;
        //Get all amount in the table
        $("#journal_entry_table tbody tr td").each(function() {
           var input = $(this).find('input');
           if(input.attr('name') == 'dr_amount'){
              drTotalAmount += parseFloat(input.val());
           }else if(input.attr('name') == 'cr_amount'){
              crTotalAmount += parseFloat(input.val());
           }
        });
        
        //Putting the total amount in another table for viewing
        $("#journal_total_amount tbody td").each(function(){
           ++count;
           if(count==2){
              $(this).text('PHP ' + drTotalAmount);
           }else if(count==3){
              $(this).text('PHP ' + crTotalAmount);
           }
        });
      }

     /*
     * @author:        Kristopher Veraces
     * @description:   Validation in Journal 
                          -Checks if duplicated account title is inputted
                          -Checks if credit or debit amount in not zero
     */
      function checkIfDuplicate(){
        var accountTitles =  [];
        var tAccountTitle = NaN;
        var is_duplicate = NaN;
        var amount = 0;
        $('#journal_entry_table tbody').find('tr').each(function(rowIndex, r){
           amount = 0;
           $(this).find('td').each(function (colIndex, c) {
              var selectAccountTitle = $(this).find("select");
              var input = $(this).find("input");

              if((input.attr('name') == 'dr_amount' || input.attr('name') == 'cr_amount') && amount==0){
                 amount = input.val() == ''?0:input.val();
              }
              if(selectAccountTitle.attr('name')=='account_title'){
                 tAccountTitle = selectAccountTitle.val();
              }
              
           });
           //console.log(amount);
           if(amount <= 0){
              is_duplicate = 'CR/DR amount must be greater than zero';
              return true;
           }

           if(tAccountTitle){
              if($.inArray(tAccountTitle,accountTitles) != -1){
                 is_duplicate = 'Duplicate Account Title Detected';
                 return true;
              }else{
                 accountTitles.push(tAccountTitle);
              } 
           }
        });
        return is_duplicate;
      }

    /*
     * @author:        Kristopher Veraces
     * @description:   Shows Depreciation Information if radio button is Yes
     */
    $("input[name=mode_of_acquisition]:radio").change(function(e){
      $("input[name=downPayment]").val("");
      if($(this).val() == 'Both'){
        $("#downPayment").show();
      }
      else if($(this).val() == 'Payable'){
        $("#downPayment").hide();
      }else{
        $("#downPayment").hide();
      }
        
    });

    function getTodaysDate(){
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!
      var yyyy = today.getFullYear();

      if(dd<10) {
          dd='0'+dd
      } 

      if(mm<10) {
          mm='0'+mm
      } 

      today = mm+'/'+dd+'/'+yyyy;
      return today;
    }

    $("input[name=type]:radio").change(function(e){
      $("input[name=paid_to]").val('');
      if($(this).val() == 'Non-Vendor'){
        $("#vendorList").hide();
        $("#non_vendor").show();
      }
      else if($(this).val() == 'Vendor'){
        $("#vendorList").show();
        $("#non_vendor").hide();
      }
        
    });

    if($("input[name=type]:checked").val() =='Non-Vendor'){
      $("#vendorList").hide();
      $("#non_vendor").show();
    }else if($("input[name=type]:checked").val() =='Vendor'){
      $("#vendorList").show();
      $("#non_vendor").hide();
    }
  });
</script>