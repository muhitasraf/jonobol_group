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
                            <span class="card-title">Salary Fixed Deduction</span>
                        </div>
                        <form action="<?php echo route("salary/fixed_deduct/save"); ?>" class="role" method="post">
                            <div class="card-body-x p-1">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group mb-1">
                                           
                                            <label class="m-0" for="from_date">From Date</label>
                                            <?php
                                            //dd($from_date);
                                            echo form_input('from_date', 'text', date_conversion('d-m-Y',$from_date), 'class="form-control form-control-sm form_date" autocomplete="off" id="from_date" required');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group mb-1">
                                            <label class="m-0" for="to_date">To Date</label>
                                            <?php
                                            echo form_input('to_date', 'text', date_conversion('d-m-Y',$to_date), 'class="form-control form-control-sm form_date" autocomplete="off" id="to_date" required');
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
                                            <th class="text-center">PF</th>
                                            <th class="text-center">TAX</th>
                                            <th class="text-center">FOOD</th>
                                        </tr>
                                    </thead>
                                    <tbody class="append_row">

                                        <tr>
                                            <td><button type="button" class="btn-xs btn-danger remove_row">X</button></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm emp_code" name="emp_code[]" autocomplete="off">
                                                <input type="hidden" class="form-control form-control-sm emp_id" name="emp_id[]" autocomplete="off">
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
                                            <td><input type="text" class="form-control form-control-sm pf inputkey" name="pf[]" autocomplete="off" data-index="1"></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm tax inputkey" name="tax[]" autocomplete="off" data-index="2">
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm food inputkey" name="food[]" autocomplete="off" data-index="3"></td>
                                        </tr>
                                        <tr style="display:none;">
                                            <td><button type="button" class="btn-xs btn-danger remove_row">X</button></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm emp_code" name="emp_code[]" autocomplete="off">
                                                <input type="hidden" class="form-control form-control-sm emp_id" name="emp_id[]" autocomplete="off">
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
                                            <td><input type="text" class="form-control form-control-sm pf inputkey" name="pf[]" autocomplete="off" data-index="1"></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm tax inputkey" name="tax[]" autocomplete="off" data-index="2">
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm food  inputkey" name="food[]" autocomplete="off" data-index="3"></td>
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
            <!-- /.card-body -->
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>
    /*Focus Next*/
    $(document).ready(function() {
        $("tbody.append_row").on('keypress', '.pf', function(e) {
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

        $("tbody.append_row").on('keypress', '.tax', function(e) {
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
        

        /*Add Row*/
        var currentRow = $("table.row_add tbody.append_row tr:last").html();
        //alert(currentRow); 
        $(".add_more_button").click(function() {
            for (var k = 0; k < 10; k++) {
                $("table.row_add").append('tbody.append_row <tr>' + currentRow + '</tr>');
            }
            $('.date_picker').datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $(".select2").select2();
        });
        $(".add_button").click(function() {
            $("table.row_add").append('tbody.append_row <tr>' + currentRow + '</tr>');
        });
        //remove tr of stock table
        $('table.row_add,table.employee-salary_insert_deduct-x').on('click', '.remove_row', function() {
            $(this).closest('tr').remove();
        });

        $("tbody.append_row").on("keypress", '.emp_code', function(event) {
            var emp_id = $(this).val();
            var year = $('#Year').val();
            var month = $('#Month').val();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var $_this = $(this);
            var keyPressed = event.keyCode || event.which;
            if (keyPressed === 13) {
                if (emp_id) {
                    $.ajax({
                        type: 'get',
                        url: 'get_deduct_data',
                        data: {
                            'emp_id': emp_id,
                            'from_date': from_date,
                            'to_date': to_date,
                            'status':'1'
                        },
                        success: function(data) {
                            console.log(data);
                            var get_employee_info = $.parseJSON(data);
                            $_this.val(get_employee_info.EmployeeCode);
                            $_this.closest('tr').find('input.emp_id').val(get_employee_info.id);
                            $_this.closest('tr').find('input.emp_name').val(get_employee_info.EmployeeName);
                            $_this.closest('tr').find('input.section').val(get_employee_info.section);
                            $_this.closest('tr').find('input.doj').val(get_employee_info.DOJ);
                            $_this.closest('tr').find('input.pf').focus();
                            $_this.closest('tr').find('input.pf').val(get_employee_info.pf);
                            $_this.closest('tr').find('input.tax').val(get_employee_info.tax);
                            $_this.closest('tr').find('input.food').val(get_employee_info.food);
                            /*$_this.closest('tr').find('input.pf').val(get_employee_info.advance);
                            $_this.closest('tr').find('input.tax').val(get_employee_info.loan);
                            $_this.closest('tr').find('input.food').val(get_employee_info.bakery);*/
                            // $.ajax({
                            //     type: 'post',
                            //     url: 'fixed_deduct/data',
                            //     data: {
                            //         'emp_id': get_employee_info.id,
                            //         'from_date': from_date,
                            //         'to_date': to_date
                            //     },
                            //     success: function(data) {
                            //         console.log(data);
                            //         var get_employee_info = $.parseJSON(data);
                            //         // var get_employee_info = $.parseJSON(data);
                            //         // $_this.val(get_employee_info.EmployeeCode);                            
                            //         // $_this.closest('tr').find('input.emp_id').val(get_employee_info.id);
                            //         // $_this.closest('tr').find('input.emp_name').val(get_employee_info.EmployeeName);
                            //         // $_this.closest('tr').find('input.section').val(get_employee_info.section);
                            //         // $_this.closest('tr').find('input.doj').val(get_employee_info.DOJ);
                            //         // $_this.closest('tr').find('input.pf').focus();
                            //         $_this.closest('tr').find('input.pf').val(get_employee_info.pf);
                            //         $_this.closest('tr').find('input.tax').val(get_employee_info.tax);
                            //         $_this.closest('tr').find('input.food').val(get_employee_info.food);
                            //     }
                            // });
                        }
                    });


                }
                event.preventDefault();
            }
        });
        /*$('tbody.append_row').on('keyup','.emp_code',function(e){
            //var prd_key = $(this).val();
            var search = $(this).val();
            var code = (e.keyCode ? e.keyCode : e.which);
            var $_this = $(this);
            if(code==13){ // Enter key hit  
                var emp_id = $(this).closest('tr').find("td input.emp_id").val();
                if(search){ 
                    $.ajax({
                        type: 'get',
                        url: 'get_employee_info',
                        data: {'search':search,'emp_id':emp_id},
                        success: function (data) {
                            var get_employee_info = $.parseJSON(data);
                            $_this.closest('tr').find('td input.emp_name').val(get_employee_info.EmployeeName);
                            $_this.closest('tr').find('td input.pf').focus();
                        }
                    });
                }else{ 
                    $_this.closest('tr').find('td input.emp_id').val('');
                } 
            }
            else{
                $(this).autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "search",
                            type: "GET",
                            data: {'search':search},                        
                            dataType: "json",
                            success: function (data) { console.log(data);
                                response( $.map( data, function( item ) { 
                                    return {
                                        label: item.label,
                                        emp_id: item.emp_id
                                    };
                                })); 
                            }
                        });
                    }, 
                    focus: function(event, ui) {
                        // prevent autocomplete from updating the textbox
                        event.preventDefault();
                        // manually update the textbox
                        $_this.val(ui.item.label);
                    },        
                    select: function (event, ui) {     
                       $_this.closest('tr').find("input.emp_id").val(ui.item.emp_id);              
                    }
                }); 
            }           
        });*/
    });
</script>