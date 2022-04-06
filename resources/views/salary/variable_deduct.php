<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class=""><?php echo $title; ?></div>
                <div class="row">
                    <div class="col-sm-10">
                        <!-- card -->
                        <div class="card card-info card-outline insert_deduct">
                            <div class="card-header p-1">
                                <span class="card-title">Salary Variable Deduction</span>
                            </div>
                            <form action="<?php echo route("salary/variable_deduct/save");?>" class="role" method="post">
                                <div class="card-body-x p-1">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group mb-1">
                                                <label class="m-0" for="FromDate">Month</label>
                                                <?php
                                                echo form_input('Month','text',date('F'),'class="form-control form-control-sm form_month" autocomplete="off" id="Month"');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group mb-1">
                                                <label class="m-0" for="ToDate">Year</label>
                                                <?php
                                                echo form_input('Year','text',date('Y'),'class="form-control form-control-sm form_year" autocomplete="off" id="Year"');
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table row_add table-sm table-bordered dataTableEmployeeInfo">
                                        <thead>            
                                            <tr>
                                                <th>❌</th>
                                                <th class="text-center" style="width:130px !important;">Emp.Code</th>
                                                <th class="text-center" style="width:220px !important;">Emp.Name</th>
                                                <th class="text-center" style="width:120px !important;">DOJ</th>
                                                <th class="text-center" style="width:150px !important;">Section</th>
                                                <th class="text-center">Advance</th>
                                                <th class="text-center">Loan</th>
                                                <th class="text-center">Bakery</th>
                                                <th class="text-center" >Others</th>
                                            </tr>
                                        </thead>
                                        <tbody class="append_row">
                                            
                                            <tr>
                                                <td><button type="button" class="btn-xs btn-danger remove_row">X</button></td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm emp_code" name="emp_code[]"  autocomplete="off" >
                                                    <input type="hidden" class="form-control form-control-sm emp_id" name="emp_id[]"  autocomplete="off" >
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm emp_name" name="emp_name[]" autocomplete="off" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm doj" name="doj[]" autocomplete="off" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm section" name="section[]" autocomplete="off" readonly>
                                                </td>
                                                <td><input type="text" class="form-control form-control-sm advance inputkey" name="advance[]" autocomplete="off"></td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm loan inputkey" name="loan[]" autocomplete="off">
                                                </td>
                                                <td><input type="text" class="form-control form-control-sm bakery inputkey" name="bakery[]" autocomplete="off"></td>
                                                <td><input type="text" class="form-control form-control-sm others inputkey" name="others[]" autocomplete="off"></td>
                                            </tr>                                                                    
                                            <tr style="display:none;">
                                                <td><button type="button" class="btn-xs btn-danger remove_row">X</button></td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm emp_code" name="emp_code[]"  autocomplete="off" >
                                                    <input type="hidden" class="form-control form-control-sm emp_id" name="emp_id[]"  autocomplete="off" >
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm emp_name" name="emp_name[]" autocomplete="off" >
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm doj" name="doj[]" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm section" name="section[]" autocomplete="off">
                                                </td>
                                                <td><input type="text" class="form-control form-control-sm advance inputkey" name="advance[]" autocomplete="off"></td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm loan inputkey" name="loan[]" autocomplete="off">
                                                </td>
                                                <td><input type="text" class="form-control form-control-sm bakery inputkey" name="bakery[]" autocomplete="off"></td>
                                                <td><input type="text" class="form-control form-control-sm others inputkey" name="others[]" autocomplete="off"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <INPUT type="button" value="Add row" class="add_button btn btn-warning" />
                                    <input type="submit" class="btn btn-info float-right" value="Save" />
                                </div>
                            </form>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!--/.col (left) -->
                </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script>
    $(document).ready(function(){
        /*Add Row*/  
        var currentRow = $("table.row_add tbody.append_row tr:last").html();
        //alert(currentRow); 
        $(".add_more_button").click(function() { 
            for(var k=0; k<10; k++){
                $("table.row_add").append('tbody.append_row <tr>'+currentRow+'</tr>'); 
            }
            $('.date_picker').datepicker({  dateFormat: 'yy-mm-dd' });
            $(".select2").select2();
        });
        $(".add_button").click(function() { 
            $("table.row_add").append('tbody.append_row <tr>'+currentRow+'</tr>'); 
        });
        //remove tr of stock table
        $('table.row_add,table.employee-salary_insert_deduct-x').on('click','.remove_row',function(){
            $(this).closest('tr').remove();
        });

        $("tbody.append_row").on("keypress",'.emp_code', function (event) {
            var emp_id = $(this).val();
            var year = $('#Year').val();
            var month = $('#Month').val();
            var $_this = $(this);
            var keyPressed = event.keyCode || event.which;
            if (keyPressed === 13) {                         
                if(emp_id){ 
                    $.ajax({
                        type: 'get',
                        url: 'get_deduct_data',
                        data: {'emp_id':emp_id,'month':month,'year':year,'status':2},
                        success: function (data) { 
                            console.log(data);
                            var get_employee_info = $.parseJSON(data);
                            $_this.val(get_employee_info.EmployeeCode);                            
                            $_this.closest('tr').find('input.emp_id').val(get_employee_info.id);
                            $_this.closest('tr').find('input.emp_name').val(get_employee_info.EmployeeName);
                            $_this.closest('tr').find('input.section').val(get_employee_info.section);
                            $_this.closest('tr').find('input.doj').val(get_employee_info.DOJ);
                            $_this.closest('tr').find('input.advance').val(get_employee_info.advance);
                            $_this.closest('tr').find('input.loan').val(get_employee_info.loan);
                            $_this.closest('tr').find('input.bakery').val(get_employee_info.bakery);
                            $_this.closest('tr').find('input.others').val(get_employee_info.others);
                            console.log(get_employee_info.advance);
                            if(get_employee_info.advance==null){
                                $_this.closest('tr').find('input.advance').focus();
                            }else{
                                $_this.closest('tr').find('input.others').focus();
                            }
                        }
                    });
                }
                event.preventDefault();
            }
        });
        $("tbody.append_row").on('keypress', '.advance', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $('.loan').focus();
            }
        });

        $("tbody.append_row").on('keypress', '.loan', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $('.bakery').focus();
            }
        });
        $("tbody.append_row").on('keypress', '.bakery', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                // Get all focusable elements on the page
                var $canfocus = $('.inputkey');
                var index = $canfocus.index(document.activeElement) + 1;
                if (index >= $canfocus.length) {
                    index = 0;
                }
                $canfocus.eq(index).focus();
            }
        });
    });
</script>