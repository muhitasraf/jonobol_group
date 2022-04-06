<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class=""><?php echo $title; ?></div>
                    <div class="card card-info card-outline">
                        <ul class="nav nav-tabs p-1" id="custom-content-above-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="step-one" data-toggle="pill" href="#step_one" role="tab" aria-controls="step_one" aria-selected="true">Step One</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="step-two" data-toggle="pill" href="#step_two" role="tab" aria-controls="step_two" aria-selected="false">Step Two</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="step-three" data-toggle="pill" href="#step_three" role="tab" aria-controls="step_three" aria-selected="false">Step Three</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="custom-content-above-tabContent">
                            <div class="tab-pane fade show active" id="step_one" role="tabpanel" aria-labelledby="step-one">
                                <div class="card">
                                    <span class="bg-info pl-2">Employee Status</span>
                                    <div class="card-group pt-1"><!-- card-deck -->
                                        <!-- left column -->
                                        <div class="col-sm-12">
                                            <!-- general form elements -->
                                            <div class="card card-info">
                                                <div class="card-body-x p-1">
                                                    <div class="row">
                                                        <div class="col-sm-3 mt-4">
                                                            <div class="form-check form-check-inline">
                                                                <h5>Employee Status</h5>
                                                                <input type="button" class="btn btn-info btn-sm float-right go-step-two ml-3" data-next="step-two" value="Go" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                                
                                            </div>
                                            <!-- /.card -->
                                        </div><!--/.col (center) -->
                                        <!-- right column -->
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <div class="tab-pane fade" id="step_two" role="tabpanel" aria-labelledby="step-two">
                                <div class="card">
                                    <div class="card-group pt-1"><!-- card-deck -->
                                        
                                        <div class="col-sm-9">
                                            <div class="card card-primary">
                                                <!-- /.card-body -->
                                                <div class="card card-primary">
                                                    <span class="bg-info text-center">Employee Food Loan</span>
                                                    <div class="card-body-x p-3 scroll-div">
                                                        <div class="text-center p-3 spinner">
                                                            <strong>Loading...</strong>
                                                            <div class="spinner-border text-info" role="status"> </div>
                                                        </div>
                                                        <table class="table table-sm table-bordered dataTableEmployeeInfo">
                                                            <thead>
                                                                <tr class="table-success">
                                                                    <th></th>
                                                                    <th>Code</th>
                                                                    <th>Name</th>
                                                                    <th>Unit</th>
                                                                    <th>Section</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="employee-tbody">
                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="form-group ml-4">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input all_employee_cb" type="checkbox" id="inlineCheckbox1" value="1" name="all_employee_cb" checked>
                                                            <label class="form-check-label" for="inlineCheckbox1">Select All</label>
                                                        </div>
                                                        <!-- /input-group -->
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>
                                                <div class="card-footer">
                                                    <input type="button" class="btn btn-info btn-sm float-right ml-2 go-step-three" data-next="step-three" value="Next" />
                                                    <input type="button" class="btn btn-info btn-sm float-right" data-next="step-one" name="step-one" value="Back" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <div class="tab-pane fade" id="step_three" role="tabpanel" aria-labelledby="step-three">
                                <form action="<?php //echo route("attendance/manual_store");?>" class="role" method="post" name="employee_step_three">
                                    <div class="card">
                                        <div class="card card-primary">
                                            <!-- /.card-body -->
                                            <div class="card card-primary">
                                                <div class="card-body-x p-3 scroll-div">
                                                    <div class="text-center p-3 spinner">
                                                        <strong>Loading...</strong>
                                                        <div class="spinner-border text-info" role="status"> </div>
                                                    </div>
                                                    <table class="table table-sm table-bordered dataTableAttendance">
                                                        <thead>
                                                            <tr class="table-success">
                                                                <th>Code</th>
                                                                <th>Employee Name</th>
                                                                <th>Status</th>
                                                                <th>Effected Date</th>                                                                
                                                                <th>Cause</th>                                                                
                                                                <th>6</th>                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody class="employee-daily-info">
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                                <div class="card-footer">
                                                    <input type="button" class="btn btn-info btn-sm float-right ml-2" data-next="step-two" value="Back" />
                                                </div>
                                            </div>
                                            <div class="text-center p-3 save-spinner" style="display: none;">
                                                <strong>Loading...</strong>
                                                <div class="spinner-border text-info" role="status"> </div>
                                            </div>
                                            <div class="offset-sm-4 msg"></div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-danger btn-sm float-right btn-delete" name="delete">Delete</button>
                                                <button type="button" class="btn btn-info btn-sm float-right btn-save mr-2" name="Save">Save</button>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script>
    $('input[type=button]').click(function () {
        let getId = $(this).data('next');
        $('#'+getId).click();
    });
    $('.go-step-two').one('click',function () {
        let url = "<?php echo route('attendance/get_employee'); ?>";
        $.get(url,{},function (data) {
            //console.log(data);
            $('.employee-tbody').empty().html(data);
            //hide spinner after data loaded.
            $('.employee-tbody').closest('div').find('div.spinner').hide();

            dataTablePlaceHolder('.dataTableEmployeeInfo');
        });
    });
    $('.all_employee_cb').change(function () {
        if ($(this).is(":checked")) {
            $('.employee-tbody').find('.employee_id').attr('checked',true);
        }
        else {
            $('.employee-tbody').find('.employee_id').attr('checked',false);
        }
    });
    $('.all_employee_cb').trigger('change');

     $('.go-step-three').one('click',function () {

        let employee_id = [];
        let employee_code = [];
        let section = [];
        let employee_name = [];
        $.each($(".employee_id:checked"),function(i) {
            employee_id[i] = $(this).val();
        });
        $.each($(".employee_id:checked"),function(i) {
            employee_code[i] = $(this).next('input.employee_code').val();
        });
        $.each($(".employee_id:checked"),function(i) {
            section[i] = $(this).next().next('input.section').val();
        });
        $.each($(".employee_id:checked"),function(i) {
            employee_name[i] = $(this).closest('tr').find('td.emp_name').text();
        });
        employee_id = JSON.stringify(employee_id);
        employee_name = JSON.stringify(employee_name);
        employee_code = JSON.stringify(employee_code);
        section = JSON.stringify(section);

        let url = "<?php echo route('employee/employee_statusinfo'); ?>";
        $.post(url,{employee_id,employee_name,employee_code,section},function (data) {
            console.log("Checking The Route");
            $('.employee-daily-info').empty().html(data);
            $('.employee-daily-info').closest('div').find('div.spinner').hide();
            dataTablePlaceHolder('.dataTableAttendance');
            
        });
        // console.log("from_date:"+from_date);
        // console.log("to_date:"+to_date);
        // //console.log("shiftID:"+shiftID);
        // console.log("employee_code:"+employee_code);
    });

    $('.btn-save').one('click',function () {
        $('.save-spinner').show();

        // let employee_id = [];
        // $.each($(".employee_id:checked"),function(i) {
        //     employee_id[i] = $(this).val();
        // });
        // employee_id = JSON.stringify(employee_id);

        let EmployeeID = [];
        $.each($('.EmployeeID'),function(i) {
            EmployeeID[i] = $(this).val();
        });
        EmployeeID = JSON.stringify(EmployeeID);

        let AdjustLoan = [];
        $.each($('.AdjustLoan'),function(i) {
            AdjustLoan[i] = $(this).val();
        });
        AdjustLoan = JSON.stringify(AdjustLoan);
        
        let FoodAllowance = [];
        $.each($('.FoodAllowance'),function(i) {
            FoodAllowance[i] = $(this).val();
        });
        FoodAllowance = JSON.stringify(FoodAllowance);     

        let form = {
            'EmployeeID' : EmployeeID,
            'AdjustLoan' : AdjustLoan,
            'FoodAllowance' : FoodAllowance,
        } ;

        //console.log(form);
        let url = "<?php echo route('employee/employee_loaninfo_store'); ?>";
        $.post(url,form,function (data) {console.log(data);
            //hide spinner after data loaded.
            $('.save-spinner').hide();
            $('div.msg').empty().append("<h1 class='text text-primary ml-5 font-italic'>"+data+"</h1>");
        });
    });
</script>