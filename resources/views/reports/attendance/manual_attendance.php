<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-2 pb-0">
        <div class="container-fluid">
            <div class="d-print-none"><?php echo $title; ?></div>
                <div class="row">
                    <!-- left column -->
                    <div class="col-sm-12 d-print-none">
                        <form action="">
                            <!-- card -->
                            <div class="card card-info card-outline">
                                <div class="card-body-x p-1">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <div class="form-group mb-1">
                                                        <label class="m-0" for="FromDate">From Date</label>
                                                        <?php
                                                        echo form_input('FromDate','text',date('d-m-Y'),'class="form-control form-control-sm form_date" autocomplete="off" id="FromDate" readonly');
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <div class="form-group mb-1">
                                                        <label class="m-0" for="ToDate">To Date</label>
                                                        <?php
                                                        echo form_input('ToDate','text',date('d-m-Y'),'class="form-control form-control-sm form_date" autocomplete="off" id="ToDate" readonly');
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group mb-1">
                                                        <label class="m-0" for="ToDate">EmployeeCode</label>
                                                        <?php echo form_input('EmployeeCode','text',null,'class="form-control form-control-sm EmployeeCode" id="EmployeeCode" placeholder="EmployeeCode"'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group mb-1">
                                                        <label class="m-0" for="ToDate">Department</label>
                                                        <?php echo form_select('Department',$department,null,'class="form-control form-control-sm Department" id="Department" placeholder="Department"'); ?>
                                                    </div>
                                                </div>
                                                <!--div class="col-sm-2">
                                                    <div class="form-group mb-1">
                                                        <label class="m-0" for="ToDate">Designation</label>
                                                        <?php //echo form_select('Designation',$designation,null,'class="form-control form-control-sm Designation" id="Designation" placeholder="Designation"'); ?>
                                                    </div>
                                                </div-->
                                                <div class="col-sm-2">
                                                    <div class="form-group mb-1">
                                                        <label class="m-0" for="ToDate">Section</label>
                                                        <?php echo form_select('Section',$section,null,'class="form-control form-control-sm Section" id="Section" placeholder="Section"'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group mb-1">
                                                        <label class="m-0" for="ToDate">Staff Category</label>
                                                        <?php echo form_select('StaffCategory',$staff_category,null,'class="form-control form-control-sm StaffCategory" id="StaffCategory" placeholder="Staff Category"'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-sm btn-info float-right btn-get-data" type="button">
                                                            <i class="fa fa-search"></i> Search
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                            </div>
                        </form>
                    </div>
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
            let Section = $('.Section').val();
            let StaffCategory = $('.StaffCategory').val();
            let FromDate = $('input[name="FromDate"]').val();
            let ToDate = $('input[name="ToDate"]').val();           

            let url = "<?php echo route('reports/attendance/manual_attendance_result'); ?>";
            $.get(url,{EmployeeCode,Department, Section, StaffCategory, FromDate, ToDate },function (data) {
                //hide spinner after data loaded.
                $('div.spinner').hide();
                $('div.content-data').empty().append(data);
            });
        });
    });
</script>