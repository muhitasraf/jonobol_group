<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">            
                <div class="row">
                    <div class="col-sm-12 col-xl-12 card card-info card-outline">
                        <div class="d-print-none"><?php echo $title; ?></div>
                    </div>      
                    <div class="col-sm-2 col-xl-2 d-print-none">
                        <div class="form-group">
                            <label class="m-0" for="Department">Employee Code</label>
                            <?php echo form_input('EmployeeCode','text',null,'class="form-control form-control-sm EmployeeCode" id="EmployeeCode" placeholder="Employee Code"'); ?>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xl-2 d-print-none">
                        <div class="form-group">
                            <label class="m-0" for="Department">Department</label>
                            <?php echo form_select('Department',$department,null,'class="form-control form-control-sm Department" id="Department" placeholder="Department"'); ?>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xl-2 d-print-none">
                        <div class="form-group">
                            <label class="m-0" for="Designation">Designation</label>
                            <?php echo form_select('Designation',$designation,null,'class="form-control form-control-sm Designation" id="Designation" placeholder="Designation"'); ?>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xl-2 d-print-none">
                        <div class="form-group">
                            <label class="m-0" for="Section">Section</label>
                            <?php echo form_select('Section',$section,null,'class="form-control form-control-sm Section" id="Section" placeholder="Section"'); ?>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xl-2 d-print-none">
                        <div class="form-group p-1 mb-1">
                            <label class="m-0" for="StaffCategory">Staff Category</label>
                            <?php echo form_select('StaffCategory',$staff_category,null,'class="form-control form-control-sm StaffCategory" id="StaffCategory" placeholder="Staff Category"'); ?>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group mb-1">
                            <label class="m-0" for="FromDate">Month</label>
                            <?php
                                echo form_input('Month','text',date('F'),'class="form-control form-control-sm form_month" autocomplete="off" id="Month"');
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group mb-1">
                            <label class="m-0" for="ToDate">Year</label>
                            <?php
                                echo form_input('Year','text',date('Y'),'class="form-control form-control-sm form_year" autocomplete="off" id="Year"');
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group mb-1">
                            <label class="m-0" for="">Display In Report</label>
                            <div class="form-check-inline">
                                <div class="form-check-inline ml-3">
                                    <input class="form-check-input code" type="checkbox" id="cbCode" value="1" name="cbCode" checked>
                                    <label class="form-check-label" for="cbCode">Code</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input name" type="checkbox" id="cbName" value="1" name="cbName">
                                    <label class="form-check-label" for="cbName">Name</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input DOJ" type="checkbox" id="cbDoj" value="1" name="cbDoj">
                                    <label class="form-check-label" for="cbDoj">DOJ</label>
                                </div>
                                <div class="form-check-inline ml-3">
                                    <input class="form-check-input Designation" type="checkbox" id="cbDesignation" value="1" name="cbDesignation">
                                    <label class="form-check-label" for="cbDesignation">Designation</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input Section" type="checkbox" id="cbSection" value="1" name="cbSection">
                                    <label class="form-check-label" for="cbSection">Section</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input Department" type="checkbox" id="cbDepartment" value="1" name="cbDepartment">
                                    <label class="form-check-label" for="cbDepartment">Department</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input cbStaffCat" type="checkbox" id="cbStaffCat" value="1" name="cbDoj">
                                    <label class="form-check-label" for="cbStaffCat">Staff Category</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-sm btn-info float-right btn-get-data">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-12 col-xl-12">
                        <!-- card -->
                        <div class="card card-info-x card-outline print-employee-info d-print-block">
                            <div class="card-body-x p-3">
                                <div class="row">
                                    <button class="btn btn-info float-left btn-sm ml-3 btn-export d-print-none">
                                        <i class="fa fa-file-excel fa-x"></i>
                                    </button>
                                    <button class="btn btn-info float-left btn-sm ml-3 btn-print-landscape d-print-none">
                                        <i class="fa fa-print fa-x"></i>
                                    </button>
                                </div>
                                <div class="row content-data">
                                </div>
                                <div class="row d-print-none">
                                    <div class="text-center p-3 spinner" style="display: none;">
                                        <strong>Loading ...</strong>
                                        <div class="spinner-border text-info" role="status"> </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.card-body -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>
    $(function () {
        $('.btn-get-data').on('click',function () {
            //show spinner after btn click at process startup.
            $('div.spinner').show();

            let EmployeeCode = $('.EmployeeCode').val();
            let Department = $('.Department').val();
            let Designation = $('.Designation').val();
            let Section = $('.Section').val();
            let StaffCategory = $('.StaffCategory').val();
            let Month = $('#Month').val();
            let Year = $('#Year').val();

            let cbCode = $('#cbCode:checked').val();
            let cbName = $('#cbName:checked').val();
            let cbDoj = $('#cbDoj:checked').val();
            let cbDesignation = $('#cbDesignation:checked').val();
            let cbSection = $('#cbSection:checked').val();
            let cbDepartment = $('#cbDepartment:checked').val();
            let cbStaffCat = $('#cbStaffCat:checked').val();

            let url = "<?php echo route('reports/payment/monthly_salary_without_ot_result'); ?>";
            $.get(url,{EmployeeCode,Department, Designation, Section,StaffCategory, Month, Year, cbCode, cbName, cbDoj, cbDesignation, cbSection, cbDepartment,cbStaffCat },function (data) {
                //hide spinner after data loaded.
                $('div.spinner').hide();
                $('div.content-data').empty().append(data);
            });
        });
    });
</script>