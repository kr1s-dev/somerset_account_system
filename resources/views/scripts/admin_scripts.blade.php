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
<!-- Chart.js -->
<script src="{{ URL::asset('vendors/Chart.js/dist/Chart.min.js')}}"></script>
<!-- jQuery Sparklines -->
<script src="{{ URL::asset('vendors/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- Flot -->
<script src="{{ URL::asset('vendors/Flot/jquery.flot.js')}}"></script>
<script src="{{ URL::asset('vendors/Flot/jquery.flot.pie.js')}}"></script>
<script src="{{ URL::asset('vendors/Flot/jquery.flot.time.js')}}"></script>
<script src="{{ URL::asset('vendors/Flot/jquery.flot.stack.js')}}"></script>
<script src="{{ URL::asset('vendors/Flot/jquery.flot.resize.js')}}"></script>
<!-- Flot plugins -->
<script src="{{ URL::asset('js/flot/jquery.flot.orderBars.js')}}"></script>
<script src="{{ URL::asset('js/flot/jquery.flot.axislabels.js')}}"></script>
<script src="{{ URL::asset('js/flot/jquery.flot.categories.js')}}"></script>
<script src="{{ URL::asset('js/flot/date.js')}}"></script>
<script src="{{ URL::asset('js/flot/jquery.flot.spline.js')}}"></script>
<script src="{{ URL::asset('js/flot/curvedLines.js')}}"></script>

<script>
  $(document).ready(function(){
      var exTableRowIndex;
      var arrayTd;
      var expense_id;

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

      
      $('#howeOwnersList').on('change',function(){
        var selectOptionVal = $( "#howeOwnersList option:selected" ).attr('name');
        ////console.log(selectOptionVal);
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

      
      $("#addItemRow").click(function(e){
        e.preventDefault();
        $('#nPaymentItem').select2("val", "");
        $('#nQuantity').val('');
        $('#nPaymentDesc').val('');
        $('#nPaymentCost').val('')
      });

      
      $("#nPaymentBtn").click(function(e){
        e.preventDefault();
        var type = $('meta[name="type"]').attr('content');
        var paymentType = $('#nPaymentItem option:selected').text();
        var paymentDesc = $('#nPaymentDesc').val();
        var nPaymentCost = $('#nPaymentCost').val()?$('#nPaymentCost').val():0;
        var nQuantity = $("#nQuantity").val();
        var errorMessage = '';
        var hasDuplicate = false;
        var tdTableData;

        if(type!='Expense' && !nQuantity){
          errorMessage+='\nInvalid Quantity';
          alert('Invalid Data:' + errorMessage);
          return false;
        }

        if(nQuantity < 0){
          errorMessage+='\nQuantity must be greater than zero';
          alert('Invalid Data:' + errorMessage);
          return false;
        }
          
          
        //Checks if inputted correct data / or is not null
        if(paymentType && nPaymentCost && nPaymentCost > 0){
          var table = $('#itemsTable tbody');
          table.find('tr').each(function(rowIndex, r){
            $(this).find('td').each(function (colIndex, c) {
              ////console.log('Enter 2nd loop' + c.textContent);
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
            if(type!='Expense'){
              $('#itemsTable tbody').append( '<tr>' +
              '<td>'+ nQuantity+'</td>' +
              '<td>'+ paymentType.trim()+'</td>' +
              '<td>'+ paymentDesc.trim() +'</td>' +
              '<td>'+ parseFloat(nPaymentCost.trim()) +'</td>' +
              '<td><button class="btn btn-default edit-item" id="editTrans" data-toggle="modal" data-target="#myModalEdit"><i class="fa fa-pencil"></i></button> <button class="btn btn-default delete-item"><i class="fa fa-times"></i></button></td>' +
              '</tr>');
            }else{
              $('#itemsTable tbody').append( '<tr>' +
              '<td>'+ paymentType.trim()+'</td>' +
              '<td>'+ paymentDesc.trim() +'</td>' +
              '<td>'+ parseFloat(nPaymentCost.trim()).toFixed(2) +'</td>' +
              '<td><button class="btn btn-default edit-item" id="editTrans" data-toggle="modal" data-target="#myModalEdit"><i class="fa fa-pencil"></i></button> <button class="btn btn-default delete-item"><i class="fa fa-times"></i></button></td>' +
              '</tr>');
            }
          }
          // else{
          //   tdTableData = tdTableData.find('td');
          //   if(type!='Expense'){
          //     tdTableData[2].textContent = (parseFloat(tdTableData[2].textContent.trim()) + parseFloat(nPaymentCost));
          //   }else{
          //     tdTableData[3].textContent = (parseFloat(tdTableData[3].textContent.trim()) + parseFloat(nPaymentCost));
          //   }
          // }
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

      
      $("#createInvBtn").click(function(e){
          var data='';
          var tData = '';
          var totalAmount = 0;
          var paymentDueDate = $('#paymentDueDate').val();
          
          //Retrieving token for request
          var _token = $('meta[name="csrf-token"]').attr('content');
          ////console.log(_token);

          // //Retrieving account detail
          // var accountDetailId = $( "#cashier" ).val();

          //Retrieving homeownerid for insertion of record
          var homeOwnerId = $("#homeowners option:selected" ).val();
          var dueDate = paymentDueDate.split('/');
          dueDate = new Date(Date.parse(dueDate[1] + '/' + dueDate[0] + '/' + dueDate[2]));
          if(homeOwnerId){
            if(dueDate >=  new Date().setDate(new Date().getDate()-1)){
              var table = $('#itemsTable tbody');
              //Get all data in the table
              table.find('tr').each(function(rowIndex, r){
                //var cols = [];
                ////console.log('Enter 1st loop');
                $(this).find('td').each(function (colIndex, c) {
                  ////console.log('Enter 2nd loop' + c.textContent);
                  if(c.textContent!=' ')
                    data+=(c.textContent+'|');
                  });
                  //data+= (tData.substring(0,tData.length - 1) + '|');
              });
              data = data.substring(0,data.length - 1);
              ////console.log(data);
              //Retrieving total amount of invoice
              $("#amountCalc tbody td").each(function(){
                totalAmount = parseFloat(($(this).text().replace('PHP ','').trim()));
              });
              ////console.log(totalAmount + ' ' + homeOwnerId + ' ' + paymentDueDate);
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
      
      
       $('#itemsTable').on( 'click', '#editTrans', function(event){
        var tr = $(this).closest('tr'); //get the parent tr
        arrayTd = $(tr).find('td'); //get data in a row
        var type = $('meta[name="type"]').attr('content');
        if(type!='Expense'){
          $("#eQuantity").val((arrayTd[0].textContent).trim());
          $("#ePaymentDesc").val((arrayTd[2].textContent).trim());
          $("#ePaymentCost").val((arrayTd[3].textContent).trim());
        }else{
          $("#eQuantity").val((arrayTd[0].textContent).trim());
          $("#ePaymentDesc").val((arrayTd[1].textContent).trim());
          $("#ePaymentCost").val((arrayTd[2].textContent).trim());
        }
        
      });

      
      $("#ePaymentBtn").click(function(e){
        e.preventDefault();
        var type = $('meta[name="type"]').attr('content');
        if(type!='Expense'){
          if($('#eQuantity').val() && $('#eQuantity').val() > 0){
            arrayTd[0].textContent = $('#eQuantity').val();
          }else{
            alert('Invalid Data: Quantity must be greater than zero');
            return false;
          }
        }
        

        if($('#ePaymentDesc').val()){
          if(type!='Expense'){
            arrayTd[2].textContent = $('#ePaymentDesc').val();
          }else{
            arrayTd[1].textContent = $('#ePaymentDesc').val();
          }
          
        }

        if($('#ePaymentCost').val() && $('#ePaymentCost').val() > 0){
          if(type!='Expense'){
              arrayTd[3].textContent = parseFloat($('#ePaymentCost').val()).toFixed(2);
          }else{
            arrayTd[2].textContent = parseFloat($('#ePaymentCost').val()).toFixed(2);
          }
        }else{
          alert('Invalid Data: Payment Cost must be greater than zero');
          return false;
        }
        calculateAmount();
      });

      
      function calculateAmount(){
        var total = 0;
        var quant = [];
        var count = 0;
        //Get all amount in the table
        var type = $('meta[name="type"]').attr('content');
        if(type!='Expense'){
          $("#itemsTable tbody td:nth-child(1)").each(function() {
            quant.push(parseFloat($(this).text()));
          });

          $("#itemsTable tbody td:nth-child(4)").each(function() {
            total += (quant[count] * parseFloat($(this).text()));
            count+=1;
          });
        }else{
          $("#itemsTable tbody td:nth-child(3)").each(function() {
            total += parseFloat($(this).text());
          });
        }
        
        
        //Putting the total amount in another table for viewing
        $("#amountCalc tbody td").each(function(){
          $(this).text('PHP ' + total);
        });
      }


      
      $("#createExpBtn").click(function(e){
          var data='';
          var totalAmount = 0;
          var paidTo = $('#paid_to').val();
          //Retrieving token for request
          var _token = $('meta[name="csrf-token"]').attr('content');
          var vendorId = $('#vendor_id').val();
          var type = $("input[name=type]:checked").val();
          //console.log(type);
          //console.log(paidTo.trim());
          //console.log(vendorId);
          if((type=='Non-Vendor' && paidTo.trim()) || (type=='Vendor' && vendorId)){
            var table = $('#itemsTable tbody');
            //Get all data in the table
            table.find('tr').each(function(rowIndex, r){
              $(this).find('td').each(function (colIndex, c) {
                if(c.textContent!=' ')
                  data+=(c.textContent+'|');
                });
                //data+= (tData.substring(0,tData.length - 1) + '|');
            });
            data = data.substring(0,data.length - 1);
            //console.log(data);
            //Retrieving total amount of Expense
            $("#amountCalc tbody td").each(function(){
              totalAmount = parseFloat(($(this).text().replace('PHP ','').trim()));
            });
            //console.log(totalAmount);
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
          //console.log('Enter 1st loop');
          $(this).find('td').each(function (colIndex, c) {
            count++;
            if(count<5){
              data+=((c.textContent).trim()+'|');
            }
            });
          //data+= (tData.substring(0,tData.length - 1) + '|');
        });
        data = data.substring(0,data.length - 1);
        //console.log(data);
        //Retrieving total amount of invoice
        $("#amountCalc tbody td").each(function(){
          totalAmount = parseFloat(($(this).text().replace('PHP ','').trim()));
        });
        //console.log(totalAmount);
        var dueDate = paymentDueDate.split('/');
        dueDate = new Date(Date.parse(dueDate[1] + '/' + dueDate[0] + '/' + dueDate[2]));
        if(dueDate >=  new Date().setDate(new Date().getDate()-1)){
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

      

      $("#updateExpBtn").click(function(e){
        e.preventDefault();
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
        var adminPassword = $('#adminPassword').val();
        var vendorId = $('#vendor_id').val();
        var type = $("input[name=type]:checked").val();

        if((type=='Non-Vendor' && paidTo.trim()) || (type=='Vendor' && vendorId)){
          var table = $('#itemsTable tbody');
            //Get all data in the table
            table.find('tr').each(function(rowIndex, r){
              count=0;
              tData = '';
              //var cols = [];
              //console.log('Enter 1st loop');
              $(this).find('td').each(function (colIndex, c) {
                count++;
                if(count<4){
                  tData+=(c.textContent+'|');
                }
                });
              data+= (tData.substring(0,tData.length - 1) + '|');
            });
            data = data.substring(0,data.length - 1);
            //console.log(data);
            //Retrieving total amount of invoice
            $("#amountCalc tbody td").each(function(){
              totalAmount = parseFloat(($(this).text().replace('PHP ','').trim()));
            });
            //console.log(totalAmount);
            if(data){
              //Creating an ajax request to the server
              $.ajax({
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                url: '/expense/'+_id,
                type: 'PUT',
                data: {'data':data,
                        'vendorId':vendorId,
                        'paidTo': paidTo,
                        'totalAmount': totalAmount,
                        'type':type,
                        'adminPassword':adminPassword},
                success: function(response){
                  if(response['status'] == 'success'){
                    window.location.href="/expense/"+_id;
                  }else{
                    window.location.href="/expense/"+_id+'/edit';
                  }
                    
                }, error: function(xhr, ajaxOptions, thrownError){ 
                }
              });
            }else{
              alert('Please Input data into table.');
            }
        }else{
          alert('Must input which Company/HomeOwner will receive the cash voucher');
        }
      });

      

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
        
        // //console.log(jsonParse);
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
          //console.log('last table');
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

      
      $("#sbmt_jour_entry").click(function(e){
        e.preventDefault;
        var data= '';
        var isDup = checkIfDuplicate();
        //Retrieving token for request
        var _token = $('meta[name="csrf-token"]').attr('content');
        var explanation = $('#explanation').val();
        var type = $('meta[name="type"]').attr('content');
        //console.log(explanation);
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
          //console.log('data');
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': _token
            },
            url: '/journal/create',
            type: 'POST',
            data: { 'data':data,
                      'explanation':explanation,
                      'type':type},
            success: function(response)
            {
                //alert(response);
                location.href="/account";
            }, error: function(xhr, ajaxOptions, thrownError){
              alert(xhr.status);
              alert(thrownError);
            }
          });
          //console.log(data);
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
           ////console.log(amount);
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

    if($("input[name=mode_of_acquisition]:checked").val() == 'Both')
        $("#downPayment").show();

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

    $('#datatable').on( 'click', '#deLbtn', function(event){
      var tr = $(this).closest('tr'); //get the parent tr
      arrayTd = $(tr).find('td'); //get data in a row
      expense_id = arrayTd[0].textContent.replace('#','').replace(/^0+/, '');
      console.log(expense_id);
      $("#confirm").modal('show');
    });

    $("#conDel").click(function(e){
      e.preventDefault();
      console.log(expense_id);
      var _token = $("#_token").val();
      console.log(_token);
      var adminPassword = $("#adminPassword").val();
      console.log(adminPassword);
      if(adminPassword){
        $.ajax({
          headers: {
              'X-CSRF-TOKEN': _token
          },
          url: 'expense/delete/'+expense_id,
          type: 'POST',
          data: { 'id':expense_id,
                    'adminPassword':adminPassword},
          success: function(response)
          {
              //alert(response);
              location.href="/expense";
          }, error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.status);
            alert(thrownError);
          }
        });
      }else{
        alert('Please input password for confirmation');
        return false;
      }
    });
    // $('#itemsTable').on( 'click', '#editTrans', function(event){
    //     var tr = $(this).closest('tr'); //get the parent tr
    //     arrayTd = $(tr).find('td'); //get data in a row
    //     var type = $('meta[name="type"]').attr('content');
    //     if(type!='Expense'){
    //       $("#eQuantity").val((arrayTd[0].textContent).trim());
    //       $("#ePaymentDesc").val((arrayTd[2].textContent).trim());
    //       $("#ePaymentCost").val((arrayTd[3].textContent).trim());
    //     }else{
    //       $("#eQuantity").val((arrayTd[0].textContent).trim());
    //       $("#ePaymentDesc").val((arrayTd[1].textContent).trim());
    //       $("#ePaymentCost").val((arrayTd[2].textContent).trim());
    //     }
        
    //   });
  });
</script>

<script>
  $(document).ready(function() {
    var dataIncome = {!! isset($incomeAmountPerMonth)?json_encode($incomeAmountPerMonth):null !!};
    var expenseIncome = {!! isset($expenseAmountPerMonth)?json_encode($expenseAmountPerMonth):null !!};
    //define chart clolors ( you maybe add more colors if you want or flot will add it automatic )
    var chartColours = ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'];

    var d1 = [];
    var d2 = [];
    var ticks = [];

    //here we generate data for chart
    for(var c in dataIncome){
      console.log(c);
      ticks.push([new Date().setMonth(c-1)]);
      //console.log(new Date().setMonth(5));
      d1.push([new Date().setMonth(c-1),dataIncome[c]]);
    }
    for(var c in expenseIncome){
      d2.push([new Date().setMonth(c-1),expenseIncome[c]]);
    }

    // for (var i = 0; i <= new Date().getMonth(); i++) {
    //   d1.push([new Date(new Date().getFullYear(),i,1).getTime(), dataIncome[(i+1)]]);
    //   d2.push([new Date(new Date().getFullYear(),i,1).getTime(), expenseIncome[(i+1)]]);
    // }
    var dataset = [
      {label:"Income",data:d1,lines:{fillColor: "rgba(150, 202, 89, 0.12)"},points:{fillColor: "#fff"}},
      {label:"Expense",data:d2,lines:{fillColor: "rgba(150, 202, 89, 0.42)"},points:{fillColor: "#fff"}}
    ];

    // var chartMinDate = d1[0][0]; //first day
    // var chartMaxDate = d1[20][0]; //last day

    var tickSize = [1, "month"];
    var tformat = "%b";

    //graph options
    var options = {
      grid: {
        show: true,
        aboveData: true,
        color: "#3f3f3f",
        labelMargin: 10,
        axisMargin: 0,
        borderWidth: 0,
        borderColor: null,
        minBorderMargin: 5,
        clickable: true,
        hoverable: true,
        autoHighlight: true,
        mouseActiveRadius: 100
      },
      series: {
        lines: {
          show: true,
          fill: true,
          lineWidth: 2,
          steps: false
        },
        points: {
          show: true,
          radius: 4.5,
          symbol: "circle",
          lineWidth: 3.0
        }
      },
      legend: {
        position: "ne",
        margin: [0, -25],
        noColumns: 0,
        labelBoxBorderColor: null,
        labelFormatter: function(label, series) {
          // just add some space to labes
          return label + '&nbsp;&nbsp;';
        },
        width: 40,
        height: 1
      },
      colors: chartColours,
      shadowSize: 0,
      tooltip: true, //activate tooltip
      tooltipOpts: {
        content: "%s: %y.0",
        xDateFormat: "%d/%m",
        shifts: {
          x: -30,
          y: -50
        },
        defaultTheme: false
      },
      yaxis: {
        min: 0
      },
      xaxis: {
        mode: "time",
        ticks: ticks,
        tickLength: 0,
        timeformat: "%b/%Y",
        // tickSize: tickSize,
        // minTickSize: tickSize,
        // timeformat: tformat,
        min: (new Date(new Date().getFullYear() - 1, 11, 18)).getTime(),
        max: (new Date(new Date().getFullYear(), new Date().getMonth()+1, 15)).getTime(),
      }
    };
    var plot = $.plot($("#placeholder33x"), dataset , options);
  });
</script>

<script>
  $(document).ready(function() {
    $(".sparkline_one").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 5, 6, 4, 5, 6, 3, 5, 4, 5, 4, 5, 4, 3, 4, 5, 6, 7, 5, 4, 3, 5, 6], {
      type: 'bar',
      height: '125',
      barWidth: 13,
      colorMap: {
        '7': '#a1a1a1'
      },
      barSpacing: 2,
      barColor: '#26B99A'
    });

    $(".sparkline11").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3], {
      type: 'bar',
      height: '40',
      barWidth: 8,
      colorMap: {
        '7': '#a1a1a1'
      },
      barSpacing: 2,
      barColor: '#26B99A'
    });

    $(".sparkline22").sparkline([2, 4, 3, 4, 7, 5, 4, 3, 5, 6, 2, 4, 3, 4, 5, 4, 5, 4, 3, 4, 6], {
      type: 'line',
      height: '40',
      width: '200',
      lineColor: '#26B99A',
      fillColor: '#ffffff',
      lineWidth: 3,
      spotColor: '#34495E',
      minSpotColor: '#34495E'
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {

    var cb = function(start, end, label) {
      ////console.log(start.toISOString(), end.toISOString(), label);
      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    };

    var optionSet1 = {
      startDate: moment().subtract(29, 'days'),
      endDate: moment(),
      minDate: '01/01/2012',
      maxDate: '12/31/2015',
      dateLimit: {
        days: 60
      },
      showDropdowns: true,
      showWeekNumbers: true,
      timePicker: false,
      timePickerIncrement: 1,
      timePicker12Hour: true,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      opens: 'left',
      buttonClasses: ['btn btn-default'],
      applyClass: 'btn-small btn-primary',
      cancelClass: 'btn-small',
      format: 'MM/DD/YYYY',
      separator: ' to ',
      locale: {
        applyLabel: 'Submit',
        cancelLabel: 'Clear',
        fromLabel: 'From',
        toLabel: 'To',
        customRangeLabel: 'Custom',
        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        firstDay: 1
      }
    };
    $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    $('#reportrange').daterangepicker(optionSet1, cb);
    $('#reportrange').on('show.daterangepicker', function() {
      //console.log("show event fired");
    });
    $('#reportrange').on('hide.daterangepicker', function() {
      //console.log("hide event fired");
    });
    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
      //console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
      //console.log('do ajax call');
    });
    $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
      //console.log("cancel event fired");
    });
    $('#options1').click(function() {
      $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
    });
    $('#options2').click(function() {
      $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
    });
    $('#destroy').click(function() {
      $('#reportrange').data('daterangepicker').remove();


    });
  });
</script>

<!-- For AR Weekly -->
<script>
  $(document).ready(function() {
    var hSubsidiary = {!! isset($homeOwnerSubsidiaryLedgerPerWeek)?json_encode($homeOwnerSubsidiaryLedgerPerWeek):null !!};
    console.log(hSubsidiary);
    var chartColours = ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'];
    var d1 = [];
    var ticks = [];
    for (var i = 0; i <= 6; i++) {
      // d1.push([new Date(new Date().getFullYear(),new Date().getMonth(),i).getTime(), hSubsidiary[i]]);
      if(hSubsidiary){
        var tDate = moment().startOf('isoWeek').add(i,'days').format('D');
        tDate = tDate.length == 1? '0'+tDate:tDate;
        ////console.log(moment().startOf('isoWeek').add(i,'days').format('D').length);
        ticks.push([moment().startOf('isoWeek').add(i+1,'days').toDate().getTime()]);
        d1.push([moment().startOf('isoWeek').add(i+1,'days').toDate().getTime(), hSubsidiary[tDate]]);
      }
    }
    var tickSize = [1, "day"];
    var tformat = "%d/%b";

    var dataset = [
      {label:"AR",data:d1,lines:{fillColor: "rgba(150, 202, 89, 0.12)"},points:{fillColor: "#fff"}}
    ];

    var options = {
      grid: {
        show: true,
        aboveData: true,
        color: "#3f3f3f",
        labelMargin: 10,
        axisMargin: 0,
        borderWidth: 0,
        borderColor: null,
        minBorderMargin: 5,
        clickable: true,
        hoverable: true,
        autoHighlight: true,
        mouseActiveRadius: 100,
        aboveData: true
      },
      series: {
        lines: {
          show: true,
          fill: true,
          lineWidth: 2,
          steps: false
        },
        points: {
          show: true,
          radius: 4.5,
          symbol: "circle",
          lineWidth: 2.0
        }
      },
      legend: {
        position: "ne",
        margin: [0, -25],
        noColumns: 0,
        labelBoxBorderColor: null,
        labelFormatter: function(label, series) {
          // just add some space to labes
          return label + '&nbsp;&nbsp;';
        },
        width: 40,
        height: 1
      },
      colors: chartColours,
      shadowSize: 0,
      tooltip: true, //activate tooltip
      tooltipOpts: {
        content: "%s: %y.0",
        xDateFormat: "%d/%m",
        shifts: {
          x: -30,
          y: -50
        },
        defaultTheme: false
      },
      yaxis: {
        min: 0
      },
      xaxis: {
        mode: "time",
        ticks:ticks,
        timeformat: "%b/%d",
        // minTickSize:tickSize,
        min: moment().startOf('isoWeek').toDate().getTime(),
        max: moment().endOf('isoWeek').add(1,'days').toDate().getTime()
      }
    };  
    var plot = $.plot($("#placeholder34x"), dataset , options);
  });
</script>

<!-- For AP Weekly -->
<script>
  $(document).ready(function() {
    var hSubsidiary = {!! isset($homeVendorSubsidiaryLedgerPerWeek)?json_encode($homeVendorSubsidiaryLedgerPerWeek):null !!};
    //define chart clolors ( you maybe add more colors if you want or flot will add it automatic )
    ////console.log(hSubsidiary);
    var chartColours = ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'];
    var d1 = [];
    var ticks = [];
    for (var i = 0; i <= 6; i++) {
      // d1.push([new Date(new Date().getFullYear(),new Date().getMonth(),i).getTime(), hSubsidiary[i]]);
      if(hSubsidiary){
        var tDate = moment().startOf('isoWeek').add(i,'days').format('D');
        tDate = tDate.length == 1? '0'+tDate:tDate;
        ////console.log(moment().startOf('isoWeek').add(i,'days').format('D').length);
        ticks.push([moment().startOf('isoWeek').add(i+1,'days').toDate().getTime()]);
        d1.push([moment().startOf('isoWeek').add(i+1,'days').toDate().getTime(), hSubsidiary[tDate]]);
      }
    }
    var tickSize = [1, "day"];
    var tformat = "%d/%b";

      var dataset = [
        {label:"AP",data:d1,lines:{fillColor: "rgba(150, 202, 89, 0.12)"},points:{fillColor: "#fff"}}
      ];

      var options = {
        grid: {
          show: true,
          aboveData: true,
          color: "#3f3f3f",
          labelMargin: 10,
          axisMargin: 0,
          borderWidth: 0,
          borderColor: null,
          minBorderMargin: 5,
          clickable: true,
          hoverable: true,
          autoHighlight: true,
          mouseActiveRadius: 100
        },
        series: {
          lines: {
            show: true,
            fill: true,
            lineWidth: 2,
            steps: false
          },
          points: {
            show: true,
            radius: 4.5,
            symbol: "circle",
            lineWidth: 3.0
          }
        },
        legend: {
          position: "ne",
          margin: [0, -25],
          noColumns: 0,
          labelBoxBorderColor: null,
          labelFormatter: function(label, series) {
            // just add some space to labes
            return label + '&nbsp;&nbsp;';
          },
          width: 40,
          height: 1
        },
        colors: chartColours,
        shadowSize: 0,
        tooltip: true, //activate tooltip
        tooltipOpts: {
          content: "%s: %y.0",
          xDateFormat: "%d/%m",
          shifts: {
            x: -30,
            y: -50
          },
          defaultTheme: false
        },
        yaxis: {
          min: 0
        },
        xaxis: {
          mode: "time",
          ticks:ticks,
          timeformat: "%b/%d",
          // minTickSize:tickSize,
          min: moment().startOf('isoWeek').toDate().getTime(),
          max: moment().endOf('isoWeek').add(1,'days').toDate().getTime()
        }
      };
      var plot = $.plot($("#placeholder35x"), dataset , options);
  });
</script>