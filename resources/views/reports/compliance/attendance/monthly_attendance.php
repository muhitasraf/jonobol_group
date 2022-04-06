<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class="d-print-none"><?php echo $title; ?></div>
                <div class="row">
                    <!-- left column -->
                    <div class="col-sm-3 d-print-none">
                        <form action="">
                            <!-- card -->
                            <div class="card card-info card-outline">
                                <div class="card-body-x p-1">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group mb-1">
                                                        <label class="m-0" for="FromDate">From Date</label>
                                                        <?php
                                                        echo form_input('FromDate','text',date('d-m-Y'),'class="form-control form-control-sm form_date" autocomplete="off" id="FromDate" readonly');
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group mb-1">
                                                        <label class="m-0" for="ToDate">To Date</label>
                                                        <?php
                                                        echo form_input('ToDate','text',date('d-m-Y'),'class="form-control form-control-sm form_date" autocomplete="off" id="ToDate" readonly');
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group p-1 mb-1">
                                                <label class="m-0" for="Department">Department</label>
                                                <?php echo form_select('Department',$department,null,'class="form-control form-control-sm Department" id="Department" placeholder="Department"'); ?>
                                            </div>
                                            <div class="form-group p-1 mb-1">
                                                <label class="m-0" for="Designation">Designation</label>
                                                <?php echo form_select('Designation',$designation,null,'class="form-control form-control-sm Designation" id="Designation" placeholder="Designation"'); ?>
                                            </div>
                                            <div class="form-group p-1 mb-1">
                                                <label class="m-0" for="Section">Section</label>
                                                <?php echo form_select('Section',$section,null,'class="form-control form-control-sm Section" id="Section" placeholder="Section"'); ?>
                                            </div>
                                            <div class="form-group p-1 mb-1">
                                                <label class="m-0" for="StaffCategory">Staff Category</label>
                                                <?php echo form_select('StaffCategory',$staff_category,null,'class="form-control form-control-sm StaffCategory" id="StaffCategory" placeholder="Staff Category"'); ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="m-0" for="Department">EmployeeCode</label>
                                                <?php echo form_input('EmployeeCode','text',null,'class="form-control form-control-sm EmployeeCode" id="EmployeeCode" placeholder="EmployeeCode"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 mt-2">
                                            <div class="form-group mb-1">
                                                <label class="m-0" for="FromDate">Display</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-check-inline">
                                            <div class="form-check-inline ml-3">
                                                <input class="form-check-input code" type="checkbox" id="cbCode" value="1" name="cbCode">
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
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-check-inline">
                                            <div class="form-check-inline ml-3">
                                                <input class="form-check-input Designation" type="checkbox" id="cbDesignation" value="1" name="cbDesignation">
                                                <label class="form-check-label" for="cbDesignation">Designation</label>
                                            </div>
                                            <div class="form-check-inline">
                                                <input class="form-check-input Section" type="checkbox" id="cbSection" value="1" name="cbSection">
                                                <label class="form-check-label" for="cbSection">Section</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-check-inline">
                                            <div class="form-check-inline ml-3">
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
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-info float-right btn-get-data" type="button">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-9">
                        <!-- card -->
                        <div class="card card-info-x card-outline print-employee-info d-print-block">
                            <div class="card-body-x p-3">
<!--                                <a class="btn btn-info float-right btn-sm ml-3 btn-export d-print-none" href="--><?php //echo route('reports/employee/export_as_excel'); ?><!--">-->
<!--                                    <i class="fa fa-file-excel fa-x"></i>-->
<!--                                </a>-->
<!--                                <button class="btn btn-info float-right btn-sm ml-3 btn-print-landscape d-print-none">-->
<!--                                    <i class="fa fa-print fa-x"></i>-->
<!--                                </button>-->
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
            let FromDate = $('input[name="FromDate"]').val();
            let ToDate = $('input[name="ToDate"]').val();

            let cbCode = $('#cbCode:checked').val();
            let cbName = $('#cbName:checked').val();
            let cbDoj = $('#cbDoj:checked').val();
            let cbDesignation = $('#cbDesignation:checked').val();
            let cbSection = $('#cbSection:checked').val();
            let cbDepartment = $('#cbDepartment:checked').val();
            let cbStaffCat = $('#cbStaffCat:checked').val();

            let url = "<?php echo route('reports/attendance/monthly_attendance_result'); ?>";
            $.get(url,{EmployeeCode,Department, Designation, Section, StaffCategory, FromDate, ToDate, cbCode, cbName, cbDoj, cbDesignation, cbSection, cbDepartment,cbStaffCat },function (data) {
                //hide spinner after data loaded.
                $('div.spinner').hide();
                $('div.content-data').empty().append(data);
            });
        });
    });
</script>