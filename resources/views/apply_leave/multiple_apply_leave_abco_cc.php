<!-- Content Wrapper. Contains page content -->
<link href="<?php echo asset('auto_search/jquery-ui.min.css'); ?>" rel="stylesheet">
<script src="<?php echo asset('js/jquery.min.js'); ?>"></script>
<script src="<?php echo asset('js/jquery-ui.min.js'); ?>"></script>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class=""><?php echo $title; ?></div>
            <form action="<?php echo route("multiple_apply_leave/multiple_leave_store_abco"); ?>" class="role leave_form" method="post" id="form-id" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group mb-2">
                            <div class="form-group mb-2">
                                <label class="m-0" for="EmployeeName">Employee Code</label>
                                <input type="text" class="form-control form-control-sm emp_code" name="emp_code[]" autocomplete="off">
                                <input type="hidden" class="form-control form-control-sm EmployeeID" name="EmployeeID[]" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="form-group mb-2">
                                <label class="m-0" for="EmployeeName">Employee Name</label>
                                <input type="text" class="form-control form-control-sm emp_name" name="emp_name[]" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="form-group mb-2">
                                <label class="m-0" for="EmployeeName">Section</label>
                                <input type="text" class="form-control form-control-sm section" name="section[]" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="form-group mb-2">
                                <label class="m-0" for="EmployeeName">Staff Category</label>
                                <input type="text" class="form-control form-control-sm staff_category" name="staff_category[]" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="form-group mb-2">
                                <label class="m-0" for="EmployeeName">Employee Type</label>
                                <input type="text" class="form-control form-control-sm emp_type" name="emp_type[]" autocomplete="off" readonly>
                                <input type="file" name="fileToUpload" id="fileToUpload">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1 leave_days_part">
                        <div class="form-group mb-2">
                            <div class="form-group mb-2">
                                <label class="m-0" for="EmployeeName">Current Year</label>
                                <?php echo form_input('current_year[]', 'text', date('Y'), 'class="form-control form-control-sm current_year" '); ?>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="form-group mb-2">
                                <label class="m-0" for="EmployeeName">Leave Type</label>
                                <?php echo form_select('LeaveType[]', $leave_type, null, 'class="form-control form-control-sm LeaveType inputkey" '); ?>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="form-group mb-2">
                                <label class="m-0" for="EmployeeName">From Date</label>
                                <?php echo form_input('FromDate[]', 'text', date('d-m-Y'), 'class="form-control form-control-sm  FromDate inputkey"  autocomplete="off"'); ?>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="form-group mb-2">
                                <label class="m-0" for="EmployeeName">To Date</label>
                                <?php echo form_input('ToDate[]', 'text', date('d-m-Y'), 'class="form-control form-control-sm  ToDate inputkey" autocomplete="off" autofocus'); ?>
                                <input type="text" id="myDate"  onclick="myFunction()" class="date_picker FromDate" value="<?php echo date('m-d-y'); ?>" autofocus>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="form-group mb-2">
                                <label class="m-0" for="EmployeeName">No. of Days</label>
                                <?php echo form_input('LeaveDays[]', 'number', old('LeaveDays'), 'class="form-control form-control-sm LeaveDays inputkey" '); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 mt-3">
                        <table class="table table-sm table-bordered dataTableEmployeeInfo">
                            <thead>
                                <tr>
                                    <th class="text-center" colspan="2">Enjoy Leave</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CL</td>
                                    <td><span class="enjoy_cl"></span> </td>
                                </tr>
                                <tr>
                                    <td>ML</td>
                                    <td><span class="enjoy_ml"></span> </td>
                                </tr>
                                <tr>
                                    <td>EL</td>
                                    <td><span class="enjoy_el"></span> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-2 mt-3">
                        <table class="table table-sm table-bordered dataTableEmployeeInfo">
                            <thead>
                                <tr>
                                    <th class="text-center" colspan="2">Balance Leave</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CL</td>
                                    <td><span class="balance_cl"></span> </td>
                                </tr>
                                <tr>
                                    <td>ML</td>
                                    <td><span class="balance_ml"></span> </td>
                                </tr>
                                <tr>
                                    <td>EL</td>
                                    <td><span class="balance_el"></span> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-5 mt-3">
                        <table class="table row_add table-sm table-bordered dataTableEmployeeInfo">
                            <thead>
                                <tr>
                                    <th colspan="7" class="text-center">Leave History</th>
                                </tr>
                                <tr>
                                    <th>S.L</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>CL</th>
                                    <th>ML</th>
                                    <th>EL</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="leave_history">
                            </tbody>
                        </table>
                    </div>
                    <input type="submit" class="btn btn-info float-left submitkey" value="Submit" />
                </div>
            </form>
            <!--div class="col-sm-12">   
                <div class="card card-info card-outline insert_deduct">
                    <div class="card-header p-1">
                        <span class="card-title">Employee Leave Entry</span>
                    </div>
                    
                    <div class="card-body-x p-1">
                        <table class="table row_add table-sm table-bordered dataTableEmployeeInfo">
                            <thead>            
                                <tr>
                                    <th>❌</th>
                                    <th class="text-center">Emp.Code</th>
                                    <th class="text-center" style="width:220px !important;">Emp.Name</th>
                                    <th class="text-center" style="width:100px !important;">Leave Type</th>
                                    <th class="text-center" >From Date</th>
                                    <th class="text-center">To Date</th>
                                    <th class="text-center">No. of Days</th>
                                    <th class="text-center">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="append_row">
                                <tr>
                                    <td><button type="button" class="btn-xs btn-danger remove_row">X</button></td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm emp_code" name="emp_code[]"  autocomplete="off" >
                                        <input type="hidden" class="form-control form-control-sm EmployeeID" name="EmployeeID[]"  autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm emp_name" name="emp_name[]" autocomplete="off" >
                                    </td>
                                    <td>
                                        <?php echo form_select('LeaveType[]', $leave_type, null, 'class="form-control form-control-sm LeaveType" '); ?>
                                    </td>
                                    <td>
                                        <?php echo form_input('FromDate[]', 'text', date('d-m-Y'), 'class="form-control form-control-sm date_picker FromDate"  autocomplete="off"'); ?>
                                    </td>
                                    <td>
                                        <?php echo form_input('ToDate[]', 'text', date('d-m-Y'), 'class="form-control form-control-sm date_picker ToDate" autocomplete="off" '); ?>
                                    </td>
                                    <td>
                                        <?php echo form_input('LeaveDays[]', 'number', old('LeaveDays'), 'class="form-control form-control-sm LeaveDays" '); ?>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="remarks[]" autocomplete="off" >
                                    </td>
                                </tr>                                                                    
                                <tr style="display:none;">
                                    <td><button type="button" class="btn-xs btn-danger remove_row">X</button></td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm emp_code" name="emp_code[]"  autocomplete="off" >
                                        <input type="hidden" class="form-control form-control-sm EmployeeID" name="EmployeeID[]"  autocomplete="off" >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm emp_name" name="emp_name[]" autocomplete="off" >
                                    </td>
                                    <td>
                                        <?php echo form_select('LeaveType[]', $leave_type, null, 'class="form-control form-control-sm LeaveType" '); ?>
                                    </td>
                                    <td>
                                        <?php echo form_input('FromDate[]', 'text', date('d-m-Y'), 'class="form-control form-control-sm date_picker FromDate"  autocomplete="off"'); ?>
                                    </td>
                                    <td>
                                        <?php echo form_input('ToDate[]', 'text', date('d-m-Y'), 'class="form-control form-control-sm date_picker ToDate" autocomplete="off" '); ?>
                                    </td>
                                    <td>
                                        <?php echo form_input('LeaveDays[]', 'number', old('LeaveDays'), 'class="form-control form-control-sm LeaveDays" '); ?>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="remarks[]" autocomplete="off" >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <INPUT type="button" value="Add row" class="add_button btn btn-warning" />
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-info float-right" value="Submit" />
                    </div>
                </div> 
            </div-->
        </div>
    </section>
    <!-- /.content -->
</div>
<script src="<?php echo asset('plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<link href="<?php echo asset('plugins/datepicker/datepicker3.css'); ?>" rel="stylesheet" media="screen">
<script>
function myFunction() {
  var x = document.getElementById("myDate").autofocus;
  document.getElementById("myDate").innerHTML = x;
}
</script>
<script>
    $('.current_year').bind('keypress keydown keyup', function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

    $(document).on('keypress', 'input,select', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            // Get all focusable elements on the page
            var $canfocus = $('.inputkey');
            var index = $canfocus.index(document.activeElement) + 1;
            if (index >= $canfocus.length) {
                index = 0;
                $('.submitkey').click();
            }
            $canfocus.eq(index).focus();
        }
    });
    
    $(document).ready(function() {
        /*Add Row*/
        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });
        /*
        var currentRow = $("table.row_add tbody.append_row tr:last").html();       
        $(".add_button").click(function() {
            $("table.row_add").append('tbody.append_row <tr>'+currentRow+'</tr>'); 
            $('.date_picker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true
            });
        });
        //remove tr of stock table
        $('table.row_add,table.employee-salary_insert_deduct-x').on('click','.remove_row',function(){
            $(this).closest('tr').remove();
        });*/
        $("#form-id").on("keypress", '.emp_code', function(event) {
            var emp_id = $(this).val();
            var current_year = $('.current_year').val();
            var $_this = $(this);
            var keyPressed = event.keyCode || event.which;
            if (keyPressed === 13) {
                if (emp_id) {
                    $.ajax({
                        type: 'get',
                        url: 'get_employee_info',
                        data: {
                            'emp_id': emp_id,
                            'current_year': current_year
                        },
                        success: function(data) { //console.log(data);
                            var get_employee_info = $.parseJSON(data);
                            $_this.val(get_employee_info.EmployeeCode);
                            /*$_this.closest('tr').find('td input.EmployeeID').val(get_employee_info.id);
                            $_this.closest('tr').find('td input.emp_name').val(get_employee_info.EmployeeName);
                            $_this.closest('tr').find('td input.section').val(get_employee_info.section);
                            $_this.closest('tr').find('td input.staff_category').val(get_employee_info.staff_category);
                            $_this.closest('tr').find('td input.emp_type').val(get_employee_info.EmpType);
                            $_this.closest('tr').find('td select.LeaveType').focus();*/

                            $('.leave_form').find('input.EmployeeID').val(get_employee_info.id);
                            $('.leave_form').find('input.emp_name').val(get_employee_info.EmployeeName);
                            $('.leave_form').find('input.section').val(get_employee_info.section);
                            $('.leave_form').find('input.staff_category').val(get_employee_info.staff_category);
                            $('.emp_type').val(get_employee_info.EmpType);
                            $('.LeaveType').focus();
                            $('.enjoy_cl').text(get_employee_info.enjoy_cl + ' Days');
                            $('.enjoy_ml').text(get_employee_info.enjoy_ml + ' Days');
                            $('.enjoy_el').text(get_employee_info.enjoy_el + ' Days');
                            $('.balance_cl').text(get_employee_info.balance_cl + ' Days');
                            $('.balance_ml').text(get_employee_info.balance_ml + ' Days');
                            $('.balance_el').text(get_employee_info.balance_el + ' Days');
                            $('.leave_history').html(get_employee_info.leave_history);
                        }
                    });
                }
                event.preventDefault();
            }
        });
        var d = new Date();
        var today = d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear();
        $('.leave_days_part').on('keyup', '.LeaveDays', function() {
            if ($(this).val()) {
                let FromDate = $('input.FromDate').val();
                let from_date = new Date(FromDate.replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
                let to_date;
                if (!isNaN(from_date.getTime())) {
                    let LeaveDays = parseInt($(this).val(), 10);
                    from_date.setDate(from_date.getDate() + LeaveDays - 1);
                    to_date = $.datepicker.formatDate('dd-mm-yy', new Date(from_date));
                    $('input.ToDate').val(to_date);
                }
            } else {
                $('input.ToDate').val(today);
            }
        });
        /*$('tbody.append_row').on('keyup', '.LeaveDays',function () { 
            if ($(this).val()) {
                let FromDate = $(this).closest('tr').find('td input.FromDate').val();
                let from_date = new Date(FromDate.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
                let to_date;
                if (!isNaN(from_date.getTime())) {
                    let LeaveDays = parseInt($(this).val(),10);
                    from_date.setDate(from_date.getDate() + LeaveDays-1);
                    to_date = $.datepicker.formatDate('dd-mm-yy', new Date(from_date));
                    $(this).closest('tr').find('td input.ToDate').val(to_date);
                }
            }else{console.log('else-');
                $(this).closest('tr').find('td input.ToDate').val(today);
            }
        });*/
    });
</script>